<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display paginated product catalog with filtering and sorting.
     */
    public function index(Request $request): View
    {
        $query = Product::active()->inStock()->with('category');

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->inCategory($category->id);
        } else {
            $category = null;
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Sorting
        $sortOptions = [
            'latest'     => ['created_at', 'desc'],
            'price_asc'  => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'popular'    => ['views_count', 'desc'],
            'name_asc'   => ['name', 'asc'],
        ];

        $sort = $request->get('sort', 'latest');
        [$sortColumn, $sortDirection] = $sortOptions[$sort] ?? $sortOptions['latest'];
        $query->orderBy($sortColumn, $sortDirection);

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::active()->parentOnly()->ordered()->withCount(['products' => fn ($q) => $q->active()])->get();
        $brands     = Product::active()->distinct()->whereNotNull('brand')->pluck('brand')->sort()->values();

        return view('shop.catalog', compact('products', 'categories', 'category', 'brands', 'sort'));
    }

    /**
     * Display a single product detail page.
     */
    public function show(string $slug): View
    {
        $product = Product::active()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $product->incrementViews();

        $relatedProducts = Product::active()
            ->inStock()
            ->inCategory($product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->take(4)
            ->get();

        return view('shop.product', compact('product', 'relatedProducts'));
    }
}
