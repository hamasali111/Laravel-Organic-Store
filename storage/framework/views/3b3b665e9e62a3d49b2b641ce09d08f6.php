<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> — Organic_store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        :root {
            --green: #2d6a4f;
            --green-l: #40916c;
            --green-pale: #d8f3dc;
            --green-xpale: #f0faf2;
            --amber: #e9a825;
            --text: #1a2e1a;
            --muted: #5a7a5a;
            --border: #d1e8d1;
            --bg: #f5f8f5;
            --white: #fff;
            --red: #c0392b;
            --radius: 12px;
            --shadow: 0 2px 16px rgba(45, 106, 79, .09);
            --shadow-md: 0 4px 24px rgba(45, 106, 79, .14);
            --sidebar: 240px
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh
        }

        a {
            color: inherit;
            text-decoration: none
        }

        .sidebar {
            width: var(--sidebar);
            background: #1a2e1a;
            color: rgba(255, 255, 255, .85);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 100
        }

        .sidebar-logo {
            padding: 24px 20px;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            display: flex;
            align-items: center;
            gap: 8px
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto
        }

        .sidebar-section {
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .1em;
            opacity: .45;
            padding: 12px 20px 6px
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            font-size: .88rem;
            transition: all .15s;
            border-left: 3px solid transparent
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, .08);
            color: white;
            border-left-color: var(--amber)
        }

        .sidebar-link span {
            font-size: 1rem
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, .1);
            font-size: .8rem
        }

        .sidebar-footer a {
            color: rgba(255, 255, 255, .7);
            display: block;
            margin-bottom: 6px
        }

        .sidebar-footer a:hover {
            color: white
        }

        .main-content {
            margin-left: var(--sidebar);
            flex: 1;
            display: flex;
            flex-direction: column
        }

        .top-bar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50
        }

        .top-bar-title {
            font-size: .9rem;
            font-weight: 600;
            color: var(--muted)
        }

        .content-area {
            padding: 28px;
            flex: 1
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 50px;
            font-size: .84rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none
        }

        .btn-primary {
            background: var(--green);
            color: var(--white)
        }

        .btn-primary:hover {
            background: var(--green-l)
        }

        .btn-outline {
            background: transparent;
            color: var(--green);
            border: 1.5px solid var(--green)
        }

        .btn-outline:hover {
            background: var(--green);
            color: var(--white)
        }

        .btn-danger {
            background: var(--red);
            color: var(--white)
        }

        .btn-danger:hover {
            background: #a93226
        }

        .btn-gray {
            background: var(--border);
            color: var(--text)
        }

        .btn-gray:hover {
            background: #c1d8c1
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: .78rem
        }

        .btn-amber {
            background: var(--amber);
            color: var(--text)
        }

        .admin-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px
        }

        .data-table {
            width: 100%;
            border-collapse: collapse
        }

        .data-table th {
            text-align: left;
            font-size: .74rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            padding: 10px 0;
            border-bottom: 2px solid var(--border)
        }

        .data-table td {
            padding: 13px 0;
            border-bottom: 1px solid var(--border);
            font-size: .88rem;
            vertical-align: middle
        }

        .data-table tr:hover td {
            background: var(--green-xpale)
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .74rem;
            font-weight: 600
        }

        .form-group {
            margin-bottom: 16px
        }

        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            margin-bottom: 5px
        }

        .form-control {
            width: 100%;
            padding: 9px 13px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .88rem;
            font-family: inherit;
            background: var(--bg)
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green-l);
            background: white
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .flash {
            margin-bottom: 20px
        }

        .flash-msg {
            padding: 10px 16px;
            border-radius: var(--radius);
            font-size: .86rem;
            font-weight: 500
        }

        .flash-success {
            background: var(--green-pale);
            color: var(--green);
            border: 1px solid #b7e4c7
        }

        .flash-error {
            background: #fde8e8;
            color: var(--red);
            border: 1px solid #f5c6c6
        }

        @media(max-width:768px) {
            .sidebar {
                transform: translateX(-100%)
            }

            .main-content {
                margin-left: 0
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo"> Admin Panel</div>
        <nav class="sidebar-nav">
            <div class="sidebar-section">Overview</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"><span>📊</span>
                Dashboard</a>
            <div class="sidebar-section">Catalog</div>
            <a href="<?php echo e(route('admin.products.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.products*') ? 'active' : ''); ?>"><span>🥦</span>
                Products</a>
            <a href="<?php echo e(route('admin.categories.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.categories*') ? 'active' : ''); ?>"><span>📂</span>
                Categories</a>
            <div class="sidebar-section">Sales</div>
            <a href="<?php echo e(route('admin.orders.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.orders*') ? 'active' : ''); ?>"><span>📦</span>
                Orders</a>
            <a href="<?php echo e(route('admin.coupons.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.coupons*') ? 'active' : ''); ?>"><span>🎟</span>
                Coupons</a>
            <a href="<?php echo e(route('admin.reports.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>"><span>📈</span>
                Reports</a>
            <a href="<?php echo e(route('admin.returns.index')); ?>"
                class="sidebar-link <?php echo e(request()->routeIs('admin.returns*') ? 'active' : ''); ?>"><span>↩</span>
                Returns</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?php echo e(route('home')); ?>">← View Store</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit"
                    style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.6);font-size:.8rem;padding:0">Sign
                    Out</button></form>
        </div>
    </aside>
    <div class="main-content">
        <div class="top-bar">
            <div class="top-bar-title"> Organic Store Admin</div>
            <div style="font-size:.84rem;color:var(--muted)"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
        </div>
        <div class="content-area">
            <?php if(session('success')): ?>
                <div class="flash">
                    <div class="flash-msg flash-success">✅ <?php echo e(session('success')); ?></div>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="flash">
                    <div class="flash-msg flash-error">❌ <?php echo e(session('error')); ?></div>
                </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/layouts/admin.blade.php ENDPATH**/ ?>