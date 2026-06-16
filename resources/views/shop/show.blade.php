@extends('layouts.app')
@section('title', $product->name . ' — Organic_store')
@push('styles')
<style>
    .product-detail { max-width:1200px; margin:0 auto; padding:40px 24px; }
    .product-layout { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start; }
    .product-image-wrap { border-radius:20px; overflow:hidden; box-shadow:var(--shadow-md); aspect-ratio:1; }
    .product-image-wrap img { width:100%; height:100%; object-fit:cover; }
    .product-info h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; margin-bottom:12px; }
    .product-meta { display:flex; gap:12px; align-items:center; margin-bottom:20px; flex-wrap:wrap; }
    .product-description { font-size:.95rem; color:var(--muted); line-height:1.75; margin-bottom:24px; }
    .product-price-big { font-size:2.2rem; font-weight:700; color:var(--green); margin-bottom:8px; }
    .product-weight { font-size:.85rem; color:var(--muted); margin-bottom:24px; }
    .stock-badge { display:inline-block; padding:4px 12px; border-radius:50px; font-size:.8rem; font-weight:600; }
    .in-stock { background:var(--green-pale); color:var(--green); }
    .out-stock { background:#fde8e8; color:var(--red); }
    .add-form { display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap; }
    .qty-input { width:80px; padding:10px 14px; border:1px solid var(--border); border-radius:50px; text-align:center; font-size:1rem; }
    .divider { border:none; border-top:1px solid var(--border); margin:28px 0; }
    .product-attrs { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .attr-item { background:var(--green-xpale); border-radius:10px; padding:14px 16px; }
    .attr-label { font-size:.72rem; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); font-weight:600; margin-bottom:4px; }
    .attr-val { font-size:.92rem; font-weight:600; color:var(--text); }
    .related-section { margin-top:60px; }
    .reviews-section { margin-top:60px; }
    .review-card { background:var(--white); border:1px solid var(--border); border-radius:var(--radius); padding:20px; margin-bottom:14px; }
    .review-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; }
    .review-author { font-weight:600; font-size:.9rem; }
    .review-date { font-size:.76rem; color:var(--muted); }
    .review-stars { color:#e9a825; font-size:1rem; margin-bottom:6px; }
    .review-title { font-weight:600; font-size:.92rem; margin-bottom:4px; }
    .review-body { font-size:.87rem; color:var(--muted); line-height:1.6; }
    .review-form { background:var(--green-xpale); border-radius:var(--radius); padding:24px; }
    .star-rating { display:flex; gap:6px; margin-bottom:14px; flex-direction:row-reverse; justify-content:flex-end; }
    .star-rating input { display:none; }
    .star-rating label { font-size:1.6rem; cursor:pointer; color:#ccc; transition:color .1s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:#e9a825; }
    @media(max-width:768px) { .product-layout { grid-template-columns:1fr; } }
</style>
@endpush
@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="{{ route('shop') }}">Shop</a><span>›</span>
    <a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a><span>›</span>
    {{ $product->name }}
</div>

<div class="product-detail">
    <div class="product-layout">
        <div class="product-image-wrap">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                 onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
        </div>

        <div class="product-info">
            <div class="product-meta">
                <a href="{{ route('shop.category', $product->category->slug) }}" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;color:var(--green-l);font-weight:600;">
                    {{ $product->category->name }}
                </a>
                @if($product->is_organic)<span class="organic-badge">🌱 Certified Organic</span>@endif
                @if($product->is_featured)<span style="background:#fef3c7;color:#92400e;font-size:.7rem;font-weight:600;padding:2px 8px;border-radius:50px;">⭐ Featured</span>@endif
            </div>

            <h1>{{ $product->name }}</h1>

            @php $avg = $product->avgRating(); $reviewCount = $product->reviews()->count(); @endphp
            @if($reviewCount > 0)
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
                <div class="review-stars">
                    @for($i=1;$i<=5;$i++){{ $i <= round($avg) ? '★' : '☆' }}@endfor
                </div>
                <span style="font-size:.84rem;color:var(--muted)">{{ $avg }} ({{ $reviewCount }} review{{ $reviewCount>1?'s':'' }})</span>
            </div>
            @endif

            <div class="product-price-big">PKR {{ number_format($product->price, 0) }}</div>
            @if($product->weight)<div class="product-weight">Package: {{ $product->weight }}</div>@endif

            <p class="product-description">{{ $product->description }}</p>

            @if($product->stock > 0)
                <span class="stock-badge in-stock">✓ In Stock ({{ $product->stock }} available)</span>
            @else
                <span class="stock-badge out-stock">Out of Stock</span>
            @endif

            <hr class="divider">

            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="add-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="qty-input">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;font-size:1rem;padding:13px 28px">
                    🛒 Add to Cart
                </button>
            </form>
            @endif

            @auth
            <form action="{{ route('wishlist.toggle') }}" method="POST" style="margin-bottom:20px">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                @php $inWishlist = auth()->user()->wishlists()->where('product_id',$product->id)->exists(); @endphp
                <button type="submit" class="btn btn-outline" style="width:100%;justify-content:center">
                    {{ $inWishlist ? '💚 In Wishlist — Remove' : '🤍 Add to Wishlist' }}
                </button>
            </form>
            @endauth

            <div class="product-attrs">
                <div class="attr-item"><div class="attr-label">Category</div><div class="attr-val">{{ $product->category->name }}</div></div>
                @if($product->weight)<div class="attr-item"><div class="attr-label">Weight</div><div class="attr-val">{{ $product->weight }}</div></div>@endif
                <div class="attr-item"><div class="attr-label">Organic</div><div class="attr-val">{{ $product->is_organic ? 'Yes, Certified' : 'No' }}</div></div>
                <div class="attr-item"><div class="attr-label">Availability</div><div class="attr-val">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</div></div>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews-section">
        <h2 class="section-title">Customer Reviews</h2>
        @if($product->reviews->isEmpty())
        <p style="color:var(--muted);margin-bottom:24px">No reviews yet. Be the first!</p>
        @else
        <div style="margin-bottom:28px">
            @foreach($product->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div>
                        <div class="review-author">{{ $review->user->name }}</div>
                        <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                    </div>
                    @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->is_admin))
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="font-size:.72rem;padding:3px 9px">Delete</button>
                    </form>
                    @endif
                </div>
                <div class="review-stars">
                    @for($i=1;$i<=5;$i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                </div>
                @if($review->title)<div class="review-title">{{ $review->title }}</div>@endif
                @if($review->body)<div class="review-body">{{ $review->body }}</div>@endif
                @if($review->photo)
                <div style="margin-top:10px">
                    <img src="{{ $review->photo }}" alt="Review photo" style="max-width:200px;max-height:200px;border-radius:8px;border:1px solid var(--border);object-fit:cover;cursor:pointer" onclick="window.open(this.src)">
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @auth
        <div class="review-form">
            <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:16px">Write a Review</h3>
            <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div style="margin-bottom:14px">
                    <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:6px">Rating *</label>
                    <div class="star-rating">
                        @for($i=5;$i>=1;$i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating')==$i?'checked':'' }}>
                        <label for="star{{ $i }}" title="{{ $i }} star{{ $i>1?'s':'' }}">★</label>
                        @endfor
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Review Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Summarize your experience" value="{{ old('title') }}">
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label">Your Review</label>
                    <textarea name="body" class="form-control" rows="3" placeholder="Share what you think about this product...">{{ old('body') }}</textarea>
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label">📷 Add a Photo (optional)</label>
                    <input type="file" name="review_photo" accept="image/*" class="form-control" style="padding:6px">
                    <div style="font-size:.76rem;color:var(--muted);margin-top:4px">JPG, PNG or WEBP — max 4MB</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
        @else
        <p style="color:var(--muted);font-size:.9rem">
            <a href="{{ route('login') }}" style="color:var(--green);font-weight:600">Sign in</a> to write a review.
        </p>
        @endauth
    </div>

    @if($related->isNotEmpty())
    <div class="related-section">
        <h2 class="section-title">You Might Also Like</h2>
        <div class="products-grid" style="margin-top:24px">
            @foreach($related as $rel)
            <div class="product-card">
                <a href="{{ route('product.show', $rel->slug) }}">
                    <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                </a>
                <div class="product-card-body">
                    <div class="product-card-cat">{{ $rel->category->name }}</div>
                    <a href="{{ route('product.show', $rel->slug) }}">
                        <div class="product-card-name">{{ $rel->name }}</div>
                    </a>
                    <div class="product-card-desc">{{ $rel->description }}</div>
                    <div class="product-card-footer">
                        <span class="product-price">PKR {{ number_format($rel->price, 0) }}</span>
                        @if($rel->is_organic)<span class="organic-badge">Organic</span>@endif
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" style="margin-top:12px">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $rel->id }}">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Add to Cart</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
