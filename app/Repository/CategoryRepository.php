<?php

namespace App\Repository;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CategoryRepository
{
    final public function create(Request $request): Category
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $category = new Category([
                'categoryName' => $request->categoryName,
            ]);
            $category->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $category;
    }
    final public function update(Request $request, Category $category): Category
    {
        DB::beginTransaction(); //используем транзакцию для попытки создания записи в БД
        try {
            $category->update([
                'categoryName' => $request->categoryName,
            ]);
            $category->save();
            DB::commit();
        }catch (\Exception $exception){
            Log::critical($exception->getMessage());
            DB::rollBack();
            throw new BadRequestHttpException($exception->getMessage());
        }
        return $category;
    }
    final public function destroy(Category $category): bool
    {
        return $category->delete();
    }
}
