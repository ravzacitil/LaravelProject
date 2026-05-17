<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function index(): View|RedirectResponse
    {
        $cart = auth()->user()->getCartOrCreate();
        $cart->load('items.product');

        if ($cart->isEmpty()) {
           return redirect()->route('shop.cart.index')->with('error', 'Your cart is empty.');
        }

        $user = auth()->user();

        
        $subtotal = $cart->subtotal;
        $shipping = $subtotal >= 50 ? 0 : 5.99;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;
        return view('shop.checkout.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'shipping_name'        => ['required', 'string', 'max:150'],
            'shipping_email'       => ['required', 'email', 'max:150'],
            'shipping_phone'       => ['nullable', 'string', 'max:30'],
            'shipping_address'     => ['required', 'string', 'max:255'],
            'shipping_city'        => ['required', 'string', 'max:100'],
            'shipping_country'     => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:20'],
            'payment_method'       => ['required', 'in:credit_card,paypal,bank_transfer'],
            'customer_notes'       => ['nullable', 'string', 'max:500'],
        ]);

        $cart = auth()->user()->getCartOrCreate();
        $cart->load('items.product');

        if ($cart->isEmpty()) {
            return redirect()->route('shop.cart')
                             ->with('error', 'Your cart is empty.');
        }

        // Validate stock for all items before creating order
        foreach ($cart->items as $item) {
            if ($item->product->stock_quantity < $item->quantity) {
                return back()->with('error', "Sorry, {$item->product->name} only has {$item->product->stock_quantity} units left in stock.");
            }
        }

        $order = DB::transaction(function () use ($cart, $validated) {
            $subtotal       = $cart->subtotal;
            $taxAmount      = round($subtotal * 0.08, 2); // 8% tax
            $shippingAmount = $subtotal >= 50 ? 0.00 : 5.99; // free shipping over $50
            $totalAmount    = $subtotal + $taxAmount + $shippingAmount;

            $order = Order::create([
                ...$validated,
                'user_id'         => auth()->id(),
                'order_number'    => Order::generateOrderNumber(),
                'status'          => Order::STATUS_PENDING,
                'payment_status'  => Order::PAYMENT_PAID, // simulated payment success
                'subtotal'        => $subtotal,
                'tax_amount'      => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => 0,
                'total_amount'    => $totalAmount,
            ]);

            // Create order items from cart items and reduce stock
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $cartItem->product_id,
                    'product_name'  => $cartItem->product->name,
                    'product_sku'   => $cartItem->product->sku,
                    'product_image' => $cartItem->product->primary_image,
                    'unit_price'    => $cartItem->unit_price,
                    'quantity'      => $cartItem->quantity,
                    'line_total'    => $cartItem->line_total,
                ]);

                $cartItem->product->decreaseStock($cartItem->quantity);
            }

            // Clear cart after successful order
            $cart->clear();

            return $order;
        });

        return redirect()->route('shop.checkout.success', $order->order_number)
                         ->with('success', 'Your order has been placed successfully!');
    }

    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
                      ->where('user_id', auth()->id())
                      ->with('items')
                      ->firstOrFail();

        return view('shop.checkout.success', compact('order'));
    }
}
