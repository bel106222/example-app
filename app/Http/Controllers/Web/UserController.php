<?php

namespace App\Http\Controllers\Web;

use App\Filters\UserFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Organization;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    //создаём конструктор и в нём свойство UserRepository, для возможности использования репозитория
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFilters $userFilters
    )
    {
    }
    public function index(Request $request) : View //Display a listing of the resource.
    {
        //получение текущего пользователя
        $currentUser1 = Auth::user(); // 1 способ - use Illuminate\Support\Facades\Auth;
        $currentUser2 = auth()->user(); // 2 способ - функция auth()
        //если вернулся null - пользователь не авторизировался

        $query = User::query();

//        dd($query->take(5)->get()); //берём первые 5 из коллекции query
//        dd(
//            $query->take(5)
//                ->select(['id', 'name', 'email'])
//                ->orderByDesc('id')
//                ->get()
//                ->toArray()
//        ); //запросили коллекцию из 5 объектов с конца и обернули в массив

//        $page = 3;
//        $perPage = 10;
//        dd(
//            $query
//                ->skip($page * $perPage - $perPage)
//                ->take($perPage)
//                ->get()
//        ); //c 3 страницы запросили коллекцию из 10 объектов

//        $usersIds = [2, 7, 10]; //массив значений id
//        dd(
//            $query->select(['id', 'name', 'email'])
//                ->whereIn('id', $usersIds)
//                ->get()
//        ); //запросили коллекцию объектов с id из массива

//        dd(
//            $query->select(['id', 'name', 'email'])
//                ->has('phones')
//                ->get()
//        ); //запросили коллекцию объектов имеющих телефоны (связь с таблицей phones)
//        $genres = Genre::query()->paginate(10);
//        $trashedGenres = Genre::onlyTrashed()->paginate(10);
//
//        return view('genres.index', ['genres' => $genres, 'trashedGenres' => $trashedGenres]);
        $organizations = Organization::query()->get();
        return view('users.index', [
            'users' => $this->userFilters
                ->apply($request, $query)
                ->paginate(10)
                ->withQueryString(),
            'organizations' => $organizations,
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
