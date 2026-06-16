<?php $__env->startSection('title','Return Request — Order #' . str_pad($order->id,6,'0',STR_PAD_LEFT)); ?>
<?php $__env->startSection('content'); ?>
<div class="breadcrumb">
    <a href="<?php echo e(route('home')); ?>">Home</a><span>›</span>
    <a href="<?php echo e(route('orders.index')); ?>">Orders</a><span>›</span>
    <a href="<?php echo e(route('orders.show', $order->id)); ?>">#<?php echo e(str_pad($order->id,6,'0',STR_PAD_LEFT)); ?></a><span>›</span>
    Return Request
</div>
<div style="max-width:640px;margin:40px auto;padding:0 24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:8px">Request Return / Refund</h1>
    <p style="color:var(--muted);margin-bottom:28px">Order #<?php echo e(str_pad($order->id,6,'0',STR_PAD_LEFT)); ?> — Placed <?php echo e($order->created_at->format('M d, Y')); ?></p>

    <?php if($existing): ?>
    <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:10px;padding:16px;margin-bottom:24px">
        <strong>You already have a return request</strong> — Status: <strong><?php echo e($existing->statusLabel()); ?></strong><br>
        <span style="font-size:.86rem;color:var(--muted)"><?php echo e($existing->reason); ?></span>
    </div>
    <?php endif; ?>

    <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:28px">
        <form method="POST" action="<?php echo e(route('orders.returns.store', $order->id)); ?>">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.83rem;font-weight:600;margin-bottom:6px">Reason for Return *</label>
                <select name="reason" class="form-control" required style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-size:.9rem">
                    <option value="">Select a reason…</option>
                    <option value="Wrong item received" <?php echo e(old('reason')==='Wrong item received'?'selected':''); ?>>Wrong item received</option>
                    <option value="Damaged / defective product" <?php echo e(old('reason')==='Damaged / defective product'?'selected':''); ?>>Damaged / defective product</option>
                    <option value="Product not as described" <?php echo e(old('reason')==='Product not as described'?'selected':''); ?>>Product not as described</option>
                    <option value="Quality not satisfactory" <?php echo e(old('reason')==='Quality not satisfactory'?'selected':''); ?>>Quality not satisfactory</option>
                    <option value="Changed my mind" <?php echo e(old('reason')==='Changed my mind'?'selected':''); ?>>Changed my mind</option>
                    <option value="Other" <?php echo e(old('reason')==='Other'?'selected':''); ?>>Other</option>
                </select>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div style="color:var(--red);font-size:.78rem;margin-top:4px"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-bottom:22px">
                <label style="display:block;font-size:.83rem;font-weight:600;margin-bottom:6px">Additional Details (optional)</label>
                <textarea name="details" class="form-control" rows="4" placeholder="Describe the issue in detail…" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-size:.9rem;font-family:inherit;resize:vertical"><?php echo e(old('details')); ?></textarea>
            </div>

            <div style="background:var(--green-pale);border-radius:10px;padding:14px 16px;font-size:.84rem;color:var(--green);margin-bottom:20px">
                🌱 We review return requests within 24–48 hours. You'll receive a confirmation email once processed.
            </div>

            <div style="display:flex;gap:12px">
                <button type="submit" class="btn btn-primary">Submit Return Request</button>
                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-gray">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/orders/returns/create.blade.php ENDPATH**/ ?>