<?php $__env->startSection('title', 'Admin Dashboard — Organic Store'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 18px;
            margin-bottom: 36px
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            text-align: center
        }

        .stat-card .val {
            font-size: 2rem;
            font-weight: 700;
            color: var(--green);
            font-family: 'Playfair Display', serif
        }

        .stat-card .lbl {
            font-size: .8rem;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-top: 4px
        }

        .stat-card.warn .val {
            color: var(--amber)
        }

        .stat-card.danger .val {
            color: var(--red)
        }

        .grid2 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px
        }

        .admin-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px
        }

        .admin-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            margin-bottom: 18px
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
            padding: 8px 0;
            border-bottom: 2px solid var(--border)
        }

        .data-table td {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            font-size: .88rem;
            vertical-align: middle
        }

        .status-badge {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 50px;
            font-size: .72rem;
            font-weight: 600
        }

        @media(max-width:768px) {
            .grid2 {
                grid-template-columns: 1fr
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:28px">Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="val"><?php echo e($stats['total_orders']); ?></div>
            <div class="lbl">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="val" style="font-size:1.5rem">PKR <?php echo e(number_format($stats['total_revenue'], 0)); ?></div>
            <div class="lbl">Total Revenue</div>
        </div>
        <div class="stat-card">
            <div class="val"><?php echo e($stats['total_products']); ?></div>
            <div class="lbl">Products</div>
        </div>
        <div class="stat-card">
            <div class="val"><?php echo e($stats['total_users']); ?></div>
            <div class="lbl">Customers</div>
        </div>
        <div class="stat-card warn">
            <div class="val"><?php echo e($stats['pending_orders']); ?></div>
            <div class="lbl">Pending Orders</div>
        </div>
        <div class="stat-card danger">
            <div class="val"><?php echo e($stats['low_stock']); ?></div>
            <div class="lbl">Low Stock Items</div>
        </div>
        <div class="stat-card" style="border-color:#d8f3dc">
            <div class="val"><?php echo e($stats['subscribers']); ?></div>
            <div class="lbl">Newsletter Subs</div>
        </div>
    </div>

    
    <div class="admin-card" style="margin-bottom:24px">
        <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:20px">Revenue — Last 7 Days</h3>
        <div style="display:flex;align-items:flex-end;gap:12px;height:140px">
            <?php $maxRev = max(array_column($revenue_days,'total')) ?: 1; ?>
            <?php $__currentLoopData = $revenue_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $h = max(4, round(($day['total']/$maxRev)*120)); ?>
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px">
                    <div style="font-size:.72rem;color:var(--muted);font-weight:600">
                        <?php echo e($day['total'] > 0 ? 'PKR '.number_format($day['total'],0) : ''); ?>

                    </div>
                    <div style="width:100%;background:<?php echo e($day['total']>0 ? 'var(--green)' : 'var(--border)'); ?>;border-radius:6px 6px 0 0;height:<?php echo e($h); ?>px;transition:height .3s"></div>
                    <div style="font-size:.72rem;color:var(--muted);font-weight:600"><?php echo e($day['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="grid2">
        <div class="admin-card">
            <h3>Recent Orders</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></td>
                            <td><?php echo e($order->shipping_name); ?></td>
                            <td>PKR <?php echo e(number_format($order->total, 0)); ?></td>
                            <td><span class="status-badge"
                                    style="background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>"><?php echo e($order->statusLabel()); ?></span>
                            </td>
                            <td><a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                                    class="btn btn-sm btn-outline">View</a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="admin-card">
            <h3>Top Products</h3>
            <?php $__currentLoopData = $top_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)">
                    <div style="font-size:1.2rem;font-weight:700;color:var(--muted);width:24px"><?php echo e($i + 1); ?></div>
                    <img src="<?php echo e($p->image); ?>" style="width:42px;height:42px;border-radius:8px;object-fit:cover">
                    <div style="flex:1">
                        <div style="font-size:.86rem;font-weight:600"><?php echo e($p->name); ?></div>
                        <div style="font-size:.76rem;color:var(--muted)"><?php echo e($p->order_items_count); ?> sold</div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <?php if($low_stock_list->isNotEmpty()): ?>
    <div class="admin-card" style="margin-top:24px;border-left:4px solid var(--red)">
        <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px;color:var(--red)">⚠ Low Stock Alert (<?php echo e($stats['low_stock']); ?> product<?php echo e($stats['low_stock']!=1?'s':''); ?>)</h3>
        <table class="data-table">
            <thead><tr><th>Product</th><th>Category</th><th>Stock Left</th><th>Action</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $low_stock_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="display:flex;align-items:center;gap:10px;padding:10px 0">
                    <img src="<?php echo e($p->image); ?>" style="width:38px;height:38px;border-radius:6px;object-fit:cover">
                    <strong style="font-size:.88rem"><?php echo e($p->name); ?></strong>
                </td>
                <td><?php echo e($p->category->name ?? '—'); ?></td>
                <td>
                    <span style="color:<?php echo e($p->stock == 0 ? 'var(--red)' : 'var(--amber)'); ?>;font-weight:700;font-size:.95rem">
                        <?php echo e($p->stock == 0 ? '❌ Out of Stock' : '⚠ '.$p->stock.' left'); ?>

                    </span>
                </td>
                <td><a href="<?php echo e(route('admin.products.edit', $p->id)); ?>" class="btn btn-sm btn-outline">Restock</a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>