@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->short_description ?? 'View product details at Nexus Shop.')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-surface-50 border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-sm text-zinc-500">
            <a href="{{ route('shop.home') }}" class="hover:text-zinc-900 transition-colors">Home</a>
            <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('shop.catalog') }}" class="hover:text-zinc-900 transition-colors">Shop</a>
            <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('shop.catalog', ['category' => $product->category->slug]) }}" class="hover:text-zinc-900 transition-colors">{{ $product->category->name }}</a>
            <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-zinc-900 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>
</div>

{{-- Product Detail --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
    <div class="grid lg:grid-cols-2 gap-12 xl:gap-20 items-start">

        {{-- Left: Image Gallery --}}
        <div class="lg:sticky lg:top-24">
            <div class="relative aspect-square rounded-3xl overflow-hidden bg-surface-50 border border-zinc-100" id="mainImageWrapper">
                @if($product->primary_image)
                    <img id="mainImage"
                         src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-white p-8 bg-gradient-to-br from-violet-500 to-purple-600">
                        <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-lg font-semibold opacity-90">{{ $product->brand ?? $product->name }}</p>
                    </div>
                @endif

                {{-- Sale badge --}}
                @if($product->is_on_sale)
                    <div class="absolute top-4 left-4 bg-red-500 text-white font-bold text-sm px-3 py-1.5 rounded-full shadow-lg">
                        Save {{ $product->discount_percentage }}%
                    </div>
                @endif
            </div>

            {{-- Thumbnail gallery --}}
            @if($product->gallery_images && count($product->gallery_images) > 0)
                <div class="grid grid-cols-5 gap-2 mt-3">
                    {{-- Main image thumb --}}
                    @if($product->primary_image)
                        <button onclick="document.getElementById('mainImage').src='{{ $product->image_url }}'"
                                class="aspect-square rounded-xl overflow-hidden border-2 border-brand-500 hover:border-brand-600 transition-all">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endif
                    @foreach($product->gallery_images as $galleryImg)
                        <button onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $galleryImg) }}'"
                                class="aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-brand-500 transition-all">
                            <img src="{{ asset('storage/' . $galleryImg) }}" alt="Gallery image" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right: Product Info --}}
        <div>
            {{-- Category badge --}}
            <a href="{{ route('shop.catalog', ['category' => $product->category->slug]) }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-600 uppercase tracking-widest hover:text-brand-700 transition-colors mb-4">
                {{ $product->category->name }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            {{-- Product name --}}
            <h1 class="font-display text-3xl xl:text-4xl font-semibold text-zinc-900 leading-tight mb-3">
                {{ $product->name }}
            </h1>

            {{-- Brand & SKU --}}
            <div class="flex items-center gap-4 text-sm text-zinc-500 mb-6">
                @if($product->brand)
                    <span>by <strong class="text-zinc-700">{{ $product->brand }}</strong></span>
                @endif
                @if($product->sku)
                    <span class="text-zinc-300">|</span>
                    <span>SKU: <span class="font-mono text-zinc-600">{{ $product->sku }}</span></span>
                @endif
            </div>

            {{-- Price --}}
            <div class="flex items-end gap-3 mb-6">
                <span class="text-4xl font-bold text-zinc-900 tracking-tight">
                    ${{ number_format($product->price, 2) }}
                </span>
                @if($product->is_on_sale)
                    <div class="mb-1">
                        <span class="text-xl text-zinc-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                        <span class="ml-2 inline-flex items-center bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded-full">
                            You save ${{ number_format($product->compare_price - $product->price, 2) }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Short description --}}
            @if($product->short_description)
                <p class="text-zinc-600 leading-relaxed mb-8 text-base border-l-2 border-brand-200 pl-4">
                    {{ $product->short_description }}
                </p>
            @endif

            {{-- Stock status --}}
            <div class="flex items-center gap-2 mb-8">
                @if($product->is_in_stock)
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-sm font-medium text-green-700">In Stock</span>
                        @if($product->stock_quantity <= 10)
                            <span class="text-xs text-green-600">— Only {{ $product->stock_quantity }} left</span>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-2 bg-zinc-100 px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-zinc-400"></span>
                        <span class="text-sm font-medium text-zinc-600">Out of Stock</span>
                    </div>
                @endif
                @if($product->weight)
                    <span class="text-xs text-zinc-400">Weight: {{ $product->weight }}kg</span>
                @endif
            </div>
@if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('admin.products.edit', $product) }}"
       class="w-full flex items-center justify-center gap-2 bg-zinc-900 text-white font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-brand-600 transition-all mb-8">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Edit This Product (Admin)
    </a>
