@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'View and manage customer orders')

@section('content')

{{-- Status filter tabs --}}
<div class="flex items-center gap-2 mb-6 flex-wrap">
    <a href="{{ route('admin.orders.index') }}"
       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ ! request('status') ? 'bg-zinc-900 text-white' : 'bg-white text-zinc-600 border border-zinc-200 hover:bg-zinc-50' }}">
        All <span class="ml-1 opacity-70">{{ $orders->total() }}</span>
    </a>
    @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'] as $status => $label)
        <a href="{{ route('admin.orders.index', ['status' => $status]) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request('status') === $status ? 'bg-zinc-900 text-white' : 'bg-white text-zinc-600 border border-zinc-200 hover:bg-zinc-50' }}">
            {{ $label }} <span class="ml-1 opacity-70">{{ $statusCounts[$status] ?? 0 }}</span>
        </a>
    @endforeach
</div>

{{-- Search --}}
<div class="mb-5">
    <form method="GET">
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
        <div class="relative max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order # or customer email..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm">
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border border-zinc-100 overflow-hidden">
<div class="px-5 py-3 border-b border-zinc-50 text-xs text-zinc-400">
    {{ $orders->total() }} order(s) found
</div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-zinc-100">
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Order</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Customer</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Date</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Status</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Payment</th>
                <th class="text-right px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Total</th>
                <th class="text-right px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-50">
            @forelse($orders as $order)
                @php
                    $statusColors = [
                        'pending'    => 'bg-amber-100 text-amber-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'shipped'    => 'bg-indigo-100 text-indigo-700',
                        'delivered'  => 'bg-green-100 text-green-700',
                        'cancelled'  => 'bg-red-100 text-red-700',
                        'refunded'   => 'bg-zinc-100 text-zinc-600',
                    ];
                    $paymentColors = [
                        'paid'     => 'bg-green-100 text-green-700',
                        'unpaid'   => 'bg-red-100 text-red-700',
                        'refunded' => 'bg-zinc-100 text-zinc-600',
                        'failed'   => 'bg-red-100 text-red-700',
                    ];
                @endphp
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="font-mono text-xs font-semibold text-brand-600 hover:text-brand-700">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-5 py-4">
                        <p class="font-medium text-zinc-900">{{ $order->shipping_name }}</p>
                        <p class="text-xs text-zinc-400">{{ $order->shipping_email }}</p>
                    </td>
                    <td class="px-5 py-4 text-zinc-600 text-xs">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        <span class="text-zinc-400">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-600' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $paymentColors[$order->payment_status] ?? 'bg-zinc-100 text-zinc-600' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right font-semibold text-zinc-900">
                        ${{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-zinc-100 hover:bg-brand-50 hover:text-brand-600 text-zinc-600 text-xs font-medium rounded-lg transition-all">
                            View
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center text-zinc-400">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        No orders found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-zinc-50">
        {{ $orders->links() }}
    </div>
</div>
@endsection
