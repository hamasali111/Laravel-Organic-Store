<?php $__env->startSection('title','Wishlist — Organic_store'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.page-wrap{max-width:1100px;margin:40px auto;padding:0 24px}
.page-title{font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:28px}
.empty-state{text-align:center;padding:60px 24px}
.empty-state span{font-size:3.5rem;display:block;margin-bottom:16px}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a><span>›</span>Wishlist</div>
<div class="page-wrap">
    <h1 class="page-title">My Wishlist</h1>
    <?php if($items->isEmpty()): ?>
    <div class="empty-state">
        <span>💚</span>
        <h2 style="font-family:'Playfair Display',serif;margin-bottom:12px">Your wishlist is empty</h2>
        <p style="color:var(--muted);margin-bottom:24px">Save products you love and find them here.</p>
        <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Browse Products</a>
    </div>
    <?php else: ?>
    <div class="products-grid">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="product-card">
            <a href="<?php echo e(route('product.show', $item->product->slug)); ?>">
                <img src="<?php echo e($item->product->image); ?>" alt="<?php echo e($item->product->name); ?>" loading="lazy">
            </a>
            <div class="product-card-body">
                <div class="product-card-cat"><?php echo e($item->product->category->name ?? ''); ?></div>
                <a href="<?php echo e(route('product.show', $item->product->slug)); ?>">
                    <div class="product-card-name"><?php echo e($item->product->name); ?></div>
                </a>
                <div class="product-card-desc"><?php echo e($item->product->description); ?></div>
                <div class="product-card-footer">
                    <span class="product-price">PKR <?php echo e(number_format($item->product->price,0)); ?></span>
                    <?php if($item->product->is_organic): ?><span class="organic-badge">Organic</span><?php endif; ?>
                </div>
                <div style="display:flex;gap:8px;margin-top:10px">
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="flex:1">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($item->product->id); ?>">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;font-size:.82rem">Add to Cart</button>
                    </form>
                    <form action="<?php echo e(route('wishlist.toggle')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($item->product->id); ?>">
                        <button type="submit" class="btn btn-danger btn-sm" title="Remove">🗑</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/wishlist/index.blade.php ENDPATH**/ ?>