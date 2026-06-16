<x-guest-layout>

    <style>
        .reset-wrapper {
            text-align: center;
            margin-bottom: 24px;
        }
        .reset-logo{
    margin-bottom:12px;
}

.reset-logo img{
    height:70px;
    width:auto;
    object-fit:contain;
}

        .reset-icon {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .reset-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--green);
            margin-bottom: 8px;
        }

        .reset-text {
            font-size: .84rem;
            color: var(--muted);
        }

        .flash-success {
            background: #e6ffed;
            color: #1a7f37;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            font-size: .85rem;
        }

        .flash-error {
            background: #ffe6e6;
            color: #a30000;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            font-size: .85rem;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: .85rem;
            margin-bottom: 6px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: .9rem;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background: var(--green);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: .9rem;
            transition: 0.3s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .auth-footer {
            margin-top: 15px;
            font-size: .85rem;
        }

        .auth-footer a {
            color: var(--green);
            text-decoration: none;
        }
    </style>

    <div class="reset-wrapper">
        <div class="reset-logo">
    <img src="{{ asset('images/logo.avif') }}" alt="Organic Store Logo">
</div>
        <h1 class="reset-title">Forgot Password?</h1>
        <p class="reset-text">Enter your email and we'll send you a reset link.</p>
    </div>

    @if(session('status'))
        <div class="flash-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="flash-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input id="email" type="email" name="email"
                class="form-control"
                value="{{ old('email') }}"
                required autofocus>
        </div>

        <button type="submit" class="btn-submit">
            Send Reset Link
        </button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">← Back to Log In</a>
    </div>

</x-guest-layout>