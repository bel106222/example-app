<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use App\Models\Service;
use App\Models\User;
use App\Repository\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
    )
    {
    }
    public function index() : View
    {
        $currentUser = Auth::user();
        if($currentUser->is_admin){
            $orders = Order::query()->paginate(10);
            $users = User::query()->get();
        }
        else{
            $orders = Order::query()
                ->where('userId', $currentUser->id)
                ->paginate(10);
            $users = User::query()
                ->where('name', $currentUser->name)
                ->get();
        }
        return view('orders.index',[
            'orders' => $orders,
            'users' => $users,
            'currentUser' => $currentUser,
        ]);
    }
    public function show(Order $order) //Display the specified resource.
    {
        $orderItems = OrderItem::query()->where('orderId',$order->id)->get();
        $services = Service::query()->get();
        $users = User::query()->get();
        return view('orders.show', [
            'order' => $order,
            'orderItems' => $orderItems,
            'services' => $services,
            'users' => $users
        ]);
    }
    public function create() //Show the form for creating a new resource.
    {
        $users = User::query()->get();
        return view('orders.create',[
            'users' => $users,
            'currentOrderNumber' => (Order::max('orderNumber') ?? 0) + 1
        ]);
    }

    public function store(Request $request)
    {
        return redirect()->route(
            'orders.index',
            $this->orderRepository->create($request)
        );
    }
    public function update(Request $request, Order $order) : RedirectResponse //Update the specified resource in storage.
    {
        return redirect()->route(
            'orders.index',
            $this->orderRepository->update($request, $order) //из репозитория получаем цену
        )->with('success','Заказ удачно обновлён!') ;
    }
    public function destroy(Order $order) : RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Заказ удалён.');
    }
    public function restore(string $orderId): RedirectResponse
    {
        Order::withTrashed()->where('id', $orderId)->firstOrFail()->restore();
        return redirect()->route('orders.index')->with('success', 'Заказ восстановлен.');
    }
}
