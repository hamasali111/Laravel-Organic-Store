<?php $__env->startSection('title','Products — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Products</h1>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">+ Add Product</a>
</div>

<?php if(session('success')): ?>
    <div style="background:#e6f4ea;color:#2d6a4f;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
        ✅ <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="admin-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
                <img src="<?php echo e($product->image_url); ?>"
                     alt="<?php echo e($product->name); ?>"
                     style="width:48px;height:48px;border-radius:8px;object-fit:cover"
                     onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=200&q=60'">
            </td>
            <td><strong><?php echo e($product->name); ?></strong></td>
            <td><?php echo e($product->category->name); ?></td>
            <td>PKR <?php echo e(number_format($product->price,0)); ?></td>
            <td>
                <span style="color:<?php echo e($product->stock < 5 ? 'var(--red)' : 'var(--green)'); ?>;font-weight:600"><?php echo e($product->stock); ?></span>
            </td>
            <td><?php echo e($product->is_featured ? '⭐' : '—'); ?></td>
            <td>
                <div style="display:flex;gap:6px">
                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" onsubmit="return confirm('Delete this product?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" style="text-align:center;padding:32px;color:var(--muted)">
                No products yet. <a href="<?php echo e(route('admin.products.create')); ?>">Add one</a>.
            </td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div style="margin-top:20px"><?php echo e($products->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/products/index.blade.php ENDPATH**/ ?>