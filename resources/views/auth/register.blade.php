<x-guest-layout>

    <style>
        .register-header{
            text-align:center;
            margin-bottom:28px;
        }

        .register-logo{
            margin-bottom:12px;
        }

        .register-logo img{
            height:70px;
            width:auto;
            object-fit:contain;
        }

        .register-title{
            font-family:'Playfair Display',serif;
            font-size:1.5rem;
            color:var(--green);
            margin-bottom:4px;
            font-weight:700;
        }

        .register-subtitle{
            font-size:.85rem;
            color:var(--muted);
            line-height:1.6;
        }
    </style>

    <div class="register-header">

        <div class="register-logo">
    <img src="{{ asset('images/logo.avif') }}" alt="Organic Store Logo">
        </div>

        <h1 class="register-title">
            Create Account
        </h1>

        <p class="register-subtitle">
            Join Organic Store for Fresh, Certified Organic Products
        </p>

    </div>

    @if($errors->any())
        <div class="flash-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">
                Full Name
            </label>

            <input
                id="name"
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="email">
                Email Address
            </label>

            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autocomplete="username"
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="password">
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                required
                autocomplete="new-password"
            >
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">
                Confirm Password
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn-submit">
            Create Account
        </button>

    </form>

    <div class="auth-footer">
        Already have an account?
        <a href="{{ route('login') }}">
            Sign in
        </a>
    </div>

</x-guest-layout>