@else
            {{-- Add to cart form --}}
            @if($product->is_in_stock)
                <form method="POST" action="{{ route('shop.cart.add') }}" class="mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex flex-col sm:flex-row gap-3">
                        {{-- Quantity selector --}}
                        <div class="flex items-center border border-zinc-200 rounded-xl overflow-hidden bg-white">
                            <button type="button"
                                    onclick="const q=document.getElementById('qty'); if(q.value>1) q.value--;"
                                    class="w-12 h-12 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors font-medium text-lg">
                                −
                            </button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-14 h-12 text-center text-sm font-semibold text-zinc-900 border-0 outline-none focus:ring-0 bg-transparent">
                            <button type="button"
                                    onclick="const q=document.getElementById('qty'); if(q.value<{{ $product->stock_quantity }}) q.value++;"
                                    class="w-12 h-12 flex items-center justify-center text-zinc-500 hover:bg-zinc-100 transition-colors font-medium text-lg">
                                +
                            </button>
                        </div>

                        {{-- Add to cart button --}}
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 bg-zinc-900 text-white font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-brand-600 transition-all shadow-lg shadow-zinc-900/10 active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </form>

                {{-- Buy now --}}
                <form method="POST" action="{{ route('shop.cart.add') }}" class="mb-8" id="buyNowForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="button"
                            onclick="document.getElementById('buyNowForm').submit(); window.location='{{ route('shop.checkout.index') }}';"
                            class="w-full flex items-center justify-center gap-2 bg-brand-600 text-white font-semibold text-sm px-8 py-3.5 rounded-xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">
                        Buy Now — ${{ number_format($product->price, 2) }}
                    </button>
                </form>
            @else
                <div class="mb-8 p-4 bg-zinc-50 rounded-xl border border-zinc-200 text-center">
                    <p class="text-zinc-600 font-medium">This item is currently out of stock.</p>
                    <p class="text-sm text-zinc-400 mt-1">Check back later or browse similar products below.</p>
                </div>
            @endif

            {{-- Guarantees --}}
            <div class="grid grid-cols-3 gap-3 p-4 bg-surface-50 rounded-2xl border border-zinc-100">
                <div class="text-center">
                    <svg class="w-5 h-5 mx-auto mb-1.5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <p class="text-xs font-medium text-zinc-700">2-Year Warranty</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 mx-auto mb-1.5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <p class="text-xs font-medium text-zinc-700">Free Returns</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 mx-auto mb-1.5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="text-xs font-medium text-zinc-700">Secure Payment</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Description Tab Section --}}
    <div class="mt-16 lg:mt-24" x-data="{ tab: 'description' }">
        <div class="flex items-center gap-1 border-b border-zinc-200 mb-8">
            <button @click="tab='description'"
                    :class="tab==='description' ? 'text-zinc-900 border-b-2 border-zinc-900' : 'text-zinc-400 hover:text-zinc-600'"
                    class="px-4 py-3 text-sm font-semibold transition-colors -mb-px">
                Description
            </button>
            @if($product->attributes)
                <button @click="tab='specifications'"
                        :class="tab==='specifications' ? 'text-zinc-900 border-b-2 border-zinc-900' : 'text-zinc-400 hover:text-zinc-600'"
                        class="px-4 py-3 text-sm font-semibold transition-colors -mb-px">
                    Specifications
                </button>
            @endif
        </div>

        <div x-show="tab==='description'" class="prose prose-zinc max-w-none">
            @if($product->description)
                {!! $product->description !!}
            @else
                <p class="text-zinc-500 italic">No detailed description available for this product.</p>
            @endif
        </div>

        @if($product->attributes)
            <div x-show="tab==='specifications'" class="hidden">
                <div class="grid sm:grid-cols-2 gap-3 max-w-2xl">
                    @foreach($product->attributes as $key => $value)
                        <div class="flex items-center justify-between p-3 bg-surface-50 rounded-xl border border-zinc-100">
                            <span class="text-sm text-zinc-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span class="text-sm font-semibold text-zinc-900">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
{{-- Back to catalog link --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <a href="{{ route('shop.catalog') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-900 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
        Back to catalog
    </a>
</div>
{{-- Related Products --}}
@if($relatedProducts->isNotEmpty())
    <section class="bg-surface-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-display text-3xl font-light text-zinc-900 mb-8">
                You might also <span class="italic font-semibold">like</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    @include('components.product-card', ['product' => $related])
                @endforeach
            </div>
        </div>
    </section>
            @endif
        @endif

            {{-- Guarantees --}}

@endsection

@push('head')
    {{-- Alpine.js for tab interaction --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
