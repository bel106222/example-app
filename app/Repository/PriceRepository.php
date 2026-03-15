<?php

namespace App\Repository;

use App\Models\Price;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PriceRepository
{
    final public function create(Request $request): Price
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $price = new Price([
                'serviceId' => $request->serviceId,
                'cost' => $request->cost,
                'isTime' => $request->input('isTime')==="1" ? 1 : 0
            ]);
            $price->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $price;
    }
    final public function update(Request $request, Price $price): Price
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $price->update([
                'cost' => $request->cost,
            ]);
            $price->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $price;
    }
    final public function destroy(Price $price): bool
    {
        return $price->delete();
    }
}
