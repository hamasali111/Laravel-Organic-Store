<?php $__env->startSection('title','Order #' . str_pad($order->id,6,'0',STR_PAD_LEFT) . ' — Organic_store'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.order-wrap{max-width:960px;margin:40px auto;padding:0 24px}
.order-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;flex-wrap:wrap;gap:16px}
.order-header h1{font-family:'Playfair Display',serif;font-size:1.8rem}
.status-badge{display:inline-block;padding:5px 14px;border-radius:50px;font-size:.82rem;font-weight:600}
.order-grid{display:grid;grid-template-columns:1fr 320px;gap:28px;align-items:start}
.order-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:24px;margin-bottom:20px}
.order-card h3{font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.info-row{display:flex;justify-content:space-between;font-size:.88rem;padding:6px 0;border-bottom:1px solid #f0f0f0}
.info-row:last-child{border-bottom:none}
.info-row span:first-child{color:var(--muted)}
.order-item-row{display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)}
.order-item-row:last-child{border-bottom:none}
.order-item-row img{width:60px;height:60px;border-radius:8px;object-fit:cover}
.tracking-steps{display:flex;flex-direction:column;gap:0}
.track-step{display:flex;align-items:flex-start;gap:14px;padding:12px 0;position:relative}
.track-step:not(:last-child)::after{content:'';position:absolute;left:15px;top:36px;bottom:-12px;width:2px;background:var(--border)}
.track-dot{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;z-index:1;position:relative}
.track-dot.done{background:var(--green-pale);color:var(--green)}
.track-dot.active{background:var(--green);color:white}
.track-dot.pending{background:var(--border);color:var(--muted)}
.track-label{font-size:.88rem;font-weight:600}
.track-date{font-size:.78rem;color:var(--muted)}
.note-bubble{padding:12px 16px;border-radius:12px;margin-bottom:10px;max-width:85%}
.note-bubble.customer{background:var(--green-pale);color:var(--text);align-self:flex-start}
.note-bubble.admin{background:#eef2ff;color:#2d3a8c;align-self:flex-end;margin-left:auto}
@media(max-width:768px){.order-grid{grid-template-columns:1fr}}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a><span>›</span><a href="<?php echo e(route('orders.index')); ?>">Orders</a><span>›</span>#<?php echo e(str_pad($order->id,6,'0',STR_PAD_LEFT)); ?></div>
<div class="order-wrap">
    <div class="order-header">
        <div>
            <h1>Order #<?php echo e(str_pad($order->id,6,'0',STR_PAD_LEFT)); ?></h1>
            <div style="color:var(--muted);font-size:.88rem;margin-top:4px">Placed on <?php echo e($order->created_at->format('F d, Y')); ?></div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <span class="status-badge" style="background:<?php echo e($order->statusColor()); ?>22;color:<?php echo e($order->statusColor()); ?>"><?php echo e($order->statusLabel()); ?></span>
            <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-sm btn-outline" target="_blank">⬇ Download Invoice</a>
        </div>
    </div>

    <?php if(session('success')): ?><div class="alert-success" style="background:var(--green-pale);border:1px solid var(--green-light);color:var(--green);padding:12px 16px;border-radius:10px;margin-bottom:20px"><?php echo e(session('success')); ?></div><?php endif; ?>
    <?php if(session('error')): ?><div style="background:#fff5f5;border:1px solid #fca5a5;color:#c0392b;padding:12px 16px;border-radius:10px;margin-bottom:20px"><?php echo e(session('error')); ?></div><?php endif; ?>

    <div class="order-grid">
        <div>
            
            <div class="order-card">
                <h3>Items Ordered</h3>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-item-row">
                    <img src="<?php echo e($item->product->image ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=120&q=60'); ?>" alt="<?php echo e($item->product->name); ?>">
                    <div style="flex:1">
                        <div style="font-weight:600;font-size:.9rem"><?php echo e($item->product->name); ?></div>
                        <div style="font-size:.78rem;color:var(--muted)">Qty: <?php echo e($item->quantity); ?> × PKR <?php echo e(number_format($item->price,0)); ?></div>
                    </div>
                    <div style="font-weight:700;color:var(--green)">PKR <?php echo e(number_format($item->price * $item->quantity,0)); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div style="margin-top:14px;padding-top:14px;border-top:2px solid var(--border)">
                    <?php if($order->discount > 0): ?>
                    <div class="info-row"><span>Discount (<?php echo e($order->coupon_code); ?>)</span><span style="color:var(--green)">-PKR <?php echo e(number_format($order->discount,0)); ?></span></div>
                    <?php endif; ?>
                    <?php if(isset($order->shipping_fee) && $order->shipping_fee > 0): ?>
                    <div class="info-row"><span>Shipping</span><span>PKR <?php echo e(number_format($order->shipping_fee,0)); ?></span></div>
                    <?php endif; ?>
                    <div class="info-row" style="font-size:1rem;font-weight:700"><span>Total</span><span>PKR <?php echo e(number_format($order->total,0)); ?></span></div>
                </div>
            </div>

            
            <div class="order-card">
                <h3>Shipping Address</h3>
                <p style="font-size:.9rem;line-height:1.7">
                    <strong><?php echo e($order->shipping_name); ?></strong><br>
                    <?php echo e($order->shipping_address); ?><br>
                    <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_zip); ?><br>
                    <?php echo e($order->shipping_email); ?><?php if($order->shipping_phone): ?><br><?php echo e($order->shipping_phone); ?><?php endif; ?>
                </p>
            </div>

            
            <div class="order-card">
                <h3>Payment</h3>
                <div class="info-row"><span>Method</span><span><strong><?php echo e($order->paymentMethodLabel()); ?></strong></span></div>
                <div class="info-row">
                    <span>Status</span>
                    <span style="color:<?php echo e($order->paymentStatusColor()); ?>;font-weight:600"><?php echo e($order->paymentStatusLabel()); ?></span>
                </div>
                <?php if($order->payment_proof): ?>
                <div style="margin-top:12px">
                    <div style="font-size:.82rem;color:var(--muted);margin-bottom:6px">Payment Screenshot:</div>
                    <a href="<?php echo e(asset($order->payment_proof)); ?>" target="_blank">
                        <img src="<?php echo e(asset($order->payment_proof)); ?>"
                        style="max-width:100%;border-radius:8px;border:1px solid var(--border);cursor:pointer">
                    </a>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="order-card">
                <h3>💬 Order Messages</h3>
                <?php if($order->orderNotes->isEmpty()): ?>
                    <p style="color:var(--muted);font-size:.88rem;margin-bottom:16px">No messages yet. Leave a note for our team below.</p>
                <?php else: ?>
                <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px">
                   <?php $__currentLoopData = $order->orderNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <div class="note-bubble <?php echo e($note->is_admin ? 'admin' : 'customer'); ?>">
                            <div style="font-size:.78rem;font-weight:700;margin-bottom:4px;opacity:.7">
                                <?php echo e($note->is_admin ? '🛡 Organic Store' : '👤 '.$note->user?->name); ?>

                            </div>
                            <?php echo e($note->message); ?>

                        </div>
                        <div style="font-size:.72rem;color:var(--muted);margin-top:2px;<?php echo e($note->is_admin ? 'text-align:right' : ''); ?>"><?php echo e($note->created_at->format('M d, h:i A')); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('orders.notes.store', $order->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <textarea name="message" class="form-control" rows="3" placeholder="Write a message to our team…" required style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-size:.88rem;font-family:inherit;resize:vertical;margin-bottom:10px"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">Send Message</button>
                </form>
            </div>
        </div>

        <div>
            
            <div class="order-card">
                <h3>Order Tracking</h3>
                <?php
                    $steps = [
                        'pending'    => ['label'=>'Order Placed','icon'=>'📋'],
                        'confirmed'  => ['label'=>'Confirmed','icon'=>'✅'],
                        'processing' => ['label'=>'Processing','icon'=>'⚙️'],
                        'shipped'    => ['label'=>'Shipped','icon'=>'🚚'],
                        'delivered'  => ['label'=>'Delivered','icon'=>'🎉'],
                    ];
                    $statuses = array_keys($steps);
                    $currentIdx = array_search($order->status, $statuses);
                ?>
                <?php if($order->status === 'cancelled'): ?>
                    <div style="text-align:center;padding:16px;color:var(--red)">❌ Order Cancelled</div>
                <?php else: ?>
                <div class="tracking-steps">
                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $idx = array_search($key, $statuses);
                        $state = $idx < $currentIdx ? 'done' : ($idx === $currentIdx ? 'active' : 'pending');
                    ?>
                    <div class="track-step">
                        <div class="track-dot <?php echo e($state); ?>"><?php echo e($step['icon']); ?></div>
                        <div>
                            <div class="track-label" style="color:<?php echo e($state==='pending' ? 'var(--muted)' : 'var(--text)'); ?>"><?php echo e($step['label']); ?></div>
                            <?php if($key==='shipped' && $order->shipped_at): ?><div class="track-date"><?php echo e($order->shipped_at->format('M d, Y')); ?></div><?php endif; ?>
                            <?php if($key==='delivered' && $order->delivered_at): ?><div class="track-date"><?php echo e($order->delivered_at->format('M d, Y')); ?></div><?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($order->tracking_number): ?>
                <div style="margin-top:14px;padding:10px 14px;background:var(--green-pale);border-radius:8px;font-size:.84rem">
                    Tracking #: <strong><?php echo e($order->tracking_number); ?></strong>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>

            
            <?php if($order->status === 'delivered'): ?>
            <div class="order-card">
                <h3>Return / Refund</h3>
                <?php $existingReturn = $order->returns->first(); ?>
                <?php if($existingReturn): ?>
                <div style="padding:10px 14px;border-radius:8px;background:<?php echo e($existingReturn->statusColor()); ?>22;border:1px solid <?php echo e($existingReturn->statusColor()); ?>44">
                    <div style="font-weight:600;color:<?php echo e($existingReturn->statusColor()); ?>"><?php echo e($existingReturn->statusLabel()); ?></div>
                    <div style="font-size:.82rem;margin-top:4px">Reason: <?php echo e($existingReturn->reason); ?></div>
                    <?php if($existingReturn->admin_note): ?>
                    <div style="font-size:.82rem;color:var(--muted);margin-top:4px">Admin: <?php echo e($existingReturn->admin_note); ?></div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <p style="font-size:.85rem;color:var(--muted);margin-bottom:14px">Not satisfied with your order? Request a return within 7 days of delivery.</p>
                <a href="<?php echo e(route('orders.returns.create', $order->id)); ?>" class="btn btn-outline btn-sm" style="width:100%;justify-content:center">Request Return / Refund</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <a href="<?php echo e(route('shop')); ?>" class="btn btn-outline" style="width:100%;justify-content:center">Continue Shopping</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/orders/show.blade.php ENDPATH**/ ?>