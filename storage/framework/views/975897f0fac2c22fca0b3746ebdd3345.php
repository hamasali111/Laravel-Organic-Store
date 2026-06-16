<?php $__env->startSection('title', 'Orders — Admin'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .74rem;
            font-weight: 600
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div style="margin-bottom:24px">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Orders</h1>
    </div>
    <div class="admin-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></strong></td>
                        <td>
                            <div style="font-weight:600"><?php echo e($order->shipping_name); ?></div>
                            <div style="font-size:.76rem;color:var(--muted)"><?php echo e($order->shipping_email); ?></div>
                        </td>
                        <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                        <td><?php echo e($order->items()->count()); ?></td>
                        <td><strong>PKR <?php echo e(number_format($order->total, 0)); ?></strong></td>
                        <td><span class="status-badge"
                                style="background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>"><?php echo e($order->statusLabel()); ?></span>
                        </td>
                        <td><a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-outline">Manage</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="margin-top:20px"><?php echo e($orders->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>