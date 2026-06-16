<?php $__env->startSection('title', 'Order Confirmed — Organic Store'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .success-wrap { max-width:660px; margin:80px auto; padding:0 24px; text-align:center; }
    .success-icon { font-size:5rem; margin-bottom:24px; animation:pop .5s cubic-bezier(.34,1.56,.64,1) both; }
    @keyframes pop { from { transform:scale(0); opacity:0; } to { transform:scale(1); opacity:1; } }
    .success-card { background:var(--white); border:1px solid var(--border); border-radius:20px; padding:48px 40px; box-shadow:var(--shadow-md); }
    .success-card h1 { font-family:'Playfair Display',serif; font-size:2rem; color:var(--green); margin-bottom:12px; }
    .success-card p { color:var(--muted); font-size:.95rem; line-height:1.7; margin-bottom:20px; }
    .order-details { background:var(--green-xpale); border-radius:12px; padding:20px; text-align:left; margin-bottom:28px; }
    .order-detail-row { display:flex; justify-content:space-between; font-size:.9rem; padding:6px 0; }
    .order-detail-row:not(:last-child) { border-bottom:1px solid var(--border); }
    .order-detail-row span:first-child { color:var(--muted); }
    .order-detail-row span:last-child { font-weight:600; }
    .success-actions { display:flex; gap:14px; justify-content:center; flex-wrap:wrap; margin-top:24px; }
    /* Mini tracker */
    .mini-tracker { display:flex; align-items:center; justify-content:center; gap:0; margin-bottom:28px; }
    .mt-step { display:flex; flex-direction:column; align-items:center; gap:4px; }
    .mt-dot { width:36px; height:36px; border-radius:50%; background:var(--green); color:#fff; display:flex; align-items:center; justify-content:center; font-size:.95rem; font-weight:700; }
    .mt-dot.inactive { background:var(--border); color:var(--muted); }
    .mt-line { width:40px; height:3px; background:var(--border); margin-bottom:20px; }
    .mt-line.done { background:var(--green); }
    .mt-label { font-size:.68rem; font-weight:600; color:var(--muted); text-align:center; max-width:56px; }
    .mt-label.done { color:var(--green); }
    .email-notice { background:#e8f4fd; border:1px solid #bee3f8; border-radius:12px; padding:14px 18px; font-size:.86rem; color:#1d6fa4; margin-bottom:20px; text-align:left; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="success-wrap">
    <div class="success-card">
        <div class="success-icon">🌿</div>
        <h1>Order Confirmed!</h1>
        <p>
            Thank you, <strong><?php echo e($order->shipping_name); ?></strong>! Your organic order has been placed successfully.
        </p>

        
        <div class="mini-tracker">
            <?php
                $steps = [
                    ['icon'=>'🛒','label'=>'Placed'],
                    ['icon'=>'✅','label'=>'Confirmed'],
                    ['icon'=>'⚙️','label'=>'Processing'],
                    ['icon'=>'🚚','label'=>'Shipped'],
                    ['icon'=>'🎉','label'=>'Delivered'],
                ];
                $current = $order->statusStep();
            ?>
            <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($i > 0): ?><div class="mt-line <?php echo e($i <= $current ? 'done' : ''); ?>"></div><?php endif; ?>
                <div class="mt-step">
                    <div class="mt-dot <?php echo e($i > $current ? 'inactive' : ''); ?>"><?php echo e($i < $current ? '✓' : $s['icon']); ?></div>
                    <div class="mt-label <?php echo e($i <= $current ? 'done' : ''); ?>"><?php echo e($s['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="email-notice">
            📧 A confirmation email has been sent to <strong><?php echo e($order->shipping_email); ?></strong>. Check your inbox (or spam) for your order details.
        </div>

        <div class="order-details">
            <div class="order-detail-row">
                <span>Order #</span>
                <span>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></span>
            </div>
            <div class="order-detail-row">
                <span>Status</span>
                <span style="color:var(--green)"><?php echo e($order->statusLabel()); ?></span>
            </div>
            <div class="order-detail-row">
                <span>Shipping to</span>
                <span><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_zip); ?></span>
            </div>
            <?php if($order->discount > 0): ?>
            <div class="order-detail-row">
                <span>Discount</span>
                <span style="color:var(--amber)">−PKR <?php echo e(number_format($order->discount, 0)); ?></span>
            </div>
            <?php endif; ?>
            <div class="order-detail-row">
                <span>Order Total</span>
                <span>PKR <?php echo e(number_format($order->total, 0)); ?></span>
            </div>
            <div class="order-detail-row">
                <span>Items</span>
                <span><?php echo e($order->items->count()); ?> item(s)</span>
            </div>
        </div>

        <div style="background:var(--amber-light,#fff8e1);border:1px solid #e9a82544;border-radius:12px;padding:16px;margin-bottom:8px;font-size:.88rem;color:#92400e;">
            🚚 <strong>Estimated delivery:</strong> 2–5 business days. You'll receive tracking info via email once your order ships.
        </div>

        <div class="success-actions">
            <a href="<?php echo e(route('orders.track')); ?>" class="btn btn-outline">🔍 Track Order</a>
            <a href="<?php echo e(route('home')); ?>" class="btn btn-outline">Back to Home</a>
            <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/checkout/success.blade.php ENDPATH**/ ?>