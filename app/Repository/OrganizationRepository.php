<?php

namespace App\Repository;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OrganizationRepository
{
    final public function create(Request $request): Organization
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        if($request->input('isLegal')==="1"){
            $isLegal=true;
        }
        else{
            $isLegal=false;
        };
        try {
            $organizations = new Organization([
                'title' => $request->title,
                'address' => $request->address,
                'details' => $request->details,
                'isLegal' => $isLegal
            ]);
            $organizations->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $organizations;
    }
    final public function update(Request $request, Organization $organization): Organization
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        if($request->input('isLegal')==="1"){
            $isLegal=true;
        }
        else{
            $isLegal=false;
        };
        try {
            $organization->update([
                'title' => $request->title,
                'address' => $request->address,
                'details' => $request->details,
                'isLegal' => $isLegal
            ]);
            $organization->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $organization;
    }
    final public function destroy(Organization $organization): bool
    {
        return $organization->delete();
    }
}
