@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage your product catalog')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <form method="GET" class="flex items-center gap-3 flex-1 max-w-xl">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                   class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm">
        </div>
        <select name="category_id" class="px-3 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="px-3 py-2.5 rounded-xl border border-zinc-200 focus:border-brand-500 outline-none text-sm">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button type="submit" class="px-4 py-2.5 bg-zinc-900 text-white text-sm font-semibold rounded-xl hover:bg-brand-600 transition-colors">Filter</button>
    </form>

    <a href="{{ route('admin.products.create') }}"
       class="flex items-center gap-2 bg-brand-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-brand-700 transition-colors shadow-sm flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Product
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-2xl border border-zinc-100 overflow-hidden">
<div class="px-5 py-3 border-b border-zinc-50 text-xs text-zinc-400">
    {{ $products->total() }} product(s) found
</div>
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-zinc-100">
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Product</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Category</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Price</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Stock</th>
                <th class="text-left px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Status</th>
                <th class="text-right px-5 py-4 text-xs font-semibold text-zinc-400 uppercase tracking-widest">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-zinc-50">
            @forelse($products as $product)
                <tr class="hover:bg-zinc-50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-surface-100 flex-shrink-0 overflow-hidden border border-zinc-100">
                                @if($product->primary_image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-zinc-900 leading-tight">{{ $product->name }}</p>
                                @if($product->sku)
                                    <p class="text-xs text-zinc-400 font-mono">{{ $product->sku }}</p>
                                @endif
                                @if($product->is_featured)
                                    <span class="text-xs bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full font-medium">Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-zinc-600">{{ $product->category->name }}</td>
                    <td class="px-5 py-4">
                        <span class="font-semibold text-zinc-900">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="text-xs text-zinc-400 line-through ml-1">${{ number_format($product->compare_price, 2) }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="text-sm font-medium {{ $product->stock_quantity === 0 ? 'text-red-600' : ($product->stock_quantity <= 5 ? 'text-amber-600' : 'text-zinc-700') }}">
                            {{ $product->stock_quantity }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="relative inline-flex items-center h-5 rounded-full w-9 transition-colors focus:outline-none {{ $product->is_active ? 'bg-green-500' : 'bg-zinc-300' }}">
                                <span class="inline-block w-3.5 h-3.5 transform bg-white rounded-full shadow transition-transform {{ $product->is_active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                            </button>
                        </form>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('shop.product', $product->slug) }}" target="_blank"
                               class="p-2 text-zinc-400 hover:text-zinc-700 hover:bg-zinc-100 rounded-lg transition-all" title="View in store">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="p-2 text-zinc-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline"
                                  onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This action cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-zinc-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-zinc-400">
                        <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t border-zinc-50">
        {{ $products->links() }}
    </div>
</div>
@endsection
