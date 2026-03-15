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
        try {
            $organizations = new Organization([
                'title' => $request->title,
                'address' => $request->address,
                'details' => $request->details,
                'isLegal' => $request->input('isLegal')==="1" ? 1 : 0
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
        try {
            $organization->update([
                'title' => $request->title,
                'address' => $request->address,
                'details' => $request->details,
                'isLegal' => $request->input('isLegal')==="1" ? 1 : 0
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
