<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Organic_store')); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --green:#2d6a4f; --green-l:#40916c; --green-pale:#d8f3dc; --green-xpale:#f0faf2;
            --text:#1a2e1a; --muted:#5a7a5a; --border:#d1e8d1; --bg:#f0faf2;
            --white:#fff; --red:#c0392b; --radius:12px;
        }
        body { font-family:'Inter',sans-serif; background:var(--bg); min-height:100vh; display:flex; flex-direction:column; }
        a { color:inherit; text-decoration:none; }
        .auth-nav { background:var(--white); border-bottom:1px solid var(--border); padding:0 24px; height:60px; display:flex; align-items:center; }
        .auth-nav-logo { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:var(--green); }
        .nav-logo{
    display:flex;
    align-items:center;
    gap:10px;
}

.logo-img{
    height:50px;
    width:auto;
}
        .auth-wrap { flex:1; display:flex; align-items:center; justify-content:center; padding:40px 24px; }
        .auth-card { background:var(--white); border:1px solid var(--border); border-radius:20px; padding:44px 40px; width:100%; max-width:440px; box-shadow:0 4px 32px rgba(45,106,79,.10); }
        .form-group { margin-bottom:16px; }
        .form-label { display:block; font-size:.82rem; font-weight:600; margin-bottom:5px; color:var(--text); }
        .form-control { width:100%; padding:10px 14px; border:1.5px solid var(--border); border-radius:10px; font-size:.9rem; font-family:inherit; background:var(--bg); transition:border-color .2s; }
        .form-control:focus { outline:none; border-color:var(--green-l); background:white; }
        .error-text { color:var(--red); font-size:.76rem; margin-top:3px; }
        .btn-submit { display:block; width:100%; padding:12px; background:var(--green); color:white; border:none; border-radius:50px; font-size:.95rem; font-weight:600; cursor:pointer; font-family:inherit; transition:background .2s; text-align:center; margin-top:20px; }
        .btn-submit:hover { background:var(--green-l); }
        .auth-footer { text-align:center; margin-top:18px; font-size:.85rem; color:var(--muted); }
        .auth-footer a { color:var(--green); font-weight:600; }
        .auth-footer a:hover { text-decoration:underline; }
        .flash-error { background:#fde8e8; color:var(--red); border:1px solid #f5c6c6; padding:10px 14px; border-radius:10px; font-size:.85rem; margin-bottom:16px; }
        .flash-success { background:var(--green-pale); color:var(--green); border:1px solid #b7e4c7; padding:10px 14px; border-radius:10px; font-size:.85rem; margin-bottom:16px; }
        @media(max-width:480px) { .auth-card { padding:28px 20px; } }
    </style>
</head>
<body>
<nav class="auth-nav">
    <a href="<?php echo e(route('home')); ?>" class="nav-logo">
    <img src="<?php echo e(asset('images/logo.avif')); ?>" alt="Organic Store Logo" class="logo-img">
</a>
</nav>
<div class="auth-wrap">
    <div class="auth-card">
        <?php echo e($slot); ?>

    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/layouts/guest.blade.php ENDPATH**/ ?>