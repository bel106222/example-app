<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrderItemRepository
{
    final public function create(Request $request): OrderItem
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $orderItem = new OrderItem([
                'orderId' => $request->orderId,
                'serviceId' => $request->serviceId,
                'userId' => $request->userId,
                'isOnline' => $request->isOnline,
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
        return $orderItem;
    }
    final public function update(Request $request, OrderItem $orderItem): OrderItem
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
        return $orderItem;
    }
    final public function destroy(OrderItem $orderItem): bool
    {
        return $orderItem->delete();
    }
}
