<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        return view('orderItems.index',[
            'orderItems' => $orderItems,
            'order' => $order
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
    public function create(Request $request) //Show the form for creating a new resource.
    {
        $services = Service::query()->get();
        $orders = Order::query()->get();
        $users = User::query()->get();
        return view('orderItems.create', [
            'services' => $services,
            'orders' => $orders,
            'users' => $users,
        ]);
//        return redirect()->route(
//            'orders.show',
//            $this->orderItemRepository->create($request)
//        )->with('success','Услуга по заказу удачно добавлена!') ;
    }
    public function store(Request $request)
    {
        //dd($request->input());
        return redirect()->route(
            'orders.show',
            $this->orderItemRepository->create($request)
        )->with('success','Услуга по заказу удачно добавлена!') ;
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
