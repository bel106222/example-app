<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RussianLettersPercentage implements ValidationRule
{
    /**
     * Выполняет проверку на минимальное содержание русских букв (не менее 70%).
     *
     * @param string $attribute Имя атрибута.
     * @param mixed $value Значение атрибута.
     * @param \Closure(string $message): void $fail Функция для передачи сообщения об ошибке.
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // Подсчет количества русских букв
        preg_match_all('/[\p{Cyrillic}]/u', $value, $matches);

        // Общее количество символов
        $totalChars = mb_strlen($value);

        if ($totalChars > 0 && count($matches[0]) / $totalChars < 0.7) {
            $fail("Минимальное количество русских букв должно составлять 70%.");
        }
    }

    /**
     * Возвращает сообщение об ошибке.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Минимальное количество русских букв должно составлять 70%.';
    }
}
