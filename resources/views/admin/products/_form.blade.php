<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-xl">
            <ul class="text-sm text-red-700 space-y-1">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid xl:grid-cols-3 gap-6">

        {{-- Main column --}}
        <div class="xl:col-span-2 space-y-6">

            {{-- Basic info --}}
            <div class="bg-white rounded-2xl border border-zinc-100 p-6">
                <h3 class="font-display font-semibold text-zinc-900 mb-5">Product Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product?->name) }}" required
                               class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('name') border-red-400 @enderror"
                               placeholder="e.g. ProSound Wireless Headphones">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product?->sku) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm font-mono uppercase"
                                   placeholder="ELC-HP-001">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1.5">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $product?->brand) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                                   placeholder="e.g. Sony, Nike...">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Short Description</label>
                        <textarea name="short_description" rows="2"
                                  class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm resize-none"
                                  placeholder="A brief compelling summary shown in product cards...">{{ old('short_description', $product?->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Full Description</label>
                        <textarea name="description" rows="8"
                                  class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                                  placeholder="HTML is supported for rich formatting...">{{ old('description', $product?->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="bg-white rounded-2xl border border-zinc-100 p-6">
                <h3 class="font-display font-semibold text-zinc-900 mb-5">Pricing & Inventory</h3>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Sale Price <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 text-sm font-medium">$</span>
                            <input type="number" name="price" value="{{ old('price', $product?->price) }}" step="0.01" min="0" required
                                   class="w-full pl-8 pr-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('price') border-red-400 @enderror"
                                   placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Compare Price <span class="text-zinc-400 font-normal">(optional)</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 text-sm font-medium">$</span>
                            <input type="number" name="compare_price" value="{{ old('compare_price', $product?->compare_price) }}" step="0.01" min="0"
                                   class="w-full pl-8 pr-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                                   placeholder="Original price">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 mb-1.5">Stock Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product?->stock_quantity ?? 0) }}" min="0" required
                               class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('stock_quantity') border-red-400 @enderror"
                               placeholder="0">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $product?->weight) }}" step="0.001" min="0"
                           class="w-full sm:w-40 px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm"
                           placeholder="0.500">
                </div>
            </div>
        </div>

        {{-- Sidebar column --}}
        <div class="space-y-6">

            {{-- Publish settings --}}
            <div class="bg-white rounded-2xl border border-zinc-100 p-6">
                <h3 class="font-display font-semibold text-zinc-900 mb-5">Publish Settings</h3>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" required
                            class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 outline-none text-sm @error('category_id') border-red-400 @enderror">
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product?->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4 space-y-3">
                    <label class="flex items-center justify-between py-2.5 cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-zinc-700">Active</p>
                            <p class="text-xs text-zinc-400">Visible in the storefront</p>
                        </div>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $product?->is_active ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-zinc-300 text-brand-600 focus:ring-brand-500">
                    </label>
                    <div class="border-t border-zinc-100"></div>
                    <label class="flex items-center justify-between py-2.5 cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-zinc-700">Featured</p>
                            <p class="text-xs text-zinc-400">Show on homepage</p>
                        </div>
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1"
                               {{ old('is_featured', $product?->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-zinc-300 text-brand-600 focus:ring-brand-500">
                    </label>
                </div>
            </div>

            {{-- Images --}}
            <div class="bg-white rounded-2xl border border-zinc-100 p-6">
                <h3 class="font-display font-semibold text-zinc-900 mb-5">Product Images</h3>

                {{-- Current image preview --}}
                @if($product?->primary_image)
                    <div class="mb-3">
                        <p class="text-xs text-zinc-400 mb-2">Current Image</p>
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full aspect-square object-cover rounded-xl border border-zinc-100">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Primary Image</label>
                    <input type="file" name="primary_image" accept="image/jpeg,image/png,image/webp"
                           class="w-full text-sm text-zinc-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-all">
                    <p class="text-xs text-zinc-400 mt-1">JPEG, PNG, WebP — max 2MB</p>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-zinc-700 mb-1.5">Gallery Images <span class="text-zinc-400 font-normal">(up to 6)</span></label>
                    <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple
                           class="w-full text-sm text-zinc-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-50 file:text-zinc-700 hover:file:bg-zinc-100 transition-all">
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-brand-600 text-white font-semibold text-sm py-3.5 rounded-xl hover:bg-brand-700 transition-all shadow-sm active:scale-[0.98]">
                    {{ $btnLabel }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center justify-center px-4 py-3.5 rounded-xl border border-zinc-200 text-sm font-medium text-zinc-600 hover:bg-zinc-100 transition-colors">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
