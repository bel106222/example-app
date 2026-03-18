<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderItemRepository
{
    final public function create(Request $request): string
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $orderItem = new OrderItem([
                'orderId' => $request->orderId,
                'serviceId' => $request->serviceId,
                'userId' => $request->userId,
                'isOnline' => $request->input('isOnline')==="1" ? 1 : 0,
                'quantity' => $request->quantity,
                //'cost' => 99
                'cost' => $this->getPriceByServiceId($request->serviceId) * $request->quantity
            ]);
            $orderItem->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $orderItem->orderId;
    }
    final public function update(Request $request, OrderItem $orderItem) : string
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $orderItem->update([
                'serviceId' => $request->serviceId,
                'userId' => $request->userId,
                'isOnline' => $request->input('isOnline')==="1" ? 1 : 0,
                'quantity' => $request->quantity,
                'cost' => $request->cost
            ]);
            $orderItem->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $orderItem->orderId;
    }
    final public function destroy(OrderItem $orderItem): bool
    {
        return $orderItem->delete();
    }

    public function getPriceByServiceId(string $serviceId) : float
    {
        $prices = Price::query()->get();
        // Найдём нужную запись
        $latestPrice = $prices
            ->filter(fn($item) => $item['serviceId'] === $serviceId) // Отфильтруем по нужному serviceId
            ->sortByDesc('created_at')                        // Сортируем по убыванию дат
            ->first()['cost'];                                       // Берём самый верхний элемент (с самой свежей датой)

        return (float)$latestPrice;
    }
}
