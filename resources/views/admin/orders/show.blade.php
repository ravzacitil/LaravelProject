@extends('layouts.admin')
@section('title', 'Order ' . $order->order_number)
@section('page-title', 'Order Details')
@section('page-subtitle', $order->order_number)

@section('content')

<div class="grid xl:grid-cols-3 gap-6">

    {{-- Left: Items + Timeline --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Order items --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display font-semibold text-zinc-900 mb-5">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-surface-50 rounded-xl">
                        <div class="w-14 h-14 rounded-xl bg-zinc-100 flex-shrink-0 overflow-hidden">
                            @if($item->product_image)
                                <img src="{{ asset('storage/' . $item->product_image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-zinc-900">{{ $item->product_name }}</p>
                            @if($item->product_sku)
                                <p class="text-xs text-zinc-400 font-mono">{{ $item->product_sku }}</p>
                            @endif
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-semibold text-zinc-900">${{ number_format($item->line_total, 2) }}</p>
                            <p class="text-xs text-zinc-400">${{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Price summary --}}
            <div class="mt-5 pt-5 border-t border-zinc-100 space-y-2 text-sm">
                <div class="flex justify-between text-zinc-600"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="flex justify-between text-zinc-600"><span>Shipping</span><span>{{ $order->shipping_amount == 0 ? 'Free' : '$' . number_format($order->shipping_amount, 2) }}</span></div>
                <div class="flex justify-between text-zinc-600"><span>Tax</span><span>${{ number_format($order->tax_amount, 2) }}</span></div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-green-600"><span>Discount</span><span>-${{ number_format($order->discount_amount, 2) }}</span></div>
                @endif
                <div class="flex justify-between font-display font-bold text-zinc-900 text-lg pt-2 border-t border-zinc-100">
                    <span>Total</span><span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping info --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display font-semibold text-zinc-900 mb-4">Shipping Address</h3>
            <div class="text-sm text-zinc-700 space-y-1">
                <p class="font-semibold text-zinc-900">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_email }}</p>
                @if($order->shipping_phone)<p>{{ $order->shipping_phone }}</p>@endif
                <p class="mt-2">{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                <p>{{ $order->shipping_country }}</p>
            </div>
            @if($order->customer_notes)
                <div class="mt-4 p-3 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-xs font-semibold text-amber-700 mb-1">Customer Note</p>
                    <p class="text-sm text-amber-700">{{ $order->customer_notes }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Right: Status + Meta --}}
    <div class="space-y-6">

        {{-- Status badges --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display font-semibold text-zinc-900 mb-4">Order Status</h3>
            @php
                $statusColors = ['pending'=>'amber','processing'=>'blue','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'zinc'];
                $c = $statusColors[$order->status] ?? 'zinc';
                $payColors = ['paid'=>'green','unpaid'=>'red','refunded'=>'zinc','failed'=>'red'];
                $p = $payColors[$order->payment_status] ?? 'zinc';
            @endphp
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-500">Order Status</span>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-500">Payment</span>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $p }}-100 text-{{ $p }}-700">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-500">Method</span>
                    <span class="text-sm font-medium text-zinc-700">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-500">Placed on</span>
                    <span class="text-sm font-medium text-zinc-700">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                @if($order->shipped_at)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500">Shipped on</span>
                        <span class="text-sm font-medium text-zinc-700">{{ $order->shipped_at->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Update status --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display font-semibold text-zinc-900 mb-4">Update Status</h3>
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-4">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">New Status</label>
                    <select name="status" required
                            class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Admin Note <span class="text-zinc-400 font-normal">(optional)</span></label>
                    <textarea name="admin_notes" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm resize-none"
                              placeholder="Internal note for this status update...">{{ $order->admin_notes }}</textarea>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-brand-600 text-white font-semibold text-sm py-3 rounded-xl hover:bg-brand-700 transition-all">
                    Update Order
                </button>
            </form>
        </div>

        {{-- Customer info --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display font-semibold text-zinc-900 mb-4">Customer</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-brand-700 font-semibold text-sm">{{ strtoupper(substr($order->user->name ?? 'G', 0, 1)) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-zinc-900 text-sm">{{ $order->user->name ?? 'Guest' }}</p>
                    <p class="text-xs text-zinc-400">{{ $order->user->email ?? $order->shipping_email }}</p>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Back to Orders
        </a>
    </div>
</div>

@endsection
