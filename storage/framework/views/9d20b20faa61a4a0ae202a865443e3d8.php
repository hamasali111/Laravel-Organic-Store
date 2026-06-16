<?php $__env->startSection('title', isset($category) ? $category->name . ' — Organic Store' : 'Shop All Organic Products — Organic Store'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .shop-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 40px;
        }

        .sidebar-section {
            margin-bottom: 28px;
        }

        .sidebar-section h4 {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .cat-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: .9rem;
            color: var(--text);
            transition: background .15s;
            margin-bottom: 2px;
        }

        .cat-link:hover,
        .cat-link.active {
            background: var(--green-pale);
            color: var(--green);
        }

        .cat-link span {
            font-size: .78rem;
            background: var(--border);
            border-radius: 50px;
            padding: 1px 8px;
        }

        .price-range-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .price-input {
            width: 90px;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: .85rem;
            background: var(--bg);
        }

        .shop-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .shop-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .shop-controls {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-form {
            display: flex;
            gap: 8px;
        }

        .search-input {
            padding: 8px 16px;
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .88rem;
            outline: none;
            background: var(--bg);
        }

        .sort-select {
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: .88rem;
            background: var(--bg);
            cursor: pointer;
        }

        .no-products {
            text-align: center;
            padding: 60px;
            color: var(--muted);
        }

        .no-products span {
            font-size: 3rem;
            display: block;
            margin-bottom: 16px;
        }

        .stock-label {
            display: inline-block;
            font-size: .72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 50px;
            margin-bottom: 4px;
        }

        .stock-in  { background: #d8f3dc; color: #2d6a4f; }
        .stock-low { background: #fef3c7; color: #92400e; }
        .stock-out { background: #fde8e8; color: #c0392b; }

        .badge-new {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #2d6a4f;
            color: white;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            letter-spacing: .05em;
            text-transform: uppercase;
            z-index: 2;
        }

        .badge-featured {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e9a825;
            color: white;
            font-size: .68rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 50px;
            z-index: 2;
        }

        .product-card { position: relative; }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--green-pale);
            color: var(--green);
            font-size: .78rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            min-width: 40px;
            border-radius: 12px;
            border: 1px solid #d8f3dc;
            background: #ffffff;
            color: #2d6a4f;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
        }

        .pagination .page-link:hover {
            background: #2d6a4f;
            border-color: #2d6a4f;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .pagination .page-item.active .page-link {
            background: #2d6a4f;
            border-color: #2d6a4f;
            color: #ffffff;
            font-weight: 600;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media(max-width: 768px) {
            .shop-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <span>›</span>
        <a href="<?php echo e(route('shop')); ?>">Shop</a>
        <?php if(isset($category)): ?>
            <span>›</span> <?php echo e($category->name); ?>

        <?php endif; ?>
    </div>

    <div class="shop-layout">
        <aside class="sidebar">

            <form action="<?php echo e(isset($category) ? route('shop.category', $category->slug) : route('shop')); ?>" method="GET" id="filter-form">
                <?php if(request('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>
                <?php if(request('sort')): ?>
                    <input type="hidden" name="sort" value="<?php echo e(request('sort')); ?>">
                <?php endif; ?>

                <div class="sidebar-section">
                    <h4>Categories</h4>
                    <a href="<?php echo e(route('shop')); ?>" class="cat-link <?php echo e(!isset($category) ? 'active' : ''); ?>">
                        All Products
                    </a>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('shop.category', $cat->slug)); ?>"
                            class="cat-link <?php echo e(isset($category) && $category->id === $cat->id ? 'active' : ''); ?>">
                            <?php echo e($cat->name); ?>

                            <span><?php echo e($cat->products_count); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="sidebar-section">
                    <h4>Price Range (PKR)</h4>
                    <div class="price-range-row">
                        <input type="number" name="min_price" class="price-input" placeholder="Min"
                            value="<?php echo e(request('min_price')); ?>" min="0">
                        <span style="color:var(--muted);font-size:.8rem">–</span>
                        <input type="number" name="max_price" class="price-input" placeholder="Max"
                            value="<?php echo e(request('max_price')); ?>" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-top:10px;width:100%;justify-content:center">
                        Apply Filter
                    </button>
                </div>

                <div class="sidebar-section">
                    <h4>Filter By</h4>
                    <div style="display:flex;flex-direction:column;gap:8px;font-size:.88rem;color:var(--muted);">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="organic" value="1" <?php echo e(request('organic') == '1' ? 'checked' : ''); ?>

                                onchange="document.getElementById('filter-form').submit()">
                            🌱 Certified Organic
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="featured" value="1" <?php echo e(request('featured') == '1' ? 'checked' : ''); ?>

                                onchange="document.getElementById('filter-form').submit()">
                            ⭐ Featured
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                            <input type="checkbox" name="in_stock" value="1" <?php echo e(request('in_stock') == '1' ? 'checked' : ''); ?>

                                onchange="document.getElementById('filter-form').submit()">
                            ✅ In Stock Only
                        </label>
                    </div>
                </div>

                <?php if(request()->hasAny(['min_price','max_price','organic','featured','in_stock'])): ?>
                    <a href="<?php echo e(isset($category) ? route('shop.category', $category->slug) : route('shop')); ?>"
                        class="btn btn-sm btn-gray" style="width:100%;justify-content:center;margin-top:4px">
                        ✕ Clear Filters
                    </a>
                <?php endif; ?>
            </form>

        </aside>

        <div>
            <div class="shop-header">
                <h1><?php echo e(isset($category) ? $category->name : 'All Organic Products'); ?></h1>
                <div class="shop-controls">
                    <form action="<?php echo e(isset($category) ? route('shop.category', $category->slug) : route('shop')); ?>"
                        method="GET" class="search-form">
                        <?php if(request('min_price')): ?> <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>"> <?php endif; ?>
                        <?php if(request('max_price')): ?> <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>"> <?php endif; ?>
                        <input type="text" name="search" class="search-input" placeholder="Search products..."
                            value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    </form>
                    <form action="<?php echo e(isset($category) ? route('shop.category', $category->slug) : route('shop')); ?>"
                        method="GET">
                        <?php if(request('search')): ?>
                            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                        <?php endif; ?>
                        <?php if(request('min_price')): ?> <input type="hidden" name="min_price" value="<?php echo e(request('min_price')); ?>"> <?php endif; ?>
                        <?php if(request('max_price')): ?> <input type="hidden" name="max_price" value="<?php echo e(request('max_price')); ?>"> <?php endif; ?>
                        <select name="sort" class="sort-select" onchange="this.form.submit()">
                            <option value="">Sort by</option>
                            <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                            <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                            <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                            <option value="rating" <?php echo e(request('sort') == 'rating' ? 'selected' : ''); ?>>Top Rated</option>
                        </select>
                    </form>
                </div>
            </div>

            <?php if(request()->hasAny(['min_price','max_price','organic','featured','in_stock','search'])): ?>
                <div style="margin-bottom:16px">
                    <?php if(request('search')): ?>
                        <span class="filter-chip">Search: "<?php echo e(request('search')); ?>"</span>
                    <?php endif; ?>
                    <?php if(request('min_price') || request('max_price')): ?>
                        <span class="filter-chip">PKR <?php echo e(request('min_price',0)); ?> – <?php echo e(request('max_price','∞')); ?></span>
                    <?php endif; ?>
                    <?php if(request('organic') == '1'): ?> <span class="filter-chip">🌱 Organic</span> <?php endif; ?>
                    <?php if(request('featured') == '1'): ?> <span class="filter-chip">⭐ Featured</span> <?php endif; ?>
                    <?php if(request('in_stock') == '1'): ?> <span class="filter-chip">✅ In Stock</span> <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($products->isEmpty()): ?>
                <div class="no-products">
                    <span>🥦</span>
                    <p>No products found. Try a different search or category.</p>
                    <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline" style="margin-top:16px">View All Products</a>
                </div>
            <?php else: ?>
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:20px;">
                    <?php echo e($products->total()); ?> product<?php echo e($products->total() != 1 ? 's' : ''); ?> found
                    <?php if($products->lastPage() > 1): ?>
                        — Page <?php echo e($products->currentPage()); ?> of <?php echo e($products->lastPage()); ?>

                    <?php endif; ?>
                </p>
                <div class="products-grid">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isNew = $product->created_at->diffInDays(now()) <= 14;
                        ?>
                        <div class="product-card">
                            <?php if($isNew): ?>
                                <div class="badge-new">New</div>
                            <?php endif; ?>
                            <?php if($product->is_featured && !$isNew): ?>
                                <div class="badge-featured">⭐</div>
                            <?php endif; ?>
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>">
                                <img src="<?php echo e($product->image_url); ?>"
                                    alt="<?php echo e($product->name); ?>" loading="lazy"
                                    onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                            </a>
                            <div class="product-card-body">
                                <div class="product-card-cat"><?php echo e($product->category->name); ?></div>
                                <?php
                                    if ($product->stock <= 0) { $sl = 'stock-out'; $st = 'Out of Stock'; }
                                    elseif ($product->stock <= 5) { $sl = 'stock-low'; $st = 'Low Stock'; }
                                    else { $sl = 'stock-in'; $st = 'In Stock'; }
                                ?>
                                <span class="stock-label <?php echo e($sl); ?>"><?php echo e($st); ?></span>
                                <a href="<?php echo e(route('product.show', $product->slug)); ?>">
                                    <div class="product-card-name"><?php echo e($product->name); ?></div>
                                </a>
                                <div class="product-card-desc"><?php echo e(Str::limit($product->description, 70)); ?></div>
                                <div class="product-card-footer">
                                    <span class="product-price">PKR <?php echo e(number_format($product->price, 0)); ?></span>
                                    <?php if($product->is_organic): ?>
                                        <span class="organic-badge">Organic</span>
                                    <?php endif; ?>
                                </div>
                                <?php if($product->stock > 0): ?>
                                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="margin-top:12px">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <button type="submit" class="btn btn-primary"
                                            style="width:100%;justify-content:center">🛒 Add to Cart</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-gray" style="width:100%;justify-content:center;margin-top:12px" disabled>
                                        Out of Stock
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="pagination-wrapper">
                    <?php echo e($products->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/shop/index.blade.php ENDPATH**/ ?>