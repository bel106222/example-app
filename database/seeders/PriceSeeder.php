<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Price;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prices = [
            [   //1
                "Монтаж кабельной сети (ЛВС)",
                "true",
                "1500"
            ],
            [   //2
                "Забор компьютерной техники в сервис",
                "false",
                "400"
            ],
            [   //3
                "Доставка компьютерной техники из сервиса",
                "false",
                "400"
            ],
            [   //4
                "Чистка, оптимизация операционной системы",
                "false",
                "1000"
            ],
            [   //5
                "Восстановление работоспособности ОС",
                "false",
                "1000"
            ],
            [   //6
                "Выезд к заказчику",
                "false",
                "500"
            ],
            [   //7
                "Ремонт оргтехники 1 категории сложности",
                "false",
                "1000"
            ],
            [   //8
                "Ремонт оргтехники 2 категории сложности",
                "false",
                "2000"
            ],
            [   //9
                "Ремонт оргтехники 3 категории сложности",
                "false",
                "3000"
            ],
            [   //10
                "Подключение принтеров, МФУ, сканеров и т.д.",
                "false",
                "1000"
            ],
            [   //11
                "Заправка картриджей",
                "false",
                "250"
            ],
            [   //12
                "Работы посредством удаленного подключения (при технической возможности).",
                "true",
                "1000"
            ],
            [   //13
                "Консультация и подбор оборудования под определенные задачи",
                "true",
                "1600"
            ],
            [   //14
                "Работы с выездом к заказчику(указана минимальная стоимость, включено 1 час работ)",
                "true",
                "2500"
            ]
        ];

        foreach ($prices as $price) {
            Price::factory()->create([
                'serviceId' => Service::query()->where('serviceName', $price[0])->firstOrFail()->id,
                'isTime' => $price[1],
                'cost' => $price[2],
            ]);
        }

    }
}
