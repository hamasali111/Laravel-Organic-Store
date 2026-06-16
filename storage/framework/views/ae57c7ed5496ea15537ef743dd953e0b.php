<?php $__env->startSection('title','Return Requests — Admin'); ?>
<?php $__env->startSection('content'); ?>
<h1 style="font-family:'Playfair Display',serif;font-size:1.6rem;margin-bottom:24px">↩ Return Requests</h1>

<?php if(session('success')): ?><div style="background:var(--green-pale);border:1px solid var(--green-light);color:var(--green);padding:12px 16px;border-radius:10px;margin-bottom:20px"><?php echo e(session('success')); ?></div><?php endif; ?>

<div class="admin-card">
    <?php if($returns->isEmpty()): ?>
        <p style="color:var(--muted);text-align:center;padding:40px">No return requests yet.</p>
    <?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ret): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><a href="<?php echo e(route('admin.orders.show', $ret->order_id)); ?>" style="color:var(--green);font-weight:600">#<?php echo e(str_pad($ret->order_id,6,'0',STR_PAD_LEFT)); ?></a></td>
            <td><?php echo e($ret->user->name); ?><br><small style="color:var(--muted)"><?php echo e($ret->user->email); ?></small></td>
            <td><?php echo e($ret->reason); ?></td>
            <td><?php echo e($ret->created_at->format('M d, Y')); ?></td>
            <td><span style="color:<?php echo e($ret->statusColor()); ?>;font-weight:600;font-size:.82rem"><?php echo e($ret->statusLabel()); ?></span></td>
            <td>
                <form method="POST" action="<?php echo e(route('admin.returns.update', $ret->id)); ?>" style="display:flex;gap:6px;align-items:center">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <select name="status" class="form-control" style="font-size:.8rem;padding:5px 8px">
                        <?php $__currentLoopData = ['pending','approved','rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e($ret->status===$s?'selected':''); ?>><?php echo e(ucfirst($s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="margin-top:20px"><?php echo e($returns->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/returns/index.blade.php ENDPATH**/ ?>