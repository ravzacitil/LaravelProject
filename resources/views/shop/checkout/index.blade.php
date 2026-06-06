@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-10">
        <h1 class="font-display text-4xl font-light text-zinc-900">Secure <span class="italic font-semibold">Checkout</span></h1>
        <p class="text-zinc-500 mt-1 flex items-center gap-1.5 text-sm">
            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            SSL encrypted — your data is safe with us
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
            <ul class="text-sm text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('shop.checkout.store') }}">
        @csrf
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- Checkout form --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Contact info --}}
                <div class="bg-white border border-zinc-100 rounded-2xl p-6">
                    <h2 class="font-display text-xl font-semibold text-zinc-900 mb-5">Contact Information</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_name') border-red-400 @enderror"
                                   placeholder="Full name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email) }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_email') border-red-400 @enderror"
                                   placeholder="you@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Phone Number</label>
                            <input type="tel" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                                   placeholder="+1 555 000 0000">
                        </div>
                    </div>
                </div>

                {{-- Shipping address --}}
                <div class="bg-white border border-zinc-100 rounded-2xl p-6">
                    <h2 class="font-display text-xl font-semibold text-zinc-900 mb-5">Shipping Address</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Street Address <span class="text-red-500">*</span></label>
                            <input type="text" name="shipping_address" value="{{ old('shipping_address', auth()->user()->address) }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_address') border-red-400 @enderror"
                                   placeholder="123 Main Street, Apt 4B">
                        </div>
                        <div class="grid sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-1">
                                <label class="block text-sm font-medium text-zinc-700 mb-1.5">City <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city', auth()->user()->city) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_city') border-red-400 @enderror"
                                       placeholder="New York">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1.5">Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code', auth()->user()->postal_code) }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_postal_code') border-red-400 @enderror"
                                       placeholder="10001">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1.5">Country <span class="text-red-500">*</span></label>
                                <input type="text" name="shipping_country" value="{{ old('shipping_country', auth()->user()->country ?? 'United States') }}" required
                                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('shipping_country') border-red-400 @enderror"
                                       placeholder="United States">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment (simulated) --}}
                <div class="bg-white border border-zinc-100 rounded-2xl p-6">
                    <h2 class="font-display text-xl font-semibold text-zinc-900 mb-2">Payment Method</h2>
                    <p class="text-sm text-zinc-400 mb-5">This is a demo — no real payment is processed.</p>

                    <input type="hidden" name="payment_method" value="credit_card">

                    <div class="border-2 border-brand-500 bg-brand-50 rounded-xl p-4 flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-brand-500 flex items-center justify-center flex-shrink-0">
                            <div class="w-2 h-2 rounded-full bg-white"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-900">Credit / Debit Card</p>
                            <p class="text-xs text-zinc-500">Visa, Mastercard, Amex accepted</p>
                        </div>
                        <div class="ml-auto flex items-center gap-2 text-zinc-300">
                            <svg class="w-8 h-5" viewBox="0 0 38 24" fill="none"><rect width="38" height="24" rx="4" fill="#1434CB"/><path d="M14.8 16.3h-2.2l1.4-8.6h2.2L14.8 16.3zM11.1 7.7l-2.1 5.9-.2-1.1-.7-3.7s-.1-.4-.4-.7c-.3-.2-.7-.4-.7-.4H3.8l-.1.2s.8.2 1.8.6l1.6 5.9 2.3 0L12.6 7.7H11.1z" fill="white"/></svg>
                        </div>
                    </div>

                    {{-- Simulated card fields --}}
                    <div class="mt-4 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Card Number</label>
                            <input type="text" placeholder="4242 4242 4242 4242" maxlength="19"
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm font-mono"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').replace(/(.{4})/g,'$1 ').trim()">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1.5">Expiry Date</label>
                                <input type="text" placeholder="MM / YY" maxlength="7"
                                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm font-mono">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1.5">CVV</label>
                                <input type="text" placeholder="123" maxlength="4"
                                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm font-mono">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order notes --}}
                <div class="bg-white border border-zinc-100 rounded-2xl p-6">
                    <h2 class="font-display text-lg font-semibold text-zinc-900 mb-3">Order Notes <span class="text-zinc-400 font-normal text-sm">(optional)</span></h2>
                    <textarea name="customer_notes" rows="3"
                              class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm resize-none"
                              placeholder="Special delivery instructions, gift messages...">{{ old('customer_notes') }}</textarea>
                </div>
            </div>

            {{-- Order summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-zinc-100 rounded-2xl p-6 sticky top-24">
                    <h2 class="font-display text-xl font-semibold text-zinc-900 mb-5">Order Summary</h2>

                    {{-- Items --}}
                    <div class="space-y-3 mb-5">
                        @foreach($cart->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-surface-100 flex-shrink-0 overflow-hidden border border-zinc-100 relative">
                                    @if($item->product->primary_image)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @endif
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-zinc-700 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $item->quantity }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-medium text-zinc-900 truncate">{{ $item->product->name }}</p>
                                </div>
                                <span class="text-xs font-semibold text-zinc-900">${{ number_format($item->line_total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-zinc-100 pt-4 space-y-2.5 text-sm">
                        <div class="flex justify-between text-zinc-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-zinc-600">
                            <span>Shipping</span>
                            <span class="{{ $shipping == 0 ? 'text-green-600 font-medium' : '' }}">
                                {{ $shipping == 0 ? 'Free' : '$' . number_format($shipping, 2) }}
                            </span>
                        </div>
                        <div class="flex justify-between text-zinc-600">
                            <span>Tax (8%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-zinc-100 mt-4 pt-4 flex justify-between items-center">
                        <span class="font-display text-lg font-semibold text-zinc-900">Total</span>
                        <span class="font-display text-2xl font-bold text-zinc-900">${{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit"
                            class="mt-6 w-full flex items-center justify-center gap-2 bg-zinc-900 text-white font-bold text-sm py-4 rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-zinc-900/10 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Place Order — ${{ number_format($total, 2) }}
                    </button>

                    <p class="text-xs text-zinc-400 text-center mt-3">
                        By placing your order you agree to our <a href="{{ route('shop.terms') }}" class="underline">Terms</a> & <a href="{{ route('shop.privacy') }}" class="underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
