<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderRepository
{
    final public function create(Request $request): Order
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $order = new Order([
                'orderNumber' => $request->orderNumber,
                'orderDescription' => $request->orderDescription,
                'userId' => $request->userId,
                'orderSum' => 0,
                'isCompleted' => 0,
                'isPaid' => 0
            ]);
            $order->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $order;
    }
    final public function update(Request $request, Order $order): Order
    {

        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $order->update([
                'orderNumber' => $request->orderNumber,
                'orderDescription' => $request->orderDescription,
                'userId' => $request->userId,
                'orderSum' => OrderItem::where('orderId', $order->id)->sum('cost'),
                'isCompleted' => $request->input('isCompleted')==="1" ? 1 : 0,
                'isPaid' => $request->input('isPaid')==="1" ? 1 : 0
            ]);
            $order->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $order;
    }
    final public function destroy(Order $order): bool
    {
        return $order->delete();
    }

    public function recalcSum(string $orderId) : float
    {
        $orderIrems = OrderItem::query()->get();
        $orderId = 1;
        $sum = OrderItem::where('orderId', $orderId)->sum('cost');
        // Найдём нужную запись
        $latestPrice = $prices
            ->filter(fn($item) => $item['serviceId'] === $serviceId) // Отфильтруем по нужному serviceId
            ->sortByDesc('created_at')                        // Сортируем по убыванию дат
            ->first()['cost'];                                       // Берём самый верхний элемент (с самой свежей датой)

        return (float)$latestPrice;
    }
}
