@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-10">
        <h1 class="font-display text-4xl font-light text-zinc-900">Your <span class="italic font-semibold">Cart</span></h1>
        <p class="text-zinc-500 mt-1">{{ $cart->total_items }} {{ Str::plural('item', $cart->total_items) }} in your cart</p>
    </div>

    @if($cart->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-surface-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h2 class="font-display text-2xl font-semibold text-zinc-900 mb-2">Your cart is empty</h2>
            <p class="text-zinc-500 mb-8">Looks like you haven't added anything yet.</p>
            <a href="{{ route('shop.catalog') }}"
               class="inline-flex items-center gap-2 bg-zinc-900 text-white font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-brand-600 transition-all">
                Continue Shopping
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="flex gap-5 p-5 bg-white border border-zinc-100 rounded-2xl hover:border-zinc-200 transition-all">

                        {{-- Product Image --}}
                        <a href="{{ route('shop.product', $item->product->slug) }}"
                           class="flex-shrink-0 w-24 h-24 rounded-xl bg-surface-50 overflow-hidden border border-zinc-100">
                            @if($item->product->primary_image)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                        </a>

                        {{-- Item Details --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <a href="{{ route('shop.product', $item->product->slug) }}"
                                       class="font-semibold text-zinc-900 hover:text-brand-600 transition-colors leading-tight">
                                        {{ $item->product->name }}
                                    </a>
                                    <p class="text-sm text-zinc-400 mt-0.5">{{ $item->product->category->name }}</p>
                                    @if($item->product->brand)
                                        <p class="text-xs text-zinc-400">{{ $item->product->brand }}</p>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('shop.cart.remove', $item) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-zinc-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                {{-- Quantity --}}
                                <form method="POST" action="{{ route('shop.cart.update', $item) }}" class="flex items-center border border-zinc-200 rounded-xl overflow-hidden">
                                    @csrf @method('PATCH')
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                            class="w-9 h-9 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors text-lg font-medium">−</button>
                                    <span class="w-10 text-center text-sm font-semibold text-zinc-900">{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                            class="w-9 h-9 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors text-lg font-medium">+</button>
                                </form>

                                <div class="text-right">
                                    <p class="font-bold text-zinc-900">${{ number_format($item->line_total, 2) }}</p>
                                    <p class="text-xs text-zinc-400">${{ number_format($item->unit_price, 2) }} each</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Cart actions --}}
                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('shop.catalog') }}"
                       class="flex items-center gap-2 text-sm font-medium text-zinc-500 hover:text-zinc-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Continue Shopping
                    </a>
                    <form method="POST" action="{{ route('shop.cart.clear') }}">
                        @csrf @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Clear your entire cart?')"
                                class="text-sm font-medium text-zinc-400 hover:text-red-500 transition-colors">
                            Clear cart
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-zinc-100 rounded-2xl p-6 sticky top-24">
                    <h2 class="font-display text-xl font-semibold text-zinc-900 mb-6">Order Summary</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-zinc-600">
                            <span>Subtotal ({{ $cart->total_items }} items)</span>
                            <span class="font-medium text-zinc-900">${{ number_format($cart->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-zinc-600">
                            <span>Shipping</span>
                            <span class="font-medium {{ $cart->subtotal >= 50 ? 'text-green-600' : 'text-zinc-900' }}">
                                {{ $cart->subtotal >= 50 ? 'FREE' : '$5.99' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-zinc-600">
                            <span>Tax (8%)</span>
                            <span class="font-medium text-zinc-900">${{ number_format($cart->subtotal * 0.08, 2) }}</span>
                        </div>
                    </div>

                    @if($cart->subtotal < 50)
                        <div class="mt-4 p-3 bg-brand-50 border border-brand-100 rounded-xl">
                            <p class="text-xs text-brand-700">
                                Add <strong>${{ number_format(50 - $cart->subtotal, 2) }}</strong> more for free shipping!
                            </p>
                            <div class="mt-2 h-1.5 bg-brand-100 rounded-full">
                                <div class="h-1.5 bg-brand-500 rounded-full transition-all" style="width: {{ min(100, ($cart->subtotal / 50) * 100) }}%"></div>
                            </div>
                        </div>
                    @endif

                    <div class="border-t border-zinc-100 mt-4 pt-4">
                        @php
                            $shipping = $cart->subtotal >= 50 ? 0 : 5.99;
                            $tax      = $cart->subtotal * 0.08;
                            $total    = $cart->subtotal + $shipping + $tax;
                        @endphp
                        <div class="flex justify-between items-center">
                            <span class="font-display text-lg font-semibold text-zinc-900">Total</span>
                            <span class="font-display text-2xl font-bold text-zinc-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('shop.checkout.index') }}"
                       class="mt-6 w-full flex items-center justify-center gap-2 bg-zinc-900 text-white font-semibold text-sm px-6 py-4 rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-zinc-900/10">
                        Proceed to Checkout
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>

                    {{-- Payment icons --}}
                    <div class="mt-4 flex items-center justify-center gap-2 text-zinc-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <p class="text-xs">Secure SSL encrypted checkout</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
