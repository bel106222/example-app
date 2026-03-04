<?php
namespace App\Repository;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Avatar;
use App\Models\Books;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BookRepository
{
    final public function store(Request $request): Books
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $books = new Books([
                'title' => $request->title,
                'user_id' => $request->user_id,
            ]);
            $books->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $books;
    }
    final public function update(Request $request, Books $books): Books
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $books->update([
                'title' => $request->title,
                'user_id' => $request->user_id
            ]);
            $books->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $books;
    }
    final public function destroy(Books $books): bool
    {
        return $books->delete();
    }
}
