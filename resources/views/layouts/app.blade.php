<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Organic store') — Fresh &amp; Certified Organic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #2d6a4f;
            --green-l: #40916c;
            --green-pale: #d8f3dc;
            --green-xpale: #f0faf2;
            --amber: #e9a825;
            --amber-l: #fef3c7;
            --text: #1a2e1a;
            --muted: #5a7a5a;
            --border: #d1e8d1;
            --bg: #fafdf8;
            --white: #fff;
            --red: #c0392b;
            --radius: 12px;
            --shadow: 0 2px 16px rgba(45, 106, 79, .09);
            --shadow-md: 0 4px 24px rgba(45, 106, 79, .14);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        nav {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .04);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 68px;
        }

        /* .nav-logo { font-family:'Playfair Display',serif; font-size:1.45rem; font-weight:700; color:var(--green); display:flex; align-items:center; gap:8px; } */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-img {
            height: 50px;
            width: auto;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links a {
            font-size: .88rem;
            font-weight: 500;
            color: var(--muted);
            transition: color .2s;
        }

        .nav-links a:hover {
            color: var(--green);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            transition: all .2s;
            cursor: pointer;
            border: none;
        }

        .nav-btn-primary {
            background: var(--green);
            color: var(--white);
        }

        .nav-btn-primary:hover {
            background: var(--green-l);
        }

        .nav-btn-outline {
            background: transparent;
            color: var(--green);
            border: 1.5px solid var(--green);
        }

        .nav-btn-outline:hover {
            background: var(--green);
            color: var(--white);
        }

        .cart-count {
            background: var(--amber);
            color: var(--text);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            font-weight: 700;
        }

        .nav-dropdown {
            position: relative;
        }
.nav-dropdown{
    position:relative;
    display:inline-block;
}

/* USER BUTTON */
.user-profile-btn{
    display:flex;
    align-items:center;
    gap:10px;
    padding:7px 14px;
    border:1.5px solid var(--green);
    border-radius:50px;
    background:transparent;
    color:var(--green);
    font-size:.85rem;
    font-weight:600;
    transition:all .2s;
    cursor:pointer;
}

.user-profile-btn:hover{
    background:var(--green);
    color:var(--white);
}

.user-profile-img{
    width:32px;
    height:32px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid var(--green);
}

/* DROPDOWN MENU */
.nav-dropdown-menu{
    position:absolute;
    top:100%;
    right:0;
    margin-top:8px;
    background:var(--white);
    border:1px solid var(--border);
    border-radius:var(--radius);
    min-width:200px;
    box-shadow:var(--shadow-md);
    padding:8px 0;
    z-index:999;

    opacity:0;
    visibility:hidden;
    transform:translateY(10px);
    transition:all .25s ease;
}

/* SHOW MENU */
.nav-dropdown:hover .nav-dropdown-menu{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

/* MENU LINKS */
.nav-dropdown-menu a{
    display:block;
    padding:11px 18px;
    font-size:.88rem;
    color:var(--text);
    transition:all .2s;
}

.nav-dropdown-menu a:hover{
    background:var(--green-xpale);
    color:var(--green);
}

/* DIVIDER */
.nav-dropdown-menu .divider{
    border-top:1px solid var(--border);
    margin:6px 0;
}

/* LOGOUT BUTTON */
.logout-btn{
    width:100%;
    text-align:left;
    background:none;
    border:none;
    cursor:pointer;
    padding:11px 18px;
    font-size:.88rem;
    color:var(--red);
    transition:all .2s;
}

.logout-btn:hover{
    background:#fde8e8;
}
        
        main {
            min-height: calc(100vh - 68px - 240px);
        }

        .flash {
            max-width: 1200px;
            margin: 14px auto;
            padding: 0 24px;
        }

        .flash-msg {
            padding: 11px 18px;
            border-radius: var(--radius);
            font-size: .88rem;
            font-weight: 500;
        }

        .flash-success {
            background: var(--green-pale);
            color: var(--green);
            border: 1px solid #b7e4c7;
        }

        .flash-error {
            background: #fde8e8;
            color: var(--red);
            border: 1px solid #f5c6c6;
        }

        footer {
            background: var(--green);
            color: var(--white);
            margin-top: 80px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding: 56px 24px 40px;
        }

        .footer-logo {
            display: inline-flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .footer-logo-img {
            height: 80px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        .footer-brand p {
            font-size: .88rem;
            opacity: .8;
            line-height: 1.7;
        }

        .footer-col h4 {
            font-size: .78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .6;
            margin-bottom: 14px;
        }

        .footer-col a {
            display: block;
            font-size: .86rem;
            opacity: .8;
            margin-bottom: 9px;
            transition: opacity .2s;
        }

        .footer-col a:hover {
            opacity: 1;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .15);
            max-width: 1200px;
            margin: 0 auto;
            padding: 18px 24px;
            font-size: .8rem;
            opacity: .6;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 50px;
            font-size: .88rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--green);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--green-l);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--green);
            border: 2px solid var(--green);
        }

        .btn-outline:hover {
            background: var(--green);
            color: var(--white);
        }

        .btn-amber {
            background: var(--amber);
            color: var(--text);
        }

        .btn-amber:hover {
            background: #d4941e;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: .8rem;
        }

        .btn-danger {
            background: var(--red);
            color: var(--white);
        }

        .btn-danger:hover {
            background: #a93226;
        }

        .btn-gray {
            background: #f0f0f0;
            color: var(--text);
        }

        .btn-gray:hover {
            background: #e0e0e0;
        }

        .product-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .product-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .product-card-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card-cat {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--green-l);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-card-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-card-desc {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.5;
            flex: 1;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--green);
        }

        .organic-badge {
            background: var(--green-pale);
            color: var(--green);
            font-size: .68rem;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 50px;
        }

        .star {
            color: #e9a825;
            font-size: .85rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 22px;
        }

        .section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 56px 24px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .section-sub {
            color: var(--muted);
            font-size: .92rem;
            margin-bottom: 36px;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 24px;
            font-size: .82rem;
            color: var(--muted);
        }

        .breadcrumb a {
            color: var(--green);
        }

        .breadcrumb span {
            margin: 0 5px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 9px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .88rem;
            font-family: inherit;
            background: var(--bg);
            transition: border-color .2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green-l);
            background: white;
        }

        .error-text {
            color: var(--red);
            font-size: .76rem;
            margin-top: 3px;
        }

        .admin-bar {
            background: #1a2e1a;
            color: rgba(255, 255, 255, .8);
            font-size: .78rem;
            padding: 6px 24px;
            display: flex;
            justify-content: center;
            gap: 24px;
        }

        .admin-bar a {
            color: var(--amber);
            font-weight: 600;
        }

        .admin-bar a:hover {
            color: white;
        }
        /* Main Footer Background */
