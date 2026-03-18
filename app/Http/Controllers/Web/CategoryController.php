<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Organization;
use App\Models\Service;
use App\Repository\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
    )
    {
    }
    public function index() : View
    {
        $categories = Category::query()->paginate(10);
        $trashedCategories = Category::onlyTrashed()->paginate(10);
        return view('categories.index',[
            'categories' => $categories,
            'trashedCategories' => $trashedCategories
        ]);
    }
    public function show(Category $category) //Display the specified resource.
    {
        return view('categories.show', [
            'category' => $category
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        return redirect()->route(
            'categories.index',
            $this->categoryRepository->create($request)
        );
    }
    public function update(Request $request, Category $category) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'categories.index',
            $this->categoryRepository->update($request, $category) //из репозитория получаем пользователя
        )->with('success','Категория удачно обновлёна!') ;
    }
    public function destroy(Category $category) : RedirectResponse
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категория удалена.');
    }
    public function restore(string $categoryId): RedirectResponse
    {
        Category::withTrashed()->where('id', $categoryId)->firstOrFail()->restore();
        return redirect()->route('categories.index')->with('success', 'Категория восстановлена.');
    }

    public function getCategoryServiceByCategoryID(string $categoryId): JsonResponse
    {
        return response()->json([
            'data' => Service::query()->where('categoryId', $categoryId)->select(['id', 'serviceName'])->get()
        ]);
    }

}
