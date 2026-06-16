<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

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
    <img src="<?php echo e(asset('images/logo.avif')); ?>" alt="Organic Store Logo">
</div>

        <h1 class="login-title">
            Welcome Back
        </h1>

        <p class="login-subtitle">
            Log in to your Organic Store Account
        </p>
    </div>

    <?php if(session('status')): ?>
        <div class="flash-success">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="flash-error">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label class="form-label" for="email">
                Email Address
            </label>

            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="<?php echo e(old('email')); ?>"
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

            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">
                    Forgot password?
                </a>
            <?php endif; ?>

        </div>

        <button type="submit" class="btn-submit">
            Log In
        </button>
    </form>

    <div class="auth-footer">
        Don't have an account?
        <a href="<?php echo e(route('register')); ?>">
            Register now
        </a>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>

<?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/auth/login.blade.php ENDPATH**/ ?>