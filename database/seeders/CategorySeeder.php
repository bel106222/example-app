<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
        "Организация локальной сети",
        "Ремонт и обслуживание оргтехники",
        "Ремонт компьютеров, ноутбуков, моноблоков",
        "ИТ-услуги по оргтехнике",
        "ИТ-услуги по компьютерам, ноутбукам, моноблокам",
        "ИТ-услуги по серверам и сетевому оборудованию"
        ];

        foreach ($categories  as $category) {
            Category::factory()->create([
                'categoryName' => $category,
            ]);
        }
    }
}
