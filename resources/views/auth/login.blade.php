<x-guest-layout>

    <style>
        .login-header{
            text-align:center;
            margin-bottom:28px;
        }

        .login-logo{
    margin-bottom:12px;
}

.login-logo img{
    height:70px;
    width:auto;
    object-fit:contain;
}

        .login-title{
            font-family:'Playfair Display',serif;
            font-size:1.5rem;
            color:var(--green);
            margin-bottom:4px;
        }

        .login-subtitle{
            font-size:.85rem;
            color:var(--muted);
        }

        .login-options{
            display:flex;
            align-items:center;
            justify-content:space-between;
            font-size:.83rem;
            margin:4px 0 8px;
        }

        .remember-label{
            display:flex;
            align-items:center;
            gap:6px;
            cursor:pointer;
            color:var(--muted);
        }

        .forgot-link{
            color:var(--green);
        }

        .forgot-link:hover{
            text-decoration:underline;
        }

        .logout-btn{
            width:100%;
            text-align:left;
            background:none;
            border:none;
            cursor:pointer;
            padding:10px 18px;
            font-size:.88rem;
            color:var(--red);
        }
    </style>

    <div class="login-header">
        <div class="login-logo">
    <img src="{{ asset('images/logo.avif') }}" alt="Organic Store Logo">
</div>

        <h1 class="login-title">
            Welcome Back
        </h1>

        <p class="login-subtitle">
            Log in to your Organic Store Account
        </p>
    </div>

    @if(session('status'))
        <div class="flash-success">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="flash-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
                autofocus
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
                autocomplete="current-password"
            >
        </div>

        <div class="login-options">

            <label class="remember-label">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Forgot password?
                </a>
            @endif

        </div>

        <button type="submit" class="btn-submit">
            Log In
        </button>
    </form>

    <div class="auth-footer">
        Don't have an account?
        <a href="{{ route('register') }}">
            Register now
        </a>
    </div>

</x-guest-layout>

