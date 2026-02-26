<?php

namespace App\Http\Requests;

use App\Rules\RussianLettersPercentage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool //Determine if the user is authorized to make this request.
    {
        return true; //разрешаем Request неавторизированным пользователям
    }

    public function rules(): array //Get the validation rules that apply to the request (@return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>).
    {
        return [
            'name' => [
                'required',
                //new RussianLettersPercentage(), // Используем наше кастомное правило
                'max:255',
            ],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
    public function messages(): array
    {
        return [
            //Сообщения для свойства name
            'name.required' => 'Поле "Имя" обязательно для заполнения!',
            'name.max' => 'Имя не может быть длинее 255 символов!',
            //Сообщения для свойства email
            'email.required' => 'Поле "E-mail" обязательно для заполнения!',
            'email.email' => 'Введите корректный адрес электронной почты!',
            'email.max' => 'E-mail не может быть длинее 255 символов!',
            'email.unique' => 'Пользователь с таким E-mail уже зарегистрирован!',
            //Сообщения для свойства password
            'password.required' => 'Поле "Пароль" обязательно для заполнения!',
            'password.min' => 'Пароль не может быть меньше 6 символов!',
            'password.confirmed' => 'Пароли не совпадают!',
       ];
    }
}
