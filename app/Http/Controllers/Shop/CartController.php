<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Resolve the current cart for authenticated user or guest session.
     */
    private function resolveCart(): Cart
    {
        if (auth()->check()) {
            return auth()->user()->getCartOrCreate();
        }

        $sessionId = session()->getId();

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index(): View
    {
        $cart = $this->resolveCart();
        $cart->load('items.product.category');

        return view('shop.cart', compact('cart'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::active()->findOrFail($request->product_id);

        if (! $product->is_in_stock) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        $cart = $this->resolveCart();
        $cart->addItem($product, (int) $request->quantity);

        return back()->with('success', "{$product->name} has been added to your cart.");
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        // Ensure item belongs to current cart
        $cart = $this->resolveCart();
        abort_unless($cartItem->cart_id === $cart->id, 403);

        $cartItem->update(['quantity' => (int) $request->quantity]);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        $cart = $this->resolveCart();
        abort_unless($cartItem->cart_id === $cart->id, 403);

        $productName = $cartItem->product->name ?? 'Item';
        $cartItem->delete();

        return back()->with('success', "{$productName} has been removed from your cart.");
    }

    public function clear(): RedirectResponse
    {
        $this->resolveCart()->clear();

        return back()->with('success', 'Your cart has been cleared.');
    }

    /**
     * Return cart item count as JSON (used by the header mini-cart).
     */
    public function count(): JsonResponse
    {
        $cart = $this->resolveCart();

        return response()->json(['count' => $cart->total_items]);
    }
}
