@extends('layouts.app')

@section('title', isset($category) ? $category->name . ' — Organic Store' : 'Shop All Organic Products — Organic Store')

@push('styles')
    <style>
        .shop-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 40px;
        }

        .sidebar-section {
            margin-bottom: 28px;
        }

        .sidebar-section h4 {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .cat-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: .9rem;
            color: var(--text);
            transition: background .15s;
            margin-bottom: 2px;
        }

        .cat-link:hover,
        .cat-link.active {
            background: var(--green-pale);
            color: var(--green);
        }

        .cat-link span {
            font-size: .78rem;
            background: var(--border);
            border-radius: 50px;
            padding: 1px 8px;
        }

        .price-range-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .price-input {
            width: 90px;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: .85rem;
            background: var(--bg);
        }

        .shop-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .shop-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .shop-controls {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-form {
            display: flex;
            gap: 8px;
        }

        .search-input {
            padding: 8px 16px;
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .88rem;
            outline: none;
            background: var(--bg);
        }

        .sort-select {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .88rem;
            background: var(--bg);
            cursor: pointer;
        }

        .no-products {
            text-align: center;
            padding: 60px;
            color: var(--muted);
        }

        .no-products span {
            font-size: 3rem;
            display: block;
            margin-bottom: 16px;
        }

        .stock-label {
            display: inline-block;
            font-size: .72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 50px;
            margin-bottom: 4px;
        }

        .stock-in  { background: #d8f3dc; color: #2d6a4f; }
        .stock-low { background: #fef3c7; color: #92400e; }
        .stock-out { background: #fde8e8; color: #c0392b; }

        .badge-new {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #2d6a4f;
            color: white;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            letter-spacing: .05em;
            text-transform: uppercase;
            z-index: 2;
        }

        .badge-featured {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e9a825;
            color: white;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            z-index: 2;
        }

        .product-card { position: relative; }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green-pale);
            color: var(--green);
            font-size: .78rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            min-width: 40px;
            border-radius: 12px;
            border: 1px solid #d8f3dc;
            background: #ffffff;
            color: #2d6a4f;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
        }

        .pagination .page-link:hover {
            background: #2d6a4f;
            border-color: #2d6a4f;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: #2d6a4f;
            border-color: #2d6a4f;
            color: #ffffff;
            font-weight: 600;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media(max-width: 768px) {
            .shop-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <a href="{{ route('shop') }}">Shop</a>
        @if (isset($category))
            <span>›</span> {{ $category->name }}
        @endif
    </div>

    <div class="shop-layout">
        <aside class="sidebar">

            <form action="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}" method="GET" id="filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <div class="sidebar-section">
                    <h4>Categories</h4>
                    <a href="{{ route('shop') }}" class="cat-link {{ !isset($category) ? 'active' : '' }}">
                        All Products
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('shop.category', $cat->slug) }}"
                            class="cat-link {{ isset($category) && $category->id === $cat->id ? 'active' : '' }}">
                            {{ $cat->name }}
                            <span>{{ $cat->products_count }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="sidebar-section">
                    <h4>Price Range (PKR)</h4>
                    <div class="price-range-row">
                        <input type="number" name="min_price" class="price-input" placeholder="Min"
                            value="{{ request('min_price') }}" min="0">
                        <span style="color:var(--muted);font-size:.8rem">–</span>
                        <input type="number" name="max_price" class="price-input" placeholder="Max"
                            value="{{ request('max_price') }}" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:10px;width:100%;justify-content:center">
                        Apply Filter
                    </button>
                </div>

                <div class="sidebar-section">
                    <h4>Filter By</h4>
                    <div style="display:flex;flex-direction:column;gap:8px;font-size:.88rem;color:var(--muted);">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="organic" value="1" {{ request('organic') == '1' ? 'checked' : '' }}
                                onchange="document.getElementById('filter-form').submit()">
                            🌱 Certified Organic
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="featured" value="1" {{ request('featured') == '1' ? 'checked' : '' }}
                                onchange="document.getElementById('filter-form').submit()">
                            ⭐ Featured
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }}
                                onchange="document.getElementById('filter-form').submit()">
                            ✅ In Stock Only
                        </label>
                    </div>
                </div>

                @if(request()->hasAny(['min_price','max_price','organic','featured','in_stock']))
                    <a href="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}"
                        class="btn btn-sm btn-gray" style="width:100%;justify-content:center;margin-top:4px">
                        ✕ Clear Filters
                    </a>
                @endif
            </form>

        </aside>

        <div>
            <div class="shop-header">
                <h1>{{ isset($category) ? $category->name : 'All Organic Products' }}</h1>
                <div class="shop-controls">
                    <form action="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}"
                        method="GET" class="search-form">
                        @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                        <input type="text" name="search" class="search-input" placeholder="Search products..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </form>
                    <form action="{{ isset($category) ? route('shop.category', $category->slug) : route('shop') }}"
                        method="GET">
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                        @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                        <select name="sort" class="sort-select" onchange="this.form.submit()">
                            <option value="">Sort by</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        </select>
                    </form>
                </div>
            </div>

            @if(request()->hasAny(['min_price','max_price','organic','featured','in_stock','search']))
                <div style="margin-bottom:16px">
                    @if(request('search'))
                        <span class="filter-chip">Search: "{{ request('search') }}"</span>
                    @endif
                    @if(request('min_price') || request('max_price'))
                        <span class="filter-chip">PKR {{ request('min_price',0) }} – {{ request('max_price','∞') }}</span>
                    @endif
                    @if(request('organic') == '1') <span class="filter-chip">🌱 Organic</span> @endif
                    @if(request('featured') == '1') <span class="filter-chip">⭐ Featured</span> @endif
                    @if(request('in_stock') == '1') <span class="filter-chip">✅ In Stock</span> @endif
                </div>
            @endif

            @if ($products->isEmpty())
                <div class="no-products">
                    <span>🥦</span>
                    <p>No products found. Try a different search or category.</p>
                    <a href="{{ route('shop') }}" class="btn btn-outline" style="margin-top:16px">View All Products</a>
                </div>
            @else
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:20px;">
                    {{ $products->total() }} product{{ $products->total() != 1 ? 's' : '' }} found
                    @if($products->lastPage() > 1)
                        — Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                    @endif
                </p>
                <div class="products-grid">
                    @foreach ($products as $product)
                        @php
                            $isNew = $product->created_at->diffInDays(now()) <= 14;
                        @endphp
                        <div class="product-card">
                            @if($isNew)
                                <div class="badge-new">New</div>
                            @endif
                            @if($product->is_featured && !$isNew)
                                <div class="badge-featured">⭐</div>
                            @endif
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}" loading="lazy"
                                    onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                            </a>
                            <div class="product-card-body">
                                <div class="product-card-cat">{{ $product->category->name }}</div>
                                @php
                                    if ($product->stock <= 0) { $sl = 'stock-out'; $st = 'Out of Stock'; }
                                    elseif ($product->stock <= 5) { $sl = 'stock-low'; $st = 'Low Stock'; }
                                    else { $sl = 'stock-in'; $st = 'In Stock'; }
                                @endphp
                                <span class="stock-label {{ $sl }}">{{ $st }}</span>
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <div class="product-card-name">{{ $product->name }}</div>
                                </a>
                                <div class="product-card-desc">{{ Str::limit($product->description, 70) }}</div>
                                <div class="product-card-footer">
                                    <span class="product-price">PKR {{ number_format($product->price, 0) }}</span>
                                    @if ($product->is_organic)
                                        <span class="organic-badge">Organic</span>
                                    @endif
                                </div>
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST" style="margin-top:12px">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-primary"
                                            style="width:100%;justify-content:center">🛒 Add to Cart</button>
                                    </form>
                                @else
                                    <button class="btn btn-gray" style="width:100%;justify-content:center;margin-top:12px" disabled>
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
