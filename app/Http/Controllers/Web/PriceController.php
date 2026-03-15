<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Price;
use App\Models\Service;
use App\Repository\PriceRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function __construct(
        private readonly PriceRepository $priceRepository,
    )
    {
    }
    public function index() : View
    {
        $services = Service::query()->get();
        $categories = Category::query()->get();
        $prices = Price::query()->paginate(10);
        return view('prices.index',[
            'services' => $services,
            'prices' => $prices,
            'categories' => $categories,
        ]);
    }
    public function show(Price $price) //Display the specified resource.
    {
        $categories = Category::query()->get();
        $services = Service::query()->get();
        return view('prices.show', [
            'services' => $services,
            'categories' => $categories,
            'price' => $price
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
        $categories = Category::query()->get();
        $services = Service::query()->get();
        return view('prices.create',[
            'categories' => $categories,
            'services' => $services
        ]);
    }

    public function store(Request $request)
    {
        return redirect()->route(
            'prices.index',
            $this->priceRepository->create($request)
        );
    }
    public function update(Request $request, Price $price) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'prices.index',
            $this->priceRepository->update($request, $price) //из репозитория получаем цену
        )->with('success','Цена удачно обновлена!') ;
    }
    public function destroy(Price $price) : RedirectResponse
    {
        $price->delete();
        return redirect()->route('prices.index')->with('success', 'Цена удалена.');
    }
    public function restore(string $priceId): RedirectResponse
    {
        Price::withTrashed()->where('id', $priceId)->firstOrFail()->restore();
        return redirect()->route('prices.index')->with('success', 'Цена восстановлена.');
    }
}
