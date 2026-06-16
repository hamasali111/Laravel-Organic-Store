@extends('layouts.app')
@section('title','Wishlist — Organic_store')
@push('styles')
<style>
.page-wrap{max-width:1100px;margin:40px auto;padding:0 24px}
.page-title{font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:28px}
.empty-state{text-align:center;padding:60px 24px}
.empty-state span{font-size:3.5rem;display:block;margin-bottom:16px}
</style>
@endpush
@section('content')
<div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>›</span>Wishlist</div>
<div class="page-wrap">
    <h1 class="page-title">My Wishlist</h1>
    @if($items->isEmpty())
    <div class="empty-state">
        <span>💚</span>
        <h2 style="font-family:'Playfair Display',serif;margin-bottom:12px">Your wishlist is empty</h2>
        <p style="color:var(--muted);margin-bottom:24px">Save products you love and find them here.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary">Browse Products</a>
    </div>
    @else
    <div class="products-grid">
        @foreach($items as $item)
        <div class="product-card">
            <a href="{{ route('product.show', $item->product->slug) }}">
                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" loading="lazy">
            </a>
            <div class="product-card-body">
                <div class="product-card-cat">{{ $item->product->category->name ?? '' }}</div>
                <a href="{{ route('product.show', $item->product->slug) }}">
                    <div class="product-card-name">{{ $item->product->name }}</div>
                </a>
                <div class="product-card-desc">{{ $item->product->description }}</div>
                <div class="product-card-footer">
                    <span class="product-price">PKR {{ number_format($item->product->price,0) }}</span>
                    @if($item->product->is_organic)<span class="organic-badge">Organic</span>@endif
                </div>
                <div style="display:flex;gap:8px;margin-top:10px">
                    <form action="{{ route('cart.add') }}" method="POST" style="flex:1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;font-size:.82rem">Add to Cart</button>
                    </form>
                    <form action="{{ route('wishlist.toggle') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <button type="submit" class="btn btn-danger btn-sm" title="Remove">🗑</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
