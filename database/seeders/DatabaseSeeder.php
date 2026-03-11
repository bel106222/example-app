<?php

namespace Database\Seeders;

use App\Models\Books;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        //применяем правила создания пользователей
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        //Вызов дополнительных seeder-ов
        $this->call([
            OrganizationSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            PriceSeeder::class,
        ]);
    }
}
