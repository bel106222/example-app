<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceRepository $serviceRepository,
    )
    {
    }
    public function index() : View
    {
        $services = Service::query()->paginate(10);
        $trashedServices = Service::onlyTrashed()->paginate(10);
        $categories = Category::query()->get();
        return view('services.index',[
            'services' => $services,
            'trashedServices' => $trashedServices,
            'categories' => $categories,
        ]);
    }
    public function show(Service $service) //Display the specified resource.
    {
        $categories = Category::query()->get();
        return view('services.show', [
            'service' => $service,
            'categories' => $categories,
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
        $categories = Category::query()->get();
        return view('services.create',[
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        return redirect()->route(
            'services.index',
            $this->serviceRepository->create($request)
        );
    }
    public function update(Request $request, Service $service) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'services.index',
            $this->serviceRepository->update($request, $service) //из репозитория получаем пользователя
        )->with('success','Услуга удачно обновлена!') ;
    }
    public function destroy(Service $service) : RedirectResponse
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Услуга удалена.');
    }
    public function restore(string $serviceId): RedirectResponse
    {
        Service::withTrashed()->where('id', $serviceId)->firstOrFail()->restore();
        return redirect()->route('services.index')->with('success', 'Услуга восстановлена.');
    }
}
