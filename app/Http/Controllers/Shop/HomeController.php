<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $categories = Category::active()
            ->parentOnly()
            ->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->take(6)
            ->get();

        $newArrivals = Product::active()
            ->inStock()
            ->with('category')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        $bestSellers = Product::active()
            ->inStock()
            ->with('category')
            ->orderByDesc('views_count')
            ->take(4)
            ->get();

        return view('shop.home', compact('featuredProducts', 'categories', 'newArrivals', 'bestSellers'));
    }
}
