<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::query()->get();
        $currentUser = $users->random();

        return [
            'orderNumber' => fake()->numberBetween(1, 1000),
            'orderDescription' => fake()->text(),
            'userId' => $currentUser->only(['id'])['id'],
            'isCompleted' => false,
            'isPaid' => false,
            'orderSum' => fake()->numberBetween(100, 1000)
        ];
    }
}
