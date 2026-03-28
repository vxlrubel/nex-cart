<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $cart->load(['items.product', 'items.variant']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $addresses = auth()->user()
            ? auth()->user()->addresses()->where('is_default', true)->get()
            : collect([]);

        return inertia('Customer/Checkout', [
            'cart' => $cart,
            'addresses' => $addresses,
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|exists:coupons,code',
        ]);

        $coupon = Coupon::where('code', strtoupper($validated['code']))->first();

        if (! $coupon->isValid()) {
            return back()->with('error', 'This coupon is invalid or expired.');
        }

        $cart = $this->getCart();
        $discount = $coupon->calculateDiscount($cart->subtotal);

        return back()->with([
            'coupon_discount' => $discount,
            'coupon_code' => $coupon->code,
        ]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:2',
            'payment_method' => 'required|in:cod,card,paypal',
            'save_address' => 'boolean',
        ]);

        $cart = $this->getCart();
        $cart->load(['items.product', 'items.variant']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            $product = $item->product;
            $stock = $item->variant ? $item->variant->stock_quantity : $product->stock_quantity;

            if ($stock < $item->quantity) {
                return back()->with('error', "Product {$product->name} does not have enough stock.");
            }
        }

        $couponDiscount = 0;
        if ($request->has('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                $couponDiscount = $coupon->calculateDiscount($cart->subtotal);
                $coupon->increment('used_count');
            }
        }

        $shippingCost = config('cart.shipping_cost', 0);
        $subtotal = $cart->subtotal;
        $tax = $cart->tax;
        $total = $subtotal + $tax + $shippingCost - $couponDiscount;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'discount' => $couponDiscount,
                'total' => $total,
                'shipping_name' => $validated['shipping_first_name'].' '.$validated['shipping_last_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'ordered_at' => now(),
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'variant_name' => $item->variant?->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
                ]);

                if ($item->variant) {
                    $item->variant->decrement('stock_quantity', $item->quantity);
                } else {
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
            }

            if (auth()->check() && $validated['save_address']) {
                Address::create([
                    'user_id' => auth()->id(),
                    'type' => 'shipping',
                    'first_name' => $validated['shipping_first_name'],
                    'last_name' => $validated['shipping_last_name'],
                    'address_line_1' => $validated['shipping_address'],
                    'city' => $validated['shipping_city'],
                    'state' => $validated['shipping_state'],
                    'postal_code' => $validated['shipping_postal_code'],
                    'country' => $validated['shipping_country'],
                    'phone' => $validated['shipping_phone'],
                ]);
            }

            $cart->items()->delete();
            $cart->update(['subtotal' => 0, 'tax' => 0, 'total' => 0]);

            DB::commit();

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to process order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        $order->load(['items.product', 'items.variant']);

        return inertia('Customer/OrderSuccess', [
            'order' => $order,
        ]);
    }

    protected function getCart(): Cart
    {
        $user = auth()->user();

        if ($user) {
            return Cart::firstOrCreate(
                ['user_id' => $user->id],
                ['subtotal' => 0, 'tax' => 0, 'total' => 0]
            );
        }

        $sessionId = request()->session()->getId();

        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['subtotal' => 0, 'tax' => 0, 'total' => 0]
        );
    }
}
