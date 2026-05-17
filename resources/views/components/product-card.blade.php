@php
    $colors = ['from-violet-500 to-purple-600', 'from-blue-500 to-cyan-600', 'from-emerald-500 to-teal-600', 'from-orange-500 to-red-600', 'from-pink-500 to-rose-600', 'from-amber-500 to-yellow-600'];
    $color = $colors[$product->id % count($colors)];
@endphp

<article class="product-card group bg-white border border-zinc-100 hover:border-zinc-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300">

    <a href="{{ route('shop.product', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-surface-50">
        @if($product->primary_image)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br {{ $color }} flex flex-col items-center justify-center text-white p-6">
                <svg class="w-16 h-16 mb-3 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-sm font-semibold text-center opacity-90">{{ $product->brand ?? $product->category->name }}</p>
            </div>
        @endif

        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($product->is_on_sale)
                <span class="inline-flex items-center bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow">-{{ $product->discount_percentage }}%</span>
            @endif
            @if($product->is_featured)
                <span class="inline-flex items-center bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full shadow">★ Featured</span>
            @endif
            @if(! $product->is_in_stock)
                <span class="inline-flex items-center bg-zinc-700 text-zinc-300 text-xs font-medium px-2 py-0.5 rounded-full">Out of Stock</span>
            @endif
        </div>

        @if($product->is_in_stock)
            <div class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <form method="POST" action="{{ route('shop.cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-zinc-900/95 backdrop-blur-sm text-white text-sm font-semibold py-3.5 hover:bg-brand-600 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Add to Cart
                    </button>
                </form>
            </div>
        @endif
    </a>

    <div class="p-4">
        <a href="{{ route('shop.catalog', ['category' => $product->category->slug]) }}" class="text-xs text-brand-600 font-medium uppercase tracking-wide hover:text-brand-700 transition-colors">
            {{ $product->category->name }}
        </a>
        <a href="{{ route('shop.product', $product->slug) }}" class="block mt-1">
            <h3 class="font-semibold text-zinc-900 text-sm leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors">{{ $product->name }}</h3>
        </a>
        @if($product->brand)
            <p class="text-xs text-zinc-400 mt-1">{{ $product->brand }}</p>
        @endif
        <div class="flex items-center justify-between mt-3 pt-3 border-t border-zinc-50">
            <div class="flex items-center gap-2">
                <span class="font-bold text-zinc-900 text-base">${{ number_format($product->price, 2) }}</span>
                @if($product->is_on_sale)
                    <span class="text-sm text-zinc-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                @endif
            </div>
            @if($product->is_in_stock)
                <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>In stock
                </span>
            @else
                <span class="text-xs text-zinc-400">Out of stock</span>
            @endif
        </div>
    </div>
</article>