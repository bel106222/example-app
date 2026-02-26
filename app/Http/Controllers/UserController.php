<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //создаём конструктор и в нём свойство UserRepository, для возможности использования репозитория
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }
    public function index() //Display a listing of the resource.
    {
        $users = User::query()->paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create() //Show the form for creating a new resource.
    {
        return view('users.create');
    }

    public function store(UserStoreRequest $userStoreRequest) //Store a newly created resource in storage.
    {
//        //dd($UserStoreRequest->file('avatar')); //информация о прикрепляемом файле
//        //dd($request->input()); //информация из запроса
//        $validatedData = $request->validate( //validate - метод класса request, проверяющий полученные в запросе данные
//            //1 аргумент - массив свойств класса User и правила, по которым они будут валидироваться
//            [
//                'name' => 'required|max:255',
//                'email' => 'required|email|max:255|unique:users',
//                'password' => 'required|min:6|confirmed',
//            ],
//            //2 аргумент - сообщения об ошибках валидации
//            [
//                //Сообщения для свойства name
//                'name.required' => 'Поле "Имя" обязательно для заполнения!',
//                'name.max' => 'Имя не может быть длиннее 255 символов!',
//                //Сообщения для свойства email
//                'email.required' => 'Поле "E-mail" обязательно для заполнения!',
//                'email.email' => 'Введите корректный адрес электронной почты!',
//                'email.max' => 'E-mail не может быть длиннее 255 символов!',
//                'email.unique' => 'Пользователь с таким E-mail уже зарегистрирован!',
//                //Сообщения для свойства password
//                'password.required' => 'Поле "Пароль" обязательно для заполнения!',
//                'password.min' => 'Пароль не может быть меньше 6 символов!',
//                'password.confirmed' => 'Пароли не совпадают!',
//            ]
//        );
//        $newUser = new User();
//        $newUser->name = $validatedData['name'];
//        $newUser->email = $validatedData['email'];
//        $newUser->password = Hash::make($validatedData['password']);
//        $newUser->save();
//
//        return redirect()->route('users.show', $newUser->id);
//        //методом query()->create, класса User, создаём нового пользователя из валидированных данных, полученных из UserStoreRequest
//        $newUser = User::query()->create([$userStoreRequest->validated()]);
//        //перебрасываем на страницу редактирования пользователя по новому id
//        return redirect()->route('users.show', $newUser->id);
        return redirect()->route(
            'users.show',
            $this->userRepository->store($userStoreRequest) //из репозитория получаем пользователя
        );
    }

    public function show(User $user) //Display the specified resource.
    {
        //$user = User::query()->find($id);
        //dd($user);
        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function edit(string $id) //Show the form for editing the specified resource.
    {
        //
    }
    public function update(UserUpdateRequest $userUpdateRequest, User $user) : RedirectResponse //Update the specified resource in storage.
    {
//        //Получаем из запроса проверенные, по заданным в массиве аргументам, данные и заполняем ими отвалидированный массив
//        $validatedData = $request->validate([
//            //'name' => 'required|max:255',
//            //'email' => 'required|email|max:255',
//            //'password' => 'required|min:6|confirmed',
//            'name' => ['required', 'max:255'],
//            //используя Rule, игнорируем повторный ввод уникального почтового ящика
//            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
//        ]);
//
//        /*
//        * Способ 1
//        * полученному пользователю, меняем значения свойств на те, что пришили в отвалидированном массиве
//        */
//        $user->name = $validatedData['name'];
//        $user->email = $validatedData['email'];
//        $user->password = Hash::make($validatedData['password']);
//        $user->save();
//
//        /*
//        * Способ 2
//        * тоже, но через метод update, класса User, предварительно захешировав пароль в отвалидированном массиве
//        */
//        $validatedData['password'] = Hash::make($validatedData['password']);
//        $user->update($validatedData);
//
//        //dd($request->input(), $user, $validatedData);
//
//        //возвращаем назад с сообщением об успехе операции
//        return redirect()->back()->with('success','Пользователь был удачно обновлён!');
        return redirect()->route(
        'users.show',
              $this->userRepository->update($userUpdateRequest, $user) //из репозитория получаем пользователя
        )->with('success','Пользователь был удачно обновлён!') ;
    }

    public function destroy(User $user) //Remove the specified resource from storage.
    {
        $userRemoveResult = $this->userRepository->destroy($user); // вернёт true, если удалился, иначе - false

        if ($userRemoveResult) {
            return redirect()->
            back()->
            with('success', 'Пользователь удален!');
        }

        return redirect()->
        back()->
        withErrors('errors', 'Ошибка при удалении!');
    }
}
