@extends('layouts.admin')
@section('title','Products — Admin')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>

@if(session('success'))
    <div style="background:#e6f4ea;color:#2d6a4f;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="admin-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
        <tr>
            <td>
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     style="width:48px;height:48px;border-radius:8px;object-fit:cover"
                     onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=200&q=60'">
            </td>
            <td><strong>{{ $product->name }}</strong></td>
            <td>{{ $product->category->name }}</td>
            <td>PKR {{ number_format($product->price,0) }}</td>
            <td>
                <span style="color:{{ $product->stock < 5 ? 'var(--red)' : 'var(--green)' }};font-weight:600">{{ $product->stock }}</span>
            </td>
            <td>{{ $product->is_featured ? '⭐' : '—' }}</td>
            <td>
                <div style="display:flex;gap:6px">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline">Edit</a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">
                No products yet. <a href="{{ route('admin.products.create') }}">Add one</a>.
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px">{{ $products->links() }}</div>
</div>
@endsection
