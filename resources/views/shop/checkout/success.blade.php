@extends('layouts.app')
@section('title', 'Order Confirmed!')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-16">
    <div class="max-w-lg w-full text-center">

        {{-- Animated checkmark --}}
        <div class="relative inline-flex items-center justify-center w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-30"></div>
            <div class="relative w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <h1 class="font-display text-4xl font-light text-zinc-900 mb-2">
            Order <span class="italic font-semibold">Confirmed!</span>
        </h1>
        <p class="text-zinc-500 mb-2">Thank you for shopping with Nexus. Your order has been received.</p>

        {{-- Order number --}}
        <div class="inline-flex items-center gap-2 bg-zinc-100 px-4 py-2 rounded-full text-sm font-mono font-semibold text-zinc-700 mb-8">
            <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            {{ $order->order_number }}
        </div>

        {{-- Summary card --}}
        <div class="bg-white border border-zinc-100 rounded-2xl p-6 mb-8 text-left">
            <h3 class="font-display text-lg font-semibold text-zinc-900 mb-4">Order Summary</h3>
            <div class="space-y-3 mb-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-zinc-400 text-xs bg-zinc-100 px-1.5 py-0.5 rounded-md font-mono">×{{ $item->quantity }}</span>
                            <span class="font-medium text-zinc-800">{{ $item->product_name }}</span>
                        </div>
                        <span class="font-semibold text-zinc-900">${{ number_format($item->line_total, 2) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-zinc-100 pt-4 flex justify-between items-center">
                <span class="text-sm text-zinc-500">Total paid</span>
                <span class="font-display text-xl font-bold text-zinc-900">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Shipping info --}}
        <div class="bg-surface-50 rounded-2xl border border-zinc-100 p-4 mb-8 text-left">
            <p class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-2">Shipping To</p>
            <p class="text-sm font-semibold text-zinc-900">{{ $order->shipping_name }}</p>
            <p class="text-sm text-zinc-600">{{ $order->shipping_address }}, {{ $order->shipping_city }} {{ $order->shipping_postal_code }}</p>
            <p class="text-sm text-zinc-600">{{ $order->shipping_country }}</p>
            <div class="mt-3 flex items-center gap-2 text-xs text-green-700 bg-green-50 border border-green-100 px-3 py-2 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12"/></svg>
                Confirmation email sent to {{ $order->shipping_email }}
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('shop.catalog') }}"
               class="flex items-center gap-2 bg-zinc-900 text-white font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-brand-600 transition-all shadow-lg">
                Continue Shopping
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ route('shop.home') }}"
               class="text-sm font-medium text-zinc-500 hover:text-zinc-900 transition-colors px-4 py-3.5">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
