@extends('layouts.app')
@section('title', 'Shop — Nexus')
@section('meta_description', 'Browse our curated catalog of premium products.')

@section('content')

{{-- Page header --}}
<div class="bg-surface-50 border-b border-zinc-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-end justify-between">
            <div>
                <nav class="flex items-center gap-2 text-sm text-zinc-500 mb-3">
                    <a href="{{ route('shop.home') }}" class="hover:text-zinc-900 transition-colors">Home</a>
                    <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-zinc-900 font-medium">
                        {{ request('category') ? \App\Models\Category::where('slug', request('category'))->first()?->name ?? 'Shop' : 'All Products' }}
                    </span>
                </nav>
                <h1 class="font-display text-4xl font-light text-zinc-900">
                    @if(request('search'))
                        Results for <span class="italic font-semibold">"{{ request('search') }}"</span>
                    @elseif(request('category'))
                        @php $activeCat = \App\Models\Category::where('slug', request('category'))->first(); @endphp
                        {{ $activeCat?->name ?? 'Shop' }}
                    @else
                        All <span class="italic font-semibold">Products</span>
                    @endif
                </h1>
                <p class="text-zinc-400 mt-1 text-sm">{{ $products->total() }} {{ Str::plural('product', $products->total()) }} found matching your search</p>
            </div>

            {{-- Sort --}}
            <form method="GET" class="hidden sm:block">
                @foreach(request()->except('sort') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <select name="sort" onchange="this.form.submit()"
                        class="px-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm bg-white">
                    <option value="latest"   {{ request('sort') === 'latest'   ? 'selected' : '' }}>Newest First</option>
                    <option value="popular"  {{ request('sort') === 'popular'  ? 'selected' : '' }}>Most Popular</option>
                    <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex gap-8">

        {{-- Sidebar Filters --}}
        <aside class="hidden lg:block w-56 flex-shrink-0">
            <form method="GET" id="filterForm">
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                {{-- Search --}}
                <div class="mb-7">
                    <label class="block text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3">Search</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search products..."
                               class="w-full pl-8 pr-3 py-2 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm">
                    </div>
                </div>

                {{-- Categories --}}
                <div class="mb-7">
                    <label class="block text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3">Category</label>
                    <div class="space-y-1">
                        <label class="flex items-center gap-2.5 py-1 cursor-pointer group">
                            <input type="radio" name="category" value=""
                                   {{ ! request('category') ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="text-brand-600 focus:ring-brand-500 border-zinc-300">
                            <span class="text-sm text-zinc-700 group-hover:text-zinc-900 transition-colors">All Categories</span>
                        </label>
                        @foreach(\App\Models\Category::active()->parentOnly()->ordered()->withCount('products')->get() as $cat)
                            <label class="flex items-center justify-between py-1 cursor-pointer group">
                                <div class="flex items-center gap-2.5">
                                    <input type="radio" name="category" value="{{ $cat->slug }}"
                                           {{ request('category') === $cat->slug ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="text-brand-600 focus:ring-brand-500 border-zinc-300">
                                    <span class="text-sm text-zinc-700 group-hover:text-zinc-900 transition-colors">{{ $cat->name }}</span>
                                </div>
                                <span class="text-xs text-zinc-400">{{ $cat->products_count }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
{{-- Brand filter --}}
<div class="mb-7">
    <label class="block text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3">Brand</label>
    <div class="space-y-1">
        @php
            $brands = \App\Models\Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();
        @endphp
        @foreach($brands as $brand)
            <label class="flex items-center gap-2.5 py-1 cursor-pointer group">
                <input type="checkbox" name="brand[]" value="{{ $brand }}"
                       {{ in_array($brand, request('brand', [])) ? 'checked' : '' }}
                       onchange="this.form.submit()"
                       class="text-brand-600 focus:ring-brand-500 border-zinc-300 rounded">
                <span class="text-sm text-zinc-700 group-hover:text-zinc-900 transition-colors">{{ $brand }}</span>
            </label>
        @endforeach
    </div>
</div>
                {{-- Price range --}}
                <div class="mb-7">
                    <label class="block text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3">Price Range</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-zinc-400 text-xs">$</span>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" min="0" placeholder="Min"
                                   class="w-full pl-5 pr-2 py-2 rounded-lg border border-zinc-200 focus:border-brand-500 outline-none text-xs">
                        </div>
                        <span class="text-zinc-300 text-sm">—</span>
                        <div class="relative flex-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-zinc-400 text-xs">$</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" min="0" placeholder="Max"
                                   class="w-full pl-5 pr-2 py-2 rounded-lg border border-zinc-200 focus:border-brand-500 outline-none text-xs">
                        </div>
                    </div>
                    <button type="submit" class="mt-2 w-full py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 text-xs font-semibold rounded-lg transition-colors">
                        Apply
                    </button>
                </div>

                {{-- Clear filters --}}
                @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                    <a href="{{ route('shop.catalog') }}" class="block text-center text-xs text-brand-600 hover:text-brand-700 font-medium py-2 transition-colors">
                        Clear all filters
                    </a>
                @endif
            </form>
        </aside>

        {{-- Product grid --}}
        <div class="flex-1">
            @if($products->isEmpty())
                <div class="text-center py-24">
                    <div class="w-16 h-16 bg-surface-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h2 class="font-display text-2xl font-semibold text-zinc-900 mb-2">No products found</h2>
                    <p class="text-zinc-400 mb-6">Try adjusting your filters or search term.</p>
                    <a href="{{ route('shop.catalog') }}" class="inline-flex items-center gap-2 bg-zinc-900 text-white text-sm font-semibold px-6 py-3 rounded-xl hover:bg-brand-600 transition-all">
                        Clear Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
