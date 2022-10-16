<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::paginate();
        return OrderResource::collection($data);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());
        return OrderResource::make($order);
    }

    public function show(Order $order)
    {
        return OrderResource::make($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return OrderResource::make($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json();
    }
}
