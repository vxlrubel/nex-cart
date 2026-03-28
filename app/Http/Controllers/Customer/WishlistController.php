<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('product.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return inertia('Customer/Wishlist', [
            'wishlists' => $wishlists,
        ]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($exists) {
            return back()->with('info', 'Product is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
        ]);

        return back()->with('success', 'Product added to wishlist.');
    }

    public function remove(Wishlist $wishlist)
    {
        $wishlist->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Product removed from wishlist.';
            $inWishlist = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
            ]);
            $message = 'Product added to wishlist.';
            $inWishlist = true;
        }

        return back()->with(['success' => $message, 'in_wishlist' => $inWishlist]);
    }
}
