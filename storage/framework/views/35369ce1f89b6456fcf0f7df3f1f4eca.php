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
    <img src="<?php echo e(asset('images/logo.avif')); ?>" alt="Organic Store Logo">
        </div>

        <h1 class="register-title">
            Create Account
        </h1>

        <p class="register-subtitle">
            Join Organic Store for Fresh, Certified Organic Products
        </p>

    </div>

    <?php if($errors->any()): ?>
        <div class="flash-error">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label class="form-label" for="name">
                Full Name
            </label>

            <input
                id="name"
                type="text"
                name="name"
                class="form-control"
                value="<?php echo e(old('name')); ?>"
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
                value="<?php echo e(old('email')); ?>"
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
        <a href="<?php echo e(route('login')); ?>">
            Sign in
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

<?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/auth/register.blade.php ENDPATH**/ ?>