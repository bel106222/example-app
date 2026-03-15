<?php

namespace App\Repository;

use App\Models\Order;
use App\Models\Price;
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
                'orderSum' => 99,
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
}
