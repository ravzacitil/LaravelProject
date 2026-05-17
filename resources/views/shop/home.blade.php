@extends('layouts.app')

@section('title', 'Nexus Shop — Premium Products')

@section('content')

{{-- ── HERO SECTION ───────────────────────────────────────────────────────── --}}
<section class="relative overflow-hidden bg-zinc-950 min-h-[92vh] flex items-center">

    {{-- Background mesh gradient --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-brand-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-purple-600/15 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-zinc-800/30 rounded-full blur-[80px]"></div>
    </div>

    {{-- Grid pattern overlay --}}
    <div class="absolute inset-0 opacity-[0.03]"
         style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 48px 48px;">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left: Copy --}}
            <div class="text-left">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white/80 text-xs font-medium px-3.5 py-1.5 rounded-full mb-6 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                    New arrivals added weekly
                </div>

                <h1 class="font-display text-5xl lg:text-7xl font-light text-white leading-[1.05] tracking-tight mb-6">
                    Products that
                    <span class="font-semibold italic block">actually matter.</span>
                </h1>

                <p class="text-zinc-400 text-lg leading-relaxed max-w-md mb-10">
                    Rigorously curated electronics, fashion, and home goods — selected for durability, design, and lasting value.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('shop.catalog') }}"
                       class="inline-flex items-center gap-2 bg-white text-zinc-900 font-semibold text-sm px-6 py-3.5 rounded-xl hover:bg-zinc-100 transition-all shadow-lg">
                        Shop Now
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('shop.catalog', ['sort' => 'popular']) }}"
                       class="inline-flex items-center gap-2 text-zinc-300 font-medium text-sm px-6 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 transition-all">
                        Best Sellers
                    </a>
                </div>

                {{-- Social proof --}}
                <div class="flex items-center gap-6 mt-12 pt-8 border-t border-white/10">
                    <div>
                        <p class="font-display text-2xl font-semibold text-white">12K+</p>
                        <p class="text-zinc-500 text-xs mt-0.5">Happy customers</p>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div>
                        <p class="font-display text-2xl font-semibold text-white">500+</p>
                        <p class="text-zinc-500 text-xs mt-0.5">Curated products</p>
                    </div>
                    <div class="w-px h-8 bg-white/10"></div>
                    <div>
                        <p class="font-display text-2xl font-semibold text-white">4.9★</p>
                        <p class="text-zinc-500 text-xs mt-0.5">Average rating</p>
                    </div>
                </div>
            </div>

            {{-- Right: Featured product cards --}}
            <div class="hidden lg:grid grid-cols-2 gap-4">
                @foreach($featuredProducts->take(4) as $i => $product)
                    <a href="{{ route('shop.product', $product->slug) }}"
                       class="group relative bg-zinc-900 border border-white/10 rounded-2xl overflow-hidden hover:border-brand-500/40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10 {{ $i === 0 ? 'col-span-2' : '' }}">
                        <div class="aspect-{{ $i === 0 ? 'video' : 'square' }} bg-gradient-to-br from-zinc-800 to-zinc-900 flex items-center justify-center overflow-hidden">
                            @if($product->primary_image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     class="w-full h-full object-cover product-img">
                            @else
                                <div class="text-zinc-600 text-center p-6">
                                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="text-xs">{{ $product->brand }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="text-white text-sm font-medium truncate group-hover:text-brand-400 transition-colors">{{ $product->name }}</p>
                            <p class="text-zinc-400 text-xs mt-0.5">${{ number_format($product->price, 2) }}</p>
                        </div>
                        @if($product->is_on_sale)
                            <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                -{{ $product->discount_percentage }}%
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-zinc-600 animate-bounce">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ── TRUST STRIP ────────────────────────────────────────────────────────── --}}
<section class="border-b border-zinc-100 bg-surface-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
            <div class="flex items-center gap-3 text-zinc-600">
                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12"/></svg>
                </div>
                <div><p class="font-semibold text-zinc-900">Free Shipping</p><p class="text-xs text-zinc-500">On orders over $50</p></div>
            </div>
            <div class="flex items-center gap-3 text-zinc-600">
                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div><p class="font-semibold text-zinc-900">30-Day Returns</p><p class="text-xs text-zinc-500">Hassle-free guarantee</p></div>
            </div>
            <div class="flex items-center gap-3 text-zinc-600">
                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div><p class="font-semibold text-zinc-900">Secure Checkout</p><p class="text-xs text-zinc-500">256-bit SSL encryption</p></div>
            </div>
            <div class="flex items-center gap-3 text-zinc-600">
                <div class="w-8 h-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div><p class="font-semibold text-zinc-900">24/7 Support</p><p class="text-xs text-zinc-500">Always here to help</p></div>
            </div>
        </div>
    </div>
</section>

{{-- ── CATEGORIES GRID ────────────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex items-end justify-between mb-10">
        <div>
            <p class="text-brand-600 text-sm font-semibold uppercase tracking-widest mb-2">Browse by Category</p>
            <h2 class="font-display text-4xl font-light text-zinc-900">Shop <span class="italic font-semibold">Collections</span></h2>
        </div>
        <a href="{{ route('shop.catalog') }}" class="hidden sm:flex items-center gap-1.5 text-sm font-medium text-zinc-500 hover:text-zinc-900 transition-colors">
            View all <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('shop.catalog', ['category' => $category->slug]) }}"
               class="group flex flex-col items-center gap-3 p-6 bg-surface-50 hover:bg-zinc-900 border border-zinc-100 hover:border-zinc-900 rounded-2xl transition-all duration-300 text-center">
                <div class="w-12 h-12 rounded-xl bg-zinc-200 group-hover:bg-brand-600 flex items-center justify-center transition-colors duration-300">
                    <svg class="w-5 h-5 text-zinc-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-sm text-zinc-900 group-hover:text-white transition-colors duration-300 leading-tight">{{ $category->name }}</p>
                    <p class="text-xs text-zinc-400 group-hover:text-zinc-400 mt-0.5">{{ $category->products_count }} items</p>
                </div>
            </a>
        @endforeach
    </div>
</section>

{{-- ── FEATURED PRODUCTS ──────────────────────────────────────────────────── --}}
<section class="bg-surface-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-brand-600 text-sm font-semibold uppercase tracking-widest mb-2">Hand-Picked</p>
                <h2 class="font-display text-4xl font-light text-zinc-900">Featured <span class="italic font-semibold">Products</span></h2>
            </div>
            <a href="{{ route('shop.catalog') }}" class="hidden sm:flex items-center gap-1.5 text-sm font-medium text-zinc-500 hover:text-zinc-900 transition-colors">
                View all <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

{{-- ── BANNER CTA ─────────────────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="relative overflow-hidden bg-zinc-900 rounded-3xl px-8 py-16 md:px-16 md:py-20 text-center">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-600/20 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-purple-600/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl pointer-events-none"></div>
        <div class="relative">
            <p class="text-brand-400 text-sm font-semibold uppercase tracking-widest mb-4">Limited Time Offer</p>
            <h2 class="font-display text-4xl md:text-5xl font-light text-white mb-4">
                Free shipping on <span class="italic font-semibold">every order</span><br class="hidden md:block"> over $50.
            </h2>
            <p class="text-zinc-400 mb-8 max-w-md mx-auto">No code required. Automatically applied at checkout on qualifying orders.</p>
            <a href="{{ route('shop.catalog') }}"
               class="inline-flex items-center gap-2 bg-white text-zinc-900 font-semibold text-sm px-8 py-4 rounded-xl hover:bg-zinc-100 transition-all shadow-lg shadow-white/10">
                Start Shopping
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ── NEW ARRIVALS + BEST SELLERS ────────────────────────────────────────── --}}
<section class="bg-surface-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12">

            {{-- New Arrivals --}}
            <div>
                <p class="text-brand-600 text-sm font-semibold uppercase tracking-widest mb-2">Just In</p>
                <h3 class="font-display text-3xl font-light text-zinc-900 mb-8">New <span class="italic font-semibold">Arrivals</span></h3>
                <div class="space-y-4">
                    @foreach($newArrivals as $product)
                        <a href="{{ route('shop.product', $product->slug) }}"
                           class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-zinc-100 hover:border-zinc-300 hover:shadow-md transition-all group">
                            <div class="w-16 h-16 rounded-xl bg-surface-100 flex-shrink-0 overflow-hidden">
                                @if($product->primary_image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-zinc-900 truncate group-hover:text-brand-600 transition-colors">{{ $product->name }}</p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ $product->category->name }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-semibold text-zinc-900">${{ number_format($product->price, 2) }}</p>
                                @if($product->is_on_sale)
                                    <p class="text-xs text-zinc-400 line-through">${{ number_format($product->compare_price, 2) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Best Sellers --}}
            <div>
                <p class="text-amber-600 text-sm font-semibold uppercase tracking-widest mb-2">Most Popular</p>
                <h3 class="font-display text-3xl font-light text-zinc-900 mb-8">Best <span class="italic font-semibold">Sellers</span></h3>
                <div class="space-y-4">
                    @foreach($bestSellers as $i => $product)
                        <a href="{{ route('shop.product', $product->slug) }}"
                           class="flex items-center gap-4 p-4 bg-white rounded-2xl border border-zinc-100 hover:border-zinc-300 hover:shadow-md transition-all group">
                            <div class="w-8 h-8 rounded-full bg-surface-100 flex-shrink-0 flex items-center justify-center">
                                <span class="text-xs font-bold text-zinc-400">{{ $i + 1 }}</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-surface-100 flex-shrink-0 overflow-hidden">
                                @if($product->primary_image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-zinc-900 truncate group-hover:text-brand-600 transition-colors">{{ $product->name }}</p>
                                <p class="text-xs text-zinc-500 mt-0.5">{{ number_format($product->views_count) }} views</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="font-semibold text-zinc-900">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
