<?php $__env->startSection('title', 'My Orders — Organic_store'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .page-wrap {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 24px
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 28px
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse
        }

        .orders-table th {
            text-align: left;
            font-size: .76rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            padding: 10px 0;
            border-bottom: 2px solid var(--border)
        }

        .orders-table td {
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: .9rem
        }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .76rem;
            font-weight: 600
        }

        .empty-state {
            text-align: center;
            padding: 60px 24px
        }

        .empty-state span {
            font-size: 3.5rem;
            display: block;
            margin-bottom: 16px
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 32px;
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
            box-shadow: 0 2px 6px rgba(0,0,0,.05);
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
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a><span>›</span>My Orders</div>
    <div class="page-wrap">
        <h1 class="page-title">My Orders</h1>
        <?php if($orders->isEmpty()): ?>
            <div class="empty-state">
                <span>📦</span>
                <h2 style="font-family:'Playfair Display',serif;margin-bottom:12px">No orders yet</h2>
                <p style="color:var(--muted);margin-bottom:24px">You haven't placed any orders yet. Start shopping!</p>
                <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></strong></td>
                            <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                            <td><?php echo e($order->items()->count()); ?> item(s)</td>
                            <td><strong>PKR <?php echo e(number_format($order->total, 0)); ?></strong></td>
                            <td>
                                <span class="status-badge"
                                    style="background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>">
                                    <?php echo e($order->statusLabel()); ?>

                                </span>
                            </td>
                            <td><a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-outline">View</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="pagination-wrapper">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/orders/index.blade.php ENDPATH**/ ?>