<?php

namespace Database\Factories;

use App\Models\Books;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

class BooksFactory extends Factory
{
    protected $model = Books::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        $users = User::query()->get();
        $currentUser = $users->random();
        //$currentUserId = $currentUser->pluck('id');
        //$subset = $users->map->only(['id', 'name', 'email']);
        //dd($currentUser->only(['name'])['name']);
        //dd($currentUser->only(['id'])['id']);
        return [
            'title' => 'Book of ' . $currentUser->only(['name'])['name'],
            'user_id' => $currentUser->only(['id'])['id'],
            'created_at' => fake()->dateTime(),
        ];
    }

    private function array_get(array|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection $only, string $string)
    {
    }
}