footer {
    background: #2f6f4f;
    color: #f5f5f5;
}

/* Footer Headings */
.footer-col h4 {
    color: #d7e8dc;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 20px;
}

/* Footer Links */
.footer-col a {
    color: #e6efe9;
    text-decoration: none;
    display: block;
    margin-bottom: 12px;
    transition: 0.3s ease;
}

.footer-col a:hover {
    color: #b7ff65;
    padding-left: 5px;
}

/* Contact Text */
.footer-col p {
    color: #e6efe9;
    margin: 12px 0;
    font-size: 15px;
}

/* Contact Icons */
.footer-col p i {
    margin-right: 10px;
    color: #7cff5b;
}

/* Social Icons Container */
.social-icons {
    display: flex;
    gap: 14px;
    margin-top: 20px;
}

/* Social Icons */
.social-icons a {
    width: 42px;
    height: 42px;
    background: #1f3f31;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    text-decoration: none;
    font-size: 18px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Hover Effect */
.social-icons a:hover {
    background: #9be33f;
    color: #1f3f31;
    transform: translateY(-4px);
}

/* Footer Bottom Line */
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.15);
    margin-top: 40px;
    padding-top: 20px;
    color: #dfeee5;
}
        @media(max-width:768px) {
            .nav-links {
                display: none;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    @auth @if (auth()->user()->is_admin)
        <div class="admin-bar">
            <span>Admin Mode</span>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}">Products</a>
            <a href="{{ route('admin.categories.index') }}">Categories</a>
            <a href="{{ route('admin.orders.index') }}">Orders</a>
            <a href="{{ route('admin.coupons.index') }}">Coupons</a>
        </div>
    @endif @endauth

    <nav>
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-logo">
                <img src="{{ asset('images/logo.avif') }}" alt="Organic Store Logo" class="logo-img">
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('shop') }}">Shop</a>
                @foreach (\App\Models\Category::take(8)->get() as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="nav-actions">
                @php $cartCount = \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity'); @endphp
                @auth
                    <div class="nav-dropdown">
                        <a class="user-profile-btn">
                            <img src="{{ asset('images/user.jfif') }}" alt="User" class="user-profile-img">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="nav-dropdown-menu">
                            <a href="{{ route('orders.index') }}">My Orders</a>
                            <a href="{{ route('wishlist.index') }}">Wishlist</a>
                            <a href="{{ route('profile.edit') }}">Profile</a>
                            @if (Auth::user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            @endif
                            <div class="divider"></div>
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"
                                    style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:10px 18px;font-size:.88rem;color:var(--red);">Sign
                                    Out</button></form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-outline">Log In</a>
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Register</a>
                @endauth
                @auth
                    <a href="{{ route('cart.index') }}" class="nav-btn nav-btn-primary">
                        🛒
                        @if ($cartCount > 0)
                            <span class="cart-count">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="flash">
        @if (session('success'))
            <div class="flash-msg flash-success">✓ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash-msg flash-error">⚠ {{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="flash-msg flash-error">{{ $errors->first() }}</div>
        @endif
    </div>

    <main>@yield('content')</main>

    <footer>
        <div class="footer-inner">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo">
                    <img src="{{ asset('images/logo.avif') }}" alt="Organic Store Logo" class="footer-logo-img">
                </a>

                <p>
                    Premium organic products sourced directly from certified farms.
                    Pure, natural, and delivered fresh to your door since 2026.
                </p>
            </div>
            <div class="footer-col">
                <h4>Shop</h4>
                <a href="{{ route('shop') }}">All Products</a>
                @foreach (\App\Models\Category::take(4)->get() as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </div>
            <div class="footer-col">
                <h4>Account</h4>
                @auth
                    <a href="{{ route('orders.index') }}">My Orders</a>
                    <a href="{{ route('wishlist.index') }}">Wishlist</a>
                    <a href="{{ route('profile.edit') }}">Profile</a>
                @else
                    <a href="{{ route('login') }}">Sign In</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
            <div class="footer-col">
    <h4>Contact Info</h4>

    <p>
        <i class="fas fa-map-marker-alt"></i>
        Bahawalnagar,Punjab Pakistan
    </p>

    <p>
        <i class="fas fa-phone"></i>
        +92 303 2144809
    </p>

    <p>
        <i class="fas fa-envelope"></i>
        info@organicstore.com
    </p>

    <div class="social-icons">
        <a href="#" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>

        <a href="#" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>

        <a href="#" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>

        <a href="#" target="_blank">
            <i class="fab fa-youtube"></i>
        </a>

        <a href="#" target="_blank">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Organic_Store. All rights reserved.</span>
            <span> Certified Organic | 🚚 Free shipping over PKR 5,000</span>
        </div>
    </footer>

    {{-- WhatsApp Floating Button --}}
    <a href="https://wa.me/923032144809?text=Hi%2C%20I%20need%20help%20with%20my%20order"
       target="_blank" rel="noopener"
       style="position:fixed;bottom:28px;right:28px;z-index:9999;background:#25D366;color:white;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 20px rgba(37,211,102,.45);transition:transform .2s,box-shadow .2s;text-decoration:none"
       title="Chat on WhatsApp"
       onmouseover="this.style.transform='scale(1.12)';this.style.boxShadow='0 6px 28px rgba(37,211,102,.6)'"
       onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(37,211,102,.45)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    @stack('scripts')
</body>

</html>
