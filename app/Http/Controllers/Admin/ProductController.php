<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products   = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        $validated['slug']          = Str::slug($validated['name']);
        $validated['primary_image'] = $this->handleImageUpload($request, 'primary_image');
        $validated['gallery_images'] = $this->handleGalleryUpload($request);

        Product::create($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::active()->ordered()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product->id);

        if ($request->hasFile('primary_image')) {
            // Delete old image from storage
            if ($product->primary_image) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $validated['primary_image'] = $this->handleImageUpload($request, 'primary_image');
        }

        if ($request->hasFile('gallery_images')) {
            $validated['gallery_images'] = $this->handleGalleryUpload($request);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->primary_image) {
            Storage::disk('public')->delete($product->primary_image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Product {$status} successfully.");
    }

    // ── Private Helpers ────────────────────────────────────────────────────────

    private function validateProduct(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'integer', 'exists:categories,id'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'sku'               => ['nullable', 'string', 'max:100', 'unique:products,sku,' . $productId],
            'price'             => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'compare_price'     => ['nullable', 'numeric', 'min:0', 'max:999999.99', 'gt:price'],
            'stock_quantity'    => ['required', 'integer', 'min:0'],
            'weight'            => ['nullable', 'numeric', 'min:0'],
            'brand'             => ['nullable', 'string', 'max:150'],
            'primary_image'     => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'gallery_images'    => ['nullable', 'array', 'max:6'],
            'gallery_images.*'  => ['image', 'mimes:jpeg,png,webp', 'max:2048'],
            'is_active'         => ['boolean'],
            'is_featured'       => ['boolean'],
        ]);
    }

    private function handleImageUpload(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $request->file($field)->store('products', 'public');
    }

    private function handleGalleryUpload(Request $request): array
    {
        if (! $request->hasFile('gallery_images')) {
            return [];
        }

        $paths = [];
        foreach ($request->file('gallery_images') as $file) {
            $paths[] = $file->store('products/gallery', 'public');
        }

        return $paths;
    }
}
