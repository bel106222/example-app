<?php

namespace App\Repository;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserRepository
{
    final public function store(UserStoreRequest $userStoreRequest): User
    {
//        //методом query()->create, класса User, создаём нового пользователя из валидированных данных, полученных из UserStoreRequest
//        $user = User::query()->create($userStoreRequest->validated());
        //dd($userStoreRequest->file('avatar'));
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $user = new User();
            $user->name = $userStoreRequest->name;
            $user->email = $userStoreRequest->email;
            $user->password = Hash::make($userStoreRequest->password);
            //$user->slug = Str::slug($user->name);
            $user->save();

            if ($userStoreRequest->hasFile('avatar')) {
                $filePath = 'storage/' . $userStoreRequest->file('avatar')->store('avatars', 'public');
                Avatar::query()->create([
                    'user_id' => $user->id,
                    'path' => $filePath,
                ]);
            }
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $user;
    }
    final public function update(UserUpdateRequest $userUpdateRequest, User $user): User
    {
        //dd($userUpdateRequest->file('avatar'));
        //dd('storage/' . $userUpdateRequest->file('avatar')->store('avatars', 'public'));
       // dd(Avatar::query()->where('user_id', $user->id)->first());
//        $validated = $userUpdateRequest->validated(); //загружаем в массив отвалидированные данные
//        $user->name = $validated['name']; //полученному пользователю в поле name загружаем значение из отвалидированного массива
//        $user->email = $validated['email']; //тоже с почтой
//        //если изменения пароля не было, пропускаем его, иначе - берём из массива
//        if (!empty($validated['password'])) {
//            $user->password = $validated['password'];
//        }
//        $user->save(); //сохраняем изменённого пользователя
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $validated = $userUpdateRequest->validated(); //загружаем в массив отвалидированные данные
            $user->name = $validated['name']; //полученному пользователю в поле name загружаем значение из отвалидированного массива
            $user->email = $validated['email']; //тоже с почтой
            //если изменения пароля не было, пропускаем его, иначе - берём из массива
            if (!empty($validated['password'])) {
                $user->password = $validated['password'];
            }
            if ($userUpdateRequest->hasFile('avatar')) {
                $filePath = 'storage/' . $userUpdateRequest->file('avatar')->store('avatars', 'public');
                $newAvatar = Avatar::query()->where('user_id', $user->id)->first();
                unlink($newAvatar->path); //удаляем из storage старую аватарку
                $newAvatar->path = $filePath; //загружаем новую
                $newAvatar->save(); //сохраняем изменённую аватарку
            }
            $user->save(); //сохраняем изменённого пользователя
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $user->refresh();
    }
    final public function destroy(User $user): bool
    {
        return $user->delete();
    }
}
