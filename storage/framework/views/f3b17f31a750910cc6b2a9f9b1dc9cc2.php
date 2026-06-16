<?php $__env->startSection('title', 'Categories — Admin'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">
        Categories
    </h1>

    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-primary">
        + Add Category
    </a>
</div>

<?php if(session('success')): ?>
    <div style="
        background:#e6f4ea;
        color:#2d6a4f;
        padding:12px 16px;
        border-radius:8px;
        margin-bottom:16px;
        font-size:.87rem">
        ✅ <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="admin-card">

    <table class="data-table">

        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                
                <td>
                    <img
                        src="<?php echo e($cat->image_url); ?>"
                        alt="<?php echo e($cat->name); ?>"
                        style="
                            width:48px;
                            height:48px;
                            border-radius:8px;
                            object-fit:cover;
                        "
                        onerror="
                            this.style.display='none';
                            this.nextElementSibling.style.display='flex';
                        "
                    >
                    <div style="
                        display:none;
                        width:48px;
                        height:48px;
                        background:var(--green-pale);
                        border-radius:8px;
                        align-items:center;
                        justify-content:center;
                    ">
                        🌿
                    </div>
                </td>

                
                <td>
                    <strong><?php echo e($cat->name); ?></strong>
                </td>

                
                <td style="color:var(--muted);font-size:.82rem">
                    <?php echo e($cat->slug); ?>

                </td>

                
                <td>
                    <?php echo e($cat->products_count); ?>

                </td>

                
                <td>

                    <div style="display:flex;gap:6px">

                        <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>"
                           class="btn btn-sm btn-outline">
                            Edit
                        </a>

                        <form method="POST"
                              action="<?php echo e(route('admin.categories.destroy', $cat->id)); ?>"
                              onsubmit="return confirm('Delete this category?')">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit" class="btn btn-sm btn-danger">
                                Delete
                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>
                <td colspan="5"
                    style="
                        text-align:center;
                        padding:32px;
                        color:var(--muted)
                    ">

                    No categories yet.

                    <a href="<?php echo e(route('admin.categories.create')); ?>">
                        Add one
                    </a>.

                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

    <div style="margin-top:20px">
        <?php echo e($categories->links()); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>