<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['customer', 'order_items', 'transaction', 'shipping'])
            ->when(
                $request->query("search"),
                fn ($query, $term) => $query->search($term)
            )
            ->when(
                $request->query("status"),
                fn ($query, $status) => $query->where('status', $status)
            )
            ->paginate(10);

        return response()->json($orders);
    }

    public function show(string $id)
    {
        $order = Order::query()
            ->with(['customer', 'order_items', 'order_items.stock', 'order_items.stock.product', 'transaction'])
            ->findOrFail($id);

        return response()->json($order);
    }
}
