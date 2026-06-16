<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->handleImage($request, null);
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product);
        $data['image'] = $this->handleImage($request, $product);
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Str::startsWith($product->image, '/storage/')) {
            Storage::disk('public')->delete(Str::after($product->image, '/storage/'));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function handleImage(Request $request, ?Product $product): string
    {
        if ($request->hasFile('image_upload') && $request->file('image_upload')->isValid()) {
            if ($product && $product->image && Str::startsWith($product->image, '/storage/')) {
                Storage::disk('public')->delete(Str::after($product->image, '/storage/'));
            }
            $path = $request->file('image_upload')->store('products', 'public');
            return '/storage/' . $path;
        }
        if ($request->filled('image')) {
            return $request->input('image');
        }
        return $product?->image ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80';
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|url',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'weight'       => 'nullable|string|max:50',
            'is_featured'  => 'boolean',
            'is_organic'   => 'boolean',
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_organic']  = $request->boolean('is_organic');
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        unset($data['image'], $data['image_upload']);
        return $data;
    }
}
