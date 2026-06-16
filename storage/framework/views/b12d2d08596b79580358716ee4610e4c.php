<?php $__env->startSection('title', isset($product) ? 'Edit Product' : 'Add Product'); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .image-preview-wrap {
            position: relative;
            display: inline-block;
        }

        .image-preview-wrap img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--border);
        }

        .upload-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }

        .upload-tab {
            padding: 7px 18px;
            font-size: .82rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: var(--bg);
            color: var(--muted);
        }

        .upload-tab.active {
            background: var(--green);
            color: white;
        }

        .upload-panel {
            display: none;
        }

        .upload-panel.active {
            display: block;
        }

        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s;
        }

        .drop-zone:hover,
        .drop-zone.drag {
            border-color: var(--green);
            background: var(--green-xpale);
        }

        .drop-zone input[type=file] {
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">
            <?php echo e(isset($product) ? 'Edit Product' : 'Add Product'); ?></h1>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-gray">← Back</a>
    </div>
    <div class="admin-card" style="max-width:720px">
        <form method="POST"
            action="<?php echo e(isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store')); ?>"
            enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if(isset($product)): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control"
                        value="<?php echo e(old('name', $product->name ?? '')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>"
                                <?php echo e(old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-control" rows="4" required><?php echo e(old('description', $product->description ?? '')); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Price (PKR) *</label>
                    <input type="number" name="price" step="1" class="form-control"
                        value="<?php echo e(old('price', $product->price ?? '')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control"
                        value="<?php echo e(old('stock', $product->stock ?? 0)); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Product Image</label>

                <?php
                    $existingProductImage = isset($product) && $product->image ? $product->image_url : null;
                    $isStoredProductImage = isset($product) && $product->image && str_starts_with($product->image, '/storage/');
                ?>

                <?php if($existingProductImage): ?>
                    <div class="image-preview-wrap" style="margin-bottom:12px">
                        <img src="<?php echo e($existingProductImage); ?>" alt="Current image" id="img-preview"
                             onerror="this.style.display='none'">
                        <div style="font-size:.76rem;color:var(--muted);margin-top:4px">Current image</div>
                    </div>
                <?php else: ?>
                    <img src="" alt="" id="img-preview"
                        style="display:none;width:120px;height:120px;object-fit:cover;border-radius:10px;border:2px solid var(--border);margin-bottom:12px">
                <?php endif; ?>

                <div class="upload-tabs">
                    <button type="button" class="upload-tab active" onclick="switchTab('upload')">📁 Upload File</button>
                    <button type="button" class="upload-tab" onclick="switchTab('url')">🔗 Image URL</button>
                </div>

                <div class="upload-panel active" id="tab-upload">
                    <div class="drop-zone" onclick="document.getElementById('image_upload').click()" id="drop-zone">
                        <input type="file" name="image_upload" id="image_upload"
                            accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewFile(this)">
                        <div id="drop-zone-content">
                            <div style="font-size:2rem;margin-bottom:8px">🖼️</div>
                            <div style="font-size:.88rem;font-weight:600;color:var(--text)">Click to upload or drag & drop</div>
                            <div style="font-size:.78rem;color:var(--muted);margin-top:4px">JPG, PNG, WebP — max 4MB</div>
                        </div>
                    </div>
                </div>

                <div class="upload-panel" id="tab-url">
                    <input type="url" name="image" id="image-url-input" class="form-control"
                        value="<?php echo e(old('image', !$isStoredProductImage ? ($product->image ?? '') : '')); ?>"
                        placeholder="https://example.com/image.jpg"
                        oninput="previewUrl(this)">
                    <div style="font-size:.76rem;color:var(--muted);margin-top:4px">Paste a direct image URL (leave blank to keep current image)</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Weight / Package Size</label>
                <input type="text" name="weight" class="form-control"
                    value="<?php echo e(old('weight', $product->weight ?? '')); ?>" placeholder="e.g. 500g, 1kg, 12 pack">
            </div>

            <div style="display:flex;gap:24px;margin-bottom:20px">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.88rem">
                    <input type="checkbox" name="is_featured" value="1"
                        <?php echo e(old('is_featured', $product->is_featured ?? false) ? 'checked' : ''); ?>>
                    ⭐ Featured Product
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.88rem">
                    <input type="checkbox" name="is_organic" value="1"
                        <?php echo e(old('is_organic', $product->is_organic ?? true) ? 'checked' : ''); ?>>
                    🌱 Certified Organic
                </label>
            </div>

            <?php if($errors->any()): ?>
                <div style="background:#fde8e8;color:var(--red);padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>• <?php echo e($e); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary"><?php echo e(isset($product) ? 'Update Product' : 'Create Product'); ?></button>
        </form>
    </div>

    <script>
        function switchTab(tab) {
            document.querySelectorAll('.upload-tab').forEach((t, i) => t.classList.toggle('active', (i === 0 && tab === 'upload') || (i === 1 && tab === 'url')));
            document.getElementById('tab-upload').classList.toggle('active', tab === 'upload');
            document.getElementById('tab-url').classList.toggle('active', tab === 'url');
            if (tab === 'upload') {
                document.getElementById('image-url-input').value = '';
            } else {
                document.getElementById('image_upload').value = '';
                resetDropZone();
                previewUrl(document.getElementById('image-url-input'));
            }
        }

        function previewFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById('img-preview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
                document.getElementById('drop-zone-content').innerHTML =
                    '<div style="font-size:1.5rem">✅</div><div style="font-size:.85rem;font-weight:600;color:var(--green)">' +
                    input.files[0].name + '</div>';
            }
        }

        function previewUrl(input) {
            const img = document.getElementById('img-preview');
            if (input.value.trim()) {
                img.src = input.value.trim();
                img.style.display = 'block';
                img.onerror = () => { img.style.display = 'none'; };
                img.onload = () => { img.onerror = null; };
            } else {
                img.style.display = 'none';
                img.src = '';
            }
        }

        function resetDropZone() {
            document.getElementById('drop-zone-content').innerHTML =
                '<div style="font-size:2rem;margin-bottom:8px">🖼️</div>' +
                '<div style="font-size:.88rem;font-weight:600;color:var(--text)">Click to upload or drag & drop</div>' +
                '<div style="font-size:.78rem;color:var(--muted);margin-top:4px">JPG, PNG, WebP — max 4MB</div>';
        }

        const dz = document.getElementById('drop-zone');
        if (dz) {
            dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag'); });
            dz.addEventListener('dragleave', () => dz.classList.remove('drag'));
            dz.addEventListener('drop', e => {
                e.preventDefault();
                dz.classList.remove('drag');
                const fi = document.getElementById('image_upload');
                fi.files = e.dataTransfer.files;
                previewFile(fi);
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/admin/products/form.blade.php ENDPATH**/ ?>