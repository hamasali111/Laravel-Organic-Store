<?php $__env->startSection('title', 'Your Cart — Organic_store'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .cart-layout {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 24px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            align-items: start;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th {
            text-align: left;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            padding: 12px 0;
            border-bottom: 2px solid var(--border);
        }

        .cart-row {
            border-bottom: 1px solid var(--border);
        }

        .cart-row td {
            padding: 20px 0;
            vertical-align: middle;
        }

        .cart-product {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cart-img {
            width: 72px;
            height: 72px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .cart-name {
            font-family: 'Playfair Display', serif;
            font-size: .98rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .cart-cat {
            font-size: .78rem;
            color: var(--muted);
        }

        .qty-inline {
            width: 64px;
            padding: 6px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            text-align: center;
            font-size: .9rem;
        }

        .order-summary {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            position: sticky;
            top: 88px;
        }

        .order-summary h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: .9rem;
            margin-bottom: 12px;
        }

        .summary-row.total {
            font-size: 1.1rem;
            font-weight: 700;
            border-top: 2px solid var(--border);
            padding-top: 16px;
            margin-top: 8px;
        }

        .empty-cart {
            text-align: center;
            padding: 80px 24px;
        }

        .empty-cart span {
            font-size: 4rem;
            display: block;
            margin-bottom: 20px;
        }

        .empty-cart h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            margin-bottom: 12px;
        }

        .coupon-box {
            background: var(--green-xpale);
            border-radius: 10px;
            padding: 16px;
            margin-top: 16px;
        }

        .coupon-box input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: .85rem;
            font-family: inherit;
        }

        .coupon-applied {
            background: var(--green-pale);
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media(max-width:768px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a> <span>›</span> Your Cart</div>

    <?php if($items->isEmpty()): ?>
        <div class="empty-chicart">
            <span>🛒</span>
            <h2>Your cart is empty</h2>
            <p style="color:var(--muted);margin-bottom:28px">Looks like you haven't added anything yet. Browse our organic
                selection!</p>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div>
                <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:28px">Your Cart</h1>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="cart-row">
                                <td>
                                    <div class="cart-product">
                                        <img src="<?php echo e($item->product->image_url); ?>" alt="<?php echo e($item->product->name); ?>"
                                            class="cart-img"
                                            onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=200&q=60'">
                                        <div>
                                            <div class="cart-name"><?php echo e($item->product->name); ?></div>
                                            <div class="cart-cat"><?php echo e($item->product->category->name ?? ''); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight:600">PKR <?php echo e(number_format($item->product->price, 0)); ?></td>
                                <td>
                                    <form action="<?php echo e(route('cart.update')); ?>" method="POST" style="display:inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="item_id" value="<?php echo e($item->id); ?>">
                                        <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1"
                                            class="qty-inline" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td style="font-weight:700;color:var(--green)">PKR
                                    <?php echo e(number_format($item->product->price * $item->quantity, 0)); ?></td>
                                <td>
                                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="item_id" value="<?php echo e($item->id); ?>">
                                        <button type="submit" class="btn btn-sm"
                                            style="background:#fde8e8;color:var(--red);border:none;cursor:pointer">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <div style="margin-top:24px">
                    <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline btn-sm">← Continue Shopping</a>
                </div>
            </div>

            <div class="order-summary">
                <h3>Order Summary</h3>
                <div class="summary-row"><span>Subtotal</span><span>PKR <?php echo e(number_format($subtotal, 0)); ?></span></div>
                <?php if($discount > 0): ?>
                    <div class="summary-row" style="color:var(--green)"><span>🎟 Coupon
                            (<?php echo e($coupon); ?>)</span><span>-PKR <?php echo e(number_format($discount, 0)); ?></span></div>
                <?php endif; ?>
                <div class="summary-row"><span>Shipping</span><span><?php echo e($total >= 5000 ? 'Free 🎉' : 'PKR 200'); ?></span>
                </div>
                <?php if($total < 5000): ?>
                    <p
                        style="font-size:.78rem;color:var(--green);background:var(--green-pale);padding:8px 12px;border-radius:8px;margin-bottom:12px">
                        Add PKR <?php echo e(number_format(5000 - $total, 0)); ?> more for free shipping!
                    </p>
                <?php endif; ?>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>PKR <?php echo e(number_format($total + ($total >= 5000 ? 0 : 200), 0)); ?></span>
                </div>

                <div class="coupon-box">
                    <?php if($coupon): ?>
                        <div class="coupon-applied">
                            <span style="font-size:.84rem;font-weight:600;color:var(--green)">🎟 <?php echo e($coupon); ?>

                                applied!</span>
                            <form method="POST" action="<?php echo e(route('cart.coupon.remove')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-danger"
                                    style="padding:4px 10px">Remove</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('cart.coupon')); ?>" style="display:flex;gap:8px">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="code" placeholder="Coupon code"
                                style="flex:1;padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:.85rem;font-family:inherit;text-transform:uppercase">
                            <button type="submit" class="btn btn-sm btn-amber">Apply</button>
                        </form>
                    <?php endif; ?>
                </div>

                <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary"
                    style="width:100%;justify-content:center;margin-top:20px;font-size:1rem;">
                    Proceed to Checkout →
                </a>
                <div style="text-align:center;margin-top:16px;font-size:.78rem;color:var(--muted);">
                    🔒 Secure checkout &nbsp;|&nbsp;  Organic guaranteed
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/cart/index.blade.php ENDPATH**/ ?>