<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($request->category, function ($query, $categorySlug) {
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $categoryIds = Category::where('parent_id', $category->id)
                        ->pluck('id')
                        ->push($category->id);
                    $query->whereIn('category_id', $categoryIds);
                }
            })
            ->when($request->min_price, function ($query, $minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($request->max_price, function ($query, $maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->when($request->sort, function ($query, $sort) {
                switch ($sort) {
                    case 'price_asc':
                        $query->orderBy('price');
                        break;
                    case 'price_desc':
                        $query->orderByDesc('price');
                        break;
                    case 'name':
                        $query->orderBy('name');
                        break;
                    default:
                        $query->latest();
                }
            }, function ($query) {
                $query->latest();
            })
            ->paginate(12);

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return inertia('Customer/Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'min_price', 'max_price', 'sort']),
        ]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants', 'reviews' => function ($query) {
            $query->where('status', 'approved')->latest()->take(10);
        }]);

        $relatedProducts = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return inertia('Customer/Products/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
