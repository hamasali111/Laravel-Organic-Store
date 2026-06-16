<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|url|max:2048',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        Category::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image'       => $this->handleImage($request, null),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'description'  => 'nullable|string',
            'image'        => 'nullable|string|url|max:2048',
            'image_upload' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $category->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'image'       => $this->handleImage($request, $category),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->deleteStoredImage($category->image);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    // ── Private helpers ───────────────────────────────────────────

    private function handleImage(Request $request, ?Category $category): ?string
    {
        // Priority 1: new file upload
        if ($request->hasFile('image_upload') && $request->file('image_upload')->isValid()) {
            if ($category) {
                $this->deleteStoredImage($category->image);
            }
            $path = $request->file('image_upload')->store('categories', 'public');
            return '/storage/' . $path;
        }

        // Priority 2: URL was provided
        $url = trim($request->input('image', ''));
        if ($url !== '') {
            return $url;
        }

        // Priority 3: keep existing image (edit) or null (create)
        return $category?->image;
    }

    private function deleteStoredImage(?string $image): void
    {
        if ($image && str_starts_with($image, '/storage/')) {
            $relativePath = Str::after($image, '/storage/');
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}
