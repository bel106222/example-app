<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Organization;
use App\Models\Price;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::query()->get();

        foreach ($orders as $order) {
            $count = fake()->numberBetween(1, 5);
            while ($count > 0) {
                $services = Service::query()->get();
                $currentService = $services->random();
                $price = Price::query()->where('serviceId', $currentService->id)->first();
                $users = User::query()->get();
                $currentUser = $users->random();

                OrderItem::factory()->create([
                    'orderId' => $order->id,
                    'serviceId' => $currentService->id,
                    'userId' => $currentUser->id,
                    'isOnline' => false,
                    'quantity' => fake()->numberBetween(1, 3),
                    'cost' => $price->cost
                ]);
                $count -= 1;
            }
        }
    }
}
