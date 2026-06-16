<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $query      = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        if ($request->filled('organic') && $request->organic === '1') {
            $query->where('is_organic', true);
        }

        if ($request->filled('featured') && $request->featured === '1') {
            $query->where('is_featured', true);
        }

        if ($request->filled('in_stock') && $request->in_stock === '1') {
            $query->where('stock', '>', 0);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->latest(),
                'rating'     => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
                default      => $query->orderBy('name'),
            };
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }

    public function category(Request $request, $slug)
    {
        $category   = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::withCount('products')->get();
        $query      = Product::where('category_id', $category->id)->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }
        if ($request->filled('in_stock') && $request->in_stock === '1') {
            $query->where('stock', '>', 0);
        }
        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->latest(),
                default      => $query->orderBy('name'),
            };
        }

        $products = $query->paginate(12)->withQueryString();
        return view('shop.index', compact('products', 'categories', 'category'));
    }

    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->with(['category', 'reviews.user'])->firstOrFail();

        // Track recently viewed (session-based, max 6)
        $viewed = session()->get('recently_viewed', []);
        $viewed = array_filter($viewed, fn($id) => $id !== $product->id);
        array_unshift($viewed, $product->id);
        $viewed = array_slice($viewed, 0, 6);
        session()->put('recently_viewed', $viewed);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')->take(4)->get();

        return view('shop.show', compact('product', 'related'));
    }
}
