<?php

namespace App\Http\Requests;

use App\Rules\RussianLettersPercentage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route()->parameter('user'); //получаем user-а из параметра url

        return [
            'name' => [
                'required',
                //new RussianLettersPercentage(), // Используем наше кастомное правило
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => [
                'nullable',
                'min:8',
            ],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}
