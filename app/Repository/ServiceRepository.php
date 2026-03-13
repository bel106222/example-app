<?php

namespace App\Repository;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ServiceRepository
{
    final public function create(Request $request): Service
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        if($request->input('isFixPrice')==="1"){
            $isFixPrice=true;
        }
        else{
            $isFixPrice=false;
        };
        try {
            $service = new Service([
                'serviceName' => $request->serviceName,
                'serviceDescription' => $request->serviceDescription,
                'categoryId' => $request->categoryId,
                'isFixPrice' => $isFixPrice
            ]);
            $service->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $service;
    }
    final public function update(Request $request, Service $service): Service
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        if($request->input('isFixPrice')==="1"){
            $isFixPrice=true;
        }
        else{
            $isFixPrice=false;
        };
        try {
            $service = new Service([
                'serviceName' => $request->serviceName,
                'serviceDescription' => $request->serviceDescription,
                'categoryId' => $request->categoryId,
                'isFixPrice' => $isFixPrice
            ]);
            $service->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $service;
    }
    final public function destroy(Service $service): bool
    {
        return $service->delete();
    }
}
