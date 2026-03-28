<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return inertia('Customer/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only(['status']),
        ]);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load(['items.product', 'items.variant']);

        return inertia('Customer/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function cancel(Request $request, Order $order)
    {
        $this->authorize('cancel', $order);

        $order->update(['status' => 'cancelled']);

        foreach ($order->items as $item) {
            if ($item->variant) {
                $item->variant->increment('stock_quantity', $item->quantity);
            } else {
                $item->product->increment('stock_quantity', $item->quantity);
            }
        }

        return back()->with('success', 'Order cancelled successfully.');
    }
}
