@extends('layouts.app')

@section('title', 'Organic_store — Pure. Natural. Nourishing.')

@push('styles')
    <style>
        .hero {
            background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 50%, #40916c 100%);
            color: white;
            padding: 100px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1542838132-92c53300491e?w=1600&q=60') center/cover;
            opacity: .18;
        }

        .hero-inner {
            max-width: 720px;
            margin: 0 auto;
            position: relative;
        }

        .hero-badge {
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(4px);
            display: inline-block;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 24px;
            border: 1px solid rgba(255, 255, 255, .25);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: .88;
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 14px 36px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
            display: inline-block;
        }

        .hero-btn-primary {
            background: white;
            color: #2d6a4f;
        }

        .hero-btn-primary:hover {
            background: #d8f3dc;
            transform: translateY(-2px);
        }

        .hero-btn-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, .6);
        }

        .hero-btn-outline:hover {
            background: rgba(255, 255, 255, .1);
            border-color: white;
        }

        .trust-bar {
            background: var(--green-xpale);
            border-bottom: 1px solid var(--border);
        }

        .trust-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            gap: 48px;
            padding: 20px 24px;
            flex-wrap: wrap;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .88rem;
            font-weight: 500;
            color: var(--green);
        }

        .trust-item span {
            font-size: 1.3rem;
        }

        .cats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
        }

        .cat-card {
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            aspect-ratio: 1;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .cat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .cat-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .3s;
        }

        .cat-card:hover img {
            transform: scale(1.06);
        }

        .cat-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .6) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 16px;
        }

        .cat-card-overlay h3 {
            color: white;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
        }

        .cat-card-overlay span {
            color: rgba(255, 255, 255, .75);
            font-size: .78rem;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px;
        }

        .why-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            text-align: center;
        }

        .why-icon {
            font-size: 2.4rem;
            margin-bottom: 16px;
        }

        .why-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .why-card p {
            font-size: .87rem;
            color: var(--muted);
            line-height: 1.6;
        }

        .cta-section {
            background: var(--green-pale);
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            margin: 0 24px;
        }

        .cta-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 12px;
            color: var(--green);
        }

        .cta-section p {
            color: var(--muted);
            margin-bottom: 28px;
        }
    </style>
@endpush

@section('content')

    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">100% Certified Organic</div>
            <h1>Nature's Finest, Delivered Fresh to You</h1>
            <p>Bring home high-quality Organic Foods, Fresh Farm Produce, and wellness essentials sourced responsibly from Certified Organic Farms.</p>
            <div class="hero-actions">
                <a href="{{ route('shop') }}" class="hero-btn hero-btn-primary">Shop Now</a>
                <a href="#categories" class="hero-btn hero-btn-outline">Browse Categories</a>
            </div>
        </div>
    </section>

    <div class="trust-bar">
        <div class="trust-inner">
            <div class="trust-item"><span>🌱</span> Certified Organic</div>
            <div class="trust-item"><span>🚚</span> Free Shipping over PKR 5,000</div>
            <div class="trust-item"><span>🔄</span> Easy Returns</div>
            <div class="trust-item"><span>⚡</span> Fast Delivery</div>
        </div>
    </div>

    <section class="section" id="categories">
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-sub">From the Farm to your Table — explore our Organic Selection</p>
        <div class="cats-grid">
            @foreach ($categories as $cat)
                <a href="{{ route('shop.category', $cat->slug) }}" class="cat-card">
                    <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                    <div class="cat-card-overlay">
                        <h3>{{ $cat->name }}</h3>
                        <span>{{ $cat->products_count }} products</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <h2 class="section-title">Featured Products</h2>
        <p class="section-sub">Our most loved organic picks this season</p>
        <div class="products-grid">
            @foreach ($featured as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', $product->slug) }}">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                             onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                    </a>
                    <div class="product-card-body">
                        <div class="product-card-cat">{{ $product->category->name }}</div>
                        <a href="{{ route('product.show', $product->slug) }}">
                            <div class="product-card-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-card-desc">{{ $product->description }}</div>
                        <div class="product-card-footer">
                            <span class="product-price">PKR {{ number_format($product->price, 0) }}</span>
                            @if ($product->is_organic)
                                <span class="organic-badge">Organic</span>
                            @endif
                        </div>
                        @auth
    <form action="{{ route('cart.add') }}" method="POST" style="margin-top:12px">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
            Add to Cart
        </button>
    </form>
@endauth

@guest
    <a href="{{ route('login') }}"
       class="btn btn-outline"
       style="width:100%;justify-content:center;margin-top:12px">
        Login to Add Cart
    </a>
@endguest
                    </div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px">
            <a href="{{ route('shop') }}" class="btn btn-outline">View All Products</a>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">🌱</div>
                <h3>100% Organic</h3>
                <p>Every product is certified Organic by accredited bodies. No pesticides, no GMOs, no compromises.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">👩‍🌾</div>
                <h3>Farmer Direct</h3>
                <p>We partner directly with local and regional farms, cutting out the middleman for fresher produce and fair
                    farmer pay.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">📦</div>
                <h3>Eco Packaging</h3>
                <p>Our packaging is 100% compostable and plastic-free. Good for your food, good for the planet.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">⭐</div>
                <h3>Quality Guarantee</h3>
                <p>Not happy with your order? We'll replace it or give you a full refund — no questions asked.</p>
            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    <section class="section" style="padding-top:0">
        <div style="max-width:700px;margin:0 auto;text-align:center;background:linear-gradient(135deg,#1b4332,#2d6a4f);border-radius:20px;padding:60px 40px;color:white;position:relative;overflow:hidden">
            <div style="position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=1400&q=40') center/cover;opacity:.1;"></div>
            <div style="position:relative">
                <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.15em;opacity:.7;margin-bottom:12px">Stay Connected</div>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;margin-bottom:12px;line-height:1.3">Get Weekly Organic Tips & Exclusive Offers</h2>
                <p style="opacity:.82;margin-bottom:30px;font-size:.95rem;line-height:1.7">Join 12,000+ members getting fresh recipes, seasonal picks, and members-only discounts delivered to your inbox.</p>
                @if(session('newsletter_success'))
                    <div style="background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:12px;padding:16px;font-weight:600;font-size:1rem">
                        {{ session('newsletter_success') }}
                    </div>
                @else
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
                        @csrf
                        <input type="text" name="name" placeholder="Your name" style="padding:12px 18px;border-radius:50px;border:none;font-size:.9rem;min-width:150px;outline:none">
                        <input type="email" name="email" placeholder="Your email address" required style="padding:12px 18px;border-radius:50px;border:none;font-size:.9rem;min-width:220px;outline:none">
                        <button type="submit" style="background:white;color:#2d6a4f;padding:12px 28px;border-radius:50px;border:none;font-weight:700;font-size:.9rem;cursor:pointer;transition:all .2s">
                            Subscribe Free
                        </button>
                    </form>
                    <div style="font-size:.75rem;opacity:.6;margin-top:14px">No spam, ever. Unsubscribe anytime.</div>
                @endif
            </div>
        </div>
    </section>

    <div style="max-width:1200px;margin:0 auto;padding:0 24px 80px">
        <div class="cta-section">
            <h2>Ready to Eat Organic and Fresh Food?</h2>
            <p>Join over 12,000 happy customers who've made the switch to Organic living.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary btn-lg" style="font-size:1rem;padding:14px 36px">Start Shopping</a>
        </div>
    </div>

@endsection
