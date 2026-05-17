@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '! Here\'s what\'s happening.')

@section('content')

{{-- Metric cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

    <div class="bg-white rounded-2xl border border-zinc-100 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">Total Revenue</p>
                <p class="font-display text-3xl font-semibold text-zinc-900 mt-1">${{ number_format($totalRevenue, 0) }}</p>
                <p class="text-xs text-green-600 font-medium mt-1">All time</p>
            </div>
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-100 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">Total Orders</p>
                <p class="font-display text-3xl font-semibold text-zinc-900 mt-1">{{ number_format($totalOrders) }}</p>
                <p class="text-xs text-zinc-400 font-medium mt-1">{{ $ordersByStatus['pending'] ?? 0 }} pending</p>
            </div>
            <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-100 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">Products</p>
                <p class="font-display text-3xl font-semibold text-zinc-900 mt-1">{{ number_format($totalProducts) }}</p>
                <p class="text-xs text-zinc-400 font-medium mt-1">{{ $lowStockProducts->count() }} low stock</p>
            </div>
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-zinc-100 p-5">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest">Customers</p>
                <p class="font-display text-3xl font-semibold text-zinc-900 mt-1">{{ number_format($totalCustomers) }}</p>
                <p class="text-xs text-zinc-400 font-medium mt-1">Registered accounts</p>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
    </div>
</div>

{{-- Revenue chart + Order status --}}
<div class="grid xl:grid-cols-3 gap-6 mb-8">

    {{-- Revenue Chart --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-zinc-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-display text-lg font-semibold text-zinc-900">Revenue — Last 7 Days</h3>
        </div>
        <div class="h-48 flex items-end gap-3">
            @php $maxRevenue = max(array_merge($revenues, [1])); @endphp
            @foreach($revenues as $i => $rev)
                <div class="flex-1 flex flex-col items-center gap-1.5">
                    <span class="text-xs font-medium text-zinc-400">${{ $rev > 0 ? number_format($rev, 0) : '0' }}</span>
                    <div class="w-full rounded-t-lg bg-brand-500/20 hover:bg-brand-500 transition-colors cursor-default relative group"
                         style="height: {{ $maxRevenue > 0 ? max(4, ($rev / $maxRevenue) * 160) : 4 }}px;">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-zinc-900 text-white text-xs px-2 py-1 rounded hidden group-hover:block whitespace-nowrap">
                            ${{ number_format($rev, 2) }}
                        </div>
                    </div>
                    <span class="text-xs text-zinc-400">{{ $labels[$i] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Order Status --}}
    <div class="bg-white rounded-2xl border border-zinc-100 p-6">
        <h3 class="font-display text-lg font-semibold text-zinc-900 mb-5">Order Status</h3>
        <div class="space-y-3">
            @php
                $statusConfig = [
                    'pending'    => ['color' => 'bg-amber-400',  'label' => 'Pending'],
                    'processing' => ['color' => 'bg-blue-400',   'label' => 'Processing'],
                    'shipped'    => ['color' => 'bg-indigo-400', 'label' => 'Shipped'],
                    'delivered'  => ['color' => 'bg-green-400',  'label' => 'Delivered'],
                    'cancelled'  => ['color' => 'bg-red-400',    'label' => 'Cancelled'],
                    'refunded'   => ['color' => 'bg-zinc-400',   'label' => 'Refunded'],
                ];
                $totalOrdersForChart = max($totalOrders, 1);
            @endphp
            @foreach($statusConfig as $status => $config)
                @php $count = $ordersByStatus[$status] ?? 0; @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-zinc-700">{{ $config['label'] }}</span>
                        <span class="text-zinc-400">{{ $count }}</span>
                    </div>
                    <div class="h-1.5 bg-zinc-100 rounded-full">
                        <div class="{{ $config['color'] }} h-1.5 rounded-full transition-all"
                             style="width: {{ ($count / $totalOrdersForChart) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent orders + Low stock + Top products --}}
<div class="grid xl:grid-cols-3 gap-6">

    {{-- Recent orders --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-zinc-100">
        <div class="flex items-center justify-between p-6 pb-0">
            <h3 class="font-display text-lg font-semibold text-zinc-900">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-brand-600 hover:text-brand-700 font-medium">View all</a>
        </div>
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Order</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Customer</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Status</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-6 py-3.5">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="font-mono text-xs font-semibold text-brand-600 hover:text-brand-700">
                                    {{ $order->order_number }}
                                </a>
                                <p class="text-xs text-zinc-400 mt-0.5">{{ $order->created_at->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-3.5">
                                <p class="font-medium text-zinc-900">{{ $order->shipping_name }}</p>
                                <p class="text-xs text-zinc-400">{{ $order->shipping_email }}</p>
                            </td>
                            <td class="px-6 py-3.5">
                                @php
                                    $badgeColors = [
                                        'pending'    => 'bg-amber-100 text-amber-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'shipped'    => 'bg-indigo-100 text-indigo-700',
                                        'delivered'  => 'bg-green-100 text-green-700',
                                        'cancelled'  => 'bg-red-100 text-red-700',
                                        'refunded'   => 'bg-zinc-100 text-zinc-600',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeColors[$order->status] ?? 'bg-zinc-100 text-zinc-600' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right font-semibold text-zinc-900">
                                ${{ number_format($order->total_amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Right column --}}
    <div class="space-y-6">

        {{-- Low stock --}}
        @if($lowStockProducts->isNotEmpty())
            <div class="bg-white rounded-2xl border border-red-100 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <h3 class="font-display text-base font-semibold text-zinc-900">Low Stock Alert</h3>
                </div>
                <div class="space-y-3">
                    @foreach($lowStockProducts as $product)
                        <div class="flex items-center justify-between">
                            <div class="min-w-0">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-sm font-medium text-zinc-900 hover:text-brand-600 transition-colors truncate block">
                                    {{ $product->name }}
                                </a>
                            </div>
                            <span class="ml-2 flex-shrink-0 text-xs font-bold px-2 py-0.5 rounded-full {{ $product->stock_quantity === 0 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700' }}">
                                {{ $product->stock_quantity }} left
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Top products --}}
        <div class="bg-white rounded-2xl border border-zinc-100 p-6">
            <h3 class="font-display text-base font-semibold text-zinc-900 mb-4">Top Products</h3>
            <div class="space-y-3">
                @foreach($topProducts as $i => $product)
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-zinc-300 w-4">{{ $i + 1 }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 truncate">{{ $product->product_name }}</p>
                            <p class="text-xs text-zinc-400">{{ $product->total_sold }} sold</p>
                        </div>
                        <span class="text-sm font-semibold text-green-600">${{ number_format($product->total_revenue, 0) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
