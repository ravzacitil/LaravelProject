<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('user')->recent();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', "%{$term}%")
                  ->orWhere('shipping_email', 'like', "%{$term}%")
                  ->orWhere('shipping_name', 'like', "%{$term}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
                             ->groupBy('status')
                             ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order): View
    {
        $order->load('items', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status'      => ['required', 'in:pending,processing,shipped,delivered,cancelled,refunded'],
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $updates = ['status' => $validated['status']];

        if (! empty($validated['admin_notes'])) {
            $updates['admin_notes'] = $validated['admin_notes'];
        }

        if ($validated['status'] === 'shipped' && ! $order->shipped_at) {
            $updates['shipped_at'] = now();
        }

        if ($validated['status'] === 'delivered' && ! $order->delivered_at) {
            $updates['delivered_at'] = now();
        }

        $order->update($updates);

        return back()->with('success', "Order #{$order->order_number} status updated to {$validated['status']}.");
    }
}
