<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\User;
use App\Repository\OrderItemRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderItemController extends Controller
{
    public function __construct(
        private readonly OrderItemRepository $orderItemRepository,
    )
    {
    }

    public function index(Order $order) : View
    {
        $orderItems = OrderItem::where('orderId', $order->id)->get();
//        $services = Service::query()->paginate(10);
//        $trashedServices = Service::onlyTrashed()->paginate(10);
//        $categories = Category::query()->get();
        return view('orderItems.index',[
            'orderItems' => $orderItems,
//            'services' => $services,
//            'trashedServices' => $trashedServices,
//            'categories' => $categories,
        ]);
    }
    public function show(OrderItem $orderItem) //Display the specified resource.
    {
//        $categories = Category::query()->get();
        $services = Service::query()->get();
        $orders = Order::query()->get();
        $users = User::query()->get();
        return view('orderItems.show', [
            'services' => $services,
            'orders' => $orders,
            'orderItem' => $orderItem,
            'users' => $users,
//            'categories' => $categories,
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
//        $categories = Category::query()->get();
        return view('orderItems.create',[
//            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        return redirect()->route(
            'orderItems.index',
            $this->orderItemRepository->create($request)
        );
    }
    public function update(Request $request, OrderItem $orderItem) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'orders.show',
            $this->orderItemRepository->update($request, $orderItem) //из репозитория получаем пользователя
        )->with('success','Услуга по заказу удачно обновлена!') ;
    }
    public function destroy(OrderItem $orderItem) : RedirectResponse
    {
        $orderItem->delete();
        return redirect()->route('orderItems.index')->with('success', 'Услуга удалена.');
    }
    public function restore(string $orderItemId): RedirectResponse
    {
        OrderItem::withTrashed()->where('id', $orderItemId)->firstOrFail()->restore();
        return redirect()->route('orderItems.index')->with('success', 'Услуга по заказу восстановлена.');
    }
}
