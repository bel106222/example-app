<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::factory(5)->create();
        Organization::factory()->create([
            'title' => 'Не установлено',
            'address' =>  'Не установлено',
            'details' => 'Не установлено',
            'isLegal' => 0,
        ]);
        Organization::factory()->create([
            'title' => 'Сервисный центр',
            'address' =>  'г. Ставрополь, ул. Ленина, 1',
            'details' => 'Банковские рек визиты ИНН КПП ОГРН р/с',
            'isLegal' => 1,
        ]);
    }
}
