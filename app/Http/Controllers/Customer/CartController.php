<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $cart->load(['items.product', 'items.variant']);

        return inertia('Customer/Cart', [
            'cart' => $cart,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['variant_id']) {
            $variant = ProductVariant::where('id', $validated['variant_id'])
                ->where('product_id', $product->id)
                ->firstOrFail();
            $price = $variant->price ?? $product->price;
            $stock = $variant->stock_quantity;
        } else {
            $price = $product->price;
            $stock = $product->stock_quantity;
        }

        if ($stock < $validated['quantity']) {
            return back()->with('error', 'Requested quantity not available in stock.');
        }

        $cart = $this->getCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->where('variant_id', $validated['variant_id'] ?? null)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $validated['quantity'];
            if ($newQuantity > $stock) {
                return back()->with('error', 'Total quantity exceeds available stock.');
            }
            $cartItem->update([
                'quantity' => $newQuantity,
                'total' => $price * $newQuantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $validated['product_id'],
                'variant_id' => $validated['variant_id'] ?? null,
                'quantity' => $validated['quantity'],
                'price' => $price,
                'total' => $price * $validated['quantity'],
            ]);
        }

        $this->calculateCartTotals($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cartItem->product;
        $variant = $cartItem->variant;
        $stock = $variant ? $variant->stock_quantity : $product->stock_quantity;

        if ($validated['quantity'] > $stock) {
            return back()->with('error', 'Requested quantity not available in stock.');
        }

        $cartItem->update([
            'quantity' => $validated['quantity'],
            'total' => $cartItem->price * $validated['quantity'],
        ]);

        $this->calculateCartTotals($cartItem->cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();

        $this->calculateCartTotals($cart);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();

        $this->calculateCartTotals($cart);

        return back()->with('success', 'Cart cleared.');
    }

    protected function getCart(): Cart
    {
        $user = auth()->user();

        if ($user) {
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id],
                ['subtotal' => 0, 'tax' => 0, 'total' => 0]
            );
        } else {
            $sessionId = request()->session()->getId();
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId],
                ['subtotal' => 0, 'tax' => 0, 'total' => 0]
            );
        }

        return $cart;
    }

    protected function calculateCartTotals(Cart $cart): void
    {
        $cart->load('items');
        $cart->subtotal = $cart->items->sum('total');
        $cart->tax = $cart->subtotal * config('cart.tax_rate', 0);
        $cart->total = $cart->subtotal + $cart->tax;
        $cart->save();
    }
}
