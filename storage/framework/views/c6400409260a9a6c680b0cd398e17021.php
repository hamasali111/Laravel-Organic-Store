<?php $__env->startSection('title', 'Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .tracker-steps {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
            margin: 24px 0 32px
        }

        .tracker-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 28px;
            right: 28px;
            height: 3px;
            background: var(--border);
            z-index: 0
        }

        .ts {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            position: relative;
            z-index: 1;
            flex: 1
        }

        .ts-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            color: var(--muted)
        }

        .ts-dot.done {
            background: var(--green);
            border-color: var(--green);
            color: #fff
        }

        .ts-dot.active {
            background: #fff;
            border-color: var(--amber);
            color: var(--amber);
            box-shadow: 0 0 0 4px rgba(233, 168, 37, .15)
        }

        .ts-label {
            font-size: .7rem;
            font-weight: 600;
            color: var(--muted);
            text-align: center
        }

        .ts-label.done {
            color: var(--green)
        }

        .ts-label.active {
            color: var(--amber)
        }

        .note-bubble {
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: .88rem
        }

        .note-bubble.admin {
            background: #eef2ff;
            color: #2d3a8c
        }

        .note-bubble.customer {
            background: var(--green-pale);
            color: var(--text)
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Order
            #<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?>

        </h1>
        <div style="display:flex;gap:10px">
            <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-outline btn-sm" target="_blank">⬇ Invoice
                PDF</a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-gray">← Orders</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div
            style="background:var(--green-pale);border:1px solid var(--green-light);color:var(--green);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <?php if($order->status !== 'cancelled'): ?>
        <div class="admin-card" style="margin-bottom:20px">
            <h3 style="font-family:'Playfair Display',serif;font-size:1rem;margin-bottom:0;color:var(--muted)">Shipping
                Progress</h3>
            <?php
                $steps = [
                    ['key' => 'pending', 'icon' => '🛒', 'label' => 'Placed'],
                    ['key' => 'confirmed', 'icon' => '✅', 'label' => 'Confirmed'],
                    ['key' => 'processing', 'icon' => '⚙️', 'label' => 'Processing'],
                    ['key' => 'shipped', 'icon' => '🚚', 'label' => 'Shipped'],
                    ['key' => 'delivered', 'icon' => '🎉', 'label' => 'Delivered'],
                ];
                $statusIdx = ['pending' => 0, 'confirmed' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
                $cur = $statusIdx[$order->status] ?? 0;
            ?>
            <div class="tracker-steps">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $cls = $i < $cur ? 'done' : ($i === $cur ? 'active' : ''); ?>
                    <div class="ts">
                        <div class="ts-dot <?php echo e($cls); ?>"><?php echo e($i < $cur ? '✓' : $s['icon']); ?></div>
                        <div class="ts-label <?php echo e($cls); ?>"><?php echo e($s['label']); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 360px;gap:24px">
        <div>
            
            <div class="admin-card" style="margin-bottom:20px">
                <h3
                    style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)">
                    Order Items</h3>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)">
                        <img src="<?php echo e($item->product->image); ?>"
                            style="width:56px;height:56px;border-radius:8px;object-fit:cover">
                        <div style="flex:1">
                            <div style="font-weight:600;font-size:.9rem"><?php echo e($item->product->name); ?></div>
                            <div style="font-size:.78rem;color:var(--muted)">Qty: <?php echo e($item->quantity); ?> × PKR
                                <?php echo e(number_format($item->price, 0)); ?></div>
                        </div>
                        <div style="font-weight:700;color:var(--green)">PKR
                            <?php echo e(number_format($item->price * $item->quantity, 0)); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($order->discount > 0): ?>
                    <div
                        style="display:flex;justify-content:space-between;font-size:.88rem;padding:8px 0;color:var(--amber)">
                        <span>Discount (<?php echo e($order->coupon_code); ?>)</span><span>−PKR
                            <?php echo e(number_format($order->discount, 0)); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(isset($order->shipping_fee) && $order->shipping_fee > 0): ?>
                    <div
                        style="display:flex;justify-content:space-between;font-size:.88rem;padding:4px 0;color:var(--muted)">
                        <span>Shipping</span><span>PKR <?php echo e(number_format($order->shipping_fee, 0)); ?></span>
                    </div>
                <?php endif; ?>
                <div
                    style="margin-top:14px;padding-top:14px;border-top:2px solid var(--border);display:flex;justify-content:space-between;font-size:1rem;font-weight:700">
                    <span>Total</span><span>PKR <?php echo e(number_format($order->total, 0)); ?></span>
                </div>
            </div>

            
            <div class="admin-card" style="margin-bottom:20px">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">Shipping Info</h3>
                <div style="font-size:.9rem;line-height:1.8">
                    <strong><?php echo e($order->shipping_name); ?></strong><br>
                    <?php echo e($order->shipping_address); ?><br>
                    <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_zip); ?><br>
                    <?php echo e($order->shipping_email); ?>

                    <?php if($order->shipping_phone): ?>
                        <br><?php echo e($order->shipping_phone); ?>

                    <?php endif; ?>
                </div>
                <?php if($order->notes): ?>
                    <div
                        style="margin-top:14px;padding-top:12px;border-top:1px solid var(--border);font-size:.84rem;color:var(--muted)">
                        <strong>Order Notes:</strong> <?php echo e($order->notes); ?>

                    </div>
                <?php endif; ?>
            </div>

            
            <div class="admin-card" style="margin-bottom:20px">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">Payment Info</h3>
                <div style="font-size:.9rem;margin-bottom:12px">
                    <strong>Method:</strong> <?php echo e($order->paymentMethodLabel()); ?><br>
                    <strong>Status:</strong>
                    <span style="color:<?php echo e($order->paymentStatusColor()); ?>;font-weight:600">
                        <?php echo e($order->paymentStatusLabel()); ?></span>
                </div>
                <?php if($order->payment_proof): ?>
                    <div style="margin-bottom:16px">
                        <div style="font-size:.82rem;color:var(--muted);margin-bottom:6px">Payment Proof:</div>
                        <a href="<?php echo e(asset($order->payment_proof)); ?>" target="_blank">
                            <img src="<?php echo e(asset($order->payment_proof)); ?>"
                                style="max-width:100%;max-height:300px;border-radius:8px;border:1px solid var(--border);object-fit:contain;cursor:pointer">
                        </a>
                    </div>
                <?php endif; ?>
                <?php if($order->payment_method !== 'cod'): ?>
                    <form method="POST" action="<?php echo e(route('admin.orders.update', $order->id)); ?>"
                        style="display:flex;gap:10px;align-items:center">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <select name="payment_status" class="form-control" style="flex:1">
                            <?php $__currentLoopData = ['pending' => 'Awaiting Verification', 'verified' => 'Verified', 'rejected' => 'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>"
                                    <?php echo e($order->payment_status === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                <?php endif; ?>
            </div>

            
            <?php if($order->returns->isNotEmpty()): ?>
                <div class="admin-card" style="margin-bottom:20px">
                    <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">↩ Return Request
                    </h3>
                    <?php $__currentLoopData = $order->returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ret): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="margin-bottom:14px;padding:14px;border:1px solid var(--border);border-radius:10px">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                                <strong><?php echo e($ret->reason); ?></strong>
                                <span
                                    style="color:<?php echo e($ret->statusColor()); ?>;font-weight:600;font-size:.82rem"><?php echo e($ret->statusLabel()); ?></span>
                            </div>
                            <?php if($ret->details): ?>
                                <div style="font-size:.85rem;color:var(--muted);margin-bottom:10px"><?php echo e($ret->details); ?>

                                </div>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('admin.returns.update', $ret->id)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <div style="display:flex;gap:8px;margin-bottom:8px">
                                    <select name="status" class="form-control">
                                        <?php $__currentLoopData = ['pending', 'approved', 'rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s); ?>"
                                                <?php echo e($ret->status === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                </div>
                                <input type="text" name="admin_note" class="form-control" value="<?php echo e($ret->admin_note); ?>"
                                    placeholder="Admin note to customer (optional)">
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            
            <div class="admin-card">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">
                    💬 Order Messages
                </h3>

                <?php if($order->orderNotes->isEmpty()): ?>
                    <p style="color:var(--muted);font-size:.85rem;margin-bottom:14px">
                        No messages yet.
                    </p>
                <?php else: ?>
                    <div style="margin-bottom:16px">
                        <?php $__currentLoopData = $order->orderNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="note-bubble <?php echo e($note->is_admin ? 'admin' : 'customer'); ?>">
                                <div style="font-size:.75rem;font-weight:700;opacity:.7;margin-bottom:3px">
                                    <?php echo e($note->is_admin ? '🛡 You (Admin)' : '👤 ' . ($note->user?->name ?? 'Customer')); ?>

                                    · <?php echo e($note->created_at->format('M d, h:i A')); ?>

                                </div>
                                <?php echo e($note->message); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.orders.update', $order->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="status" value="<?php echo e($order->status); ?>">
                    <textarea name="admin_note" class="form-control" rows="3"
                        placeholder="Send a message to the customer…"
                        style="width:100%;margin-bottom:8px;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-family:inherit;resize:vertical"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <div>
            
            <div class="admin-card">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px">Update Order</h3>
                <form method="POST" action="<?php echo e(route('admin.orders.update', $order->id)); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="form-group">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-control">
                            <?php $__currentLoopData = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s); ?>" <?php echo e($order->status === $s ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($s)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number" class="form-control"
                            value="<?php echo e($order->tracking_number); ?>" placeholder="e.g. TRK1234567890">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Update &
                        Notify Customer</button>
                </form>
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border)">
                    <div style="font-size:.8rem;color:var(--muted)">Placed:
                        <?php echo e($order->created_at->format('M d, Y h:i A')); ?></div>
                    <?php if($order->shipped_at): ?>
                        <div style="font-size:.8rem;color:var(--muted)">Shipped:
                            <?php echo e($order->shipped_at->format('M d, Y')); ?></div>
                    <?php endif; ?>
                    <?php if($order->delivered_at): ?>
                        <div style="font-size:.8rem;color:var(--muted)">Delivered:
                            <?php echo e($order->delivered_at->format('M d, Y')); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>