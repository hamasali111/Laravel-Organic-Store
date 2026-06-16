<?php $__env->startSection('title','Coupons — Admin'); ?>
<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Coupons</h1>
    <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">+ Add Coupon</a>
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
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Uses Left</th>
                <th>Expires</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><strong style="font-family:monospace;font-size:.95rem;color:var(--green)"><?php echo e($coupon->code); ?></strong></td>
            <td><?php echo e(ucfirst($coupon->type)); ?></td>
            <td><?php echo e($coupon->type === 'percent' ? $coupon->value . '%' : 'PKR ' . number_format($coupon->value,0)); ?></td>
            <td>PKR <?php echo e(number_format($coupon->min_order,0)); ?></td>
            <td><?php echo e($coupon->uses_left ?? '∞'); ?></td>
            <td><?php echo e($coupon->expires_at ? $coupon->expires_at->format('M d, Y') : '—'); ?></td>
            <td><span style="color:<?php echo e($coupon->active ? 'var(--green)' : 'var(--red)'); ?>;font-weight:600"><?php echo e($coupon->active ? 'Yes' : 'No'); ?></span></td>
            <td>
                <div style="display:flex;gap:6px">
                    <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" class="btn btn-sm btn-outline">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" onsubmit="return confirm('Delete this coupon?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="8" style="text-align:center;padding:32px;color:var(--muted)">
                No coupons yet. <a href="<?php echo e(route('admin.coupons.create')); ?>">Add one</a>.
            </td>
        </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div style="margin-top:20px"><?php echo e($coupons->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>