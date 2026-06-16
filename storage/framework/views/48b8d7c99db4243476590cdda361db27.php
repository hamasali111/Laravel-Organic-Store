<?php $__env->startSection('title', $product->name . ' — Organic_store'); ?>
<?php $__env->startPush('styles'); ?>
<style>
    .product-detail { max-width:1200px; margin:0 auto; padding:40px 24px; }
    .product-layout { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start; }
    .product-image-wrap { border-radius:20px; overflow:hidden; box-shadow:var(--shadow-md); aspect-ratio:1; }
    .product-image-wrap img { width:100%; height:100%; object-fit:cover; }
    .product-info h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; margin-bottom:12px; }
    .product-meta { display:flex; gap:12px; align-items:center; margin-bottom:20px; flex-wrap:wrap; }
    .product-description { font-size:.95rem; color:var(--muted); line-height:1.75; margin-bottom:24px; }
    .product-price-big { font-size:2.2rem; font-weight:700; color:var(--green); margin-bottom:8px; }
    .product-weight { font-size:.85rem; color:var(--muted); margin-bottom:24px; }
    .stock-badge { display:inline-block; padding:4px 12px; border-radius:50px; font-size:.8rem; font-weight:600; }
    .in-stock { background:var(--green-pale); color:var(--green); }
    .out-stock { background:#fde8e8; color:var(--red); }
    .add-form { display:flex; gap:12px; align-items:center; margin-bottom:16px; flex-wrap:wrap; }
    .qty-input { width:80px; padding:10px 14px; border:1px solid var(--border); border-radius:50px; text-align:center; font-size:1rem; }
    .divider { border:none; border-top:1px solid var(--border); margin:28px 0; }
    .product-attrs { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .attr-item { background:var(--green-xpale); border-radius:10px; padding:14px 16px; }
    .attr-label { font-size:.72rem; text-transform:uppercase; letter-spacing:.07em; color:var(--muted); font-weight:600; margin-bottom:4px; }
    .attr-val { font-size:.92rem; font-weight:600; color:var(--text); }
    .related-section { margin-top:60px; }
    .reviews-section { margin-top:60px; }
    .review-card { background:var(--white); border:1px solid var(--border); border-radius:var(--radius); padding:20px; margin-bottom:14px; }
    .review-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px; }
    .review-author { font-weight:600; font-size:.9rem; }
    .review-date { font-size:.76rem; color:var(--muted); }
    .review-stars { color:#e9a825; font-size:1rem; margin-bottom:6px; }
    .review-title { font-weight:600; font-size:.92rem; margin-bottom:4px; }
    .review-body { font-size:.87rem; color:var(--muted); line-height:1.6; }
    .review-form { background:var(--green-xpale); border-radius:var(--radius); padding:24px; }
    .star-rating { display:flex; gap:6px; margin-bottom:14px; flex-direction:row-reverse; justify-content:flex-end; }
    .star-rating input { display:none; }
    .star-rating label { font-size:1.6rem; cursor:pointer; color:#ccc; transition:color .1s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:#e9a825; }
    @media(max-width:768px) { .product-layout { grid-template-columns:1fr; } }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="breadcrumb">
    <a href="<?php echo e(route('home')); ?>">Home</a><span>›</span>
    <a href="<?php echo e(route('shop')); ?>">Shop</a><span>›</span>
    <a href="<?php echo e(route('shop.category', $product->category->slug)); ?>"><?php echo e($product->category->name); ?></a><span>›</span>
    <?php echo e($product->name); ?>

</div>

<div class="product-detail">
    <div class="product-layout">
        <div class="product-image-wrap">
            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>"
                 onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
        </div>

        <div class="product-info">
            <div class="product-meta">
                <a href="<?php echo e(route('shop.category', $product->category->slug)); ?>" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;color:var(--green-l);font-weight:600;">
                    <?php echo e($product->category->name); ?>

                </a>
                <?php if($product->is_organic): ?><span class="organic-badge">🌱 Certified Organic</span><?php endif; ?>
                <?php if($product->is_featured): ?><span style="background:#fef3c7;color:#92400e;font-size:.7rem;font-weight:600;padding:2px 8px;border-radius:50px;">⭐ Featured</span><?php endif; ?>
            </div>

            <h1><?php echo e($product->name); ?></h1>

            <?php $avg = $product->avgRating(); $reviewCount = $product->reviews()->count(); ?>
            <?php if($reviewCount > 0): ?>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px">
                <div class="review-stars">
                    <?php for($i=1;$i<=5;$i++): ?><?php echo e($i <= round($avg) ? '★' : '☆'); ?><?php endfor; ?>
                </div>
                <span style="font-size:.84rem;color:var(--muted)"><?php echo e($avg); ?> (<?php echo e($reviewCount); ?> review<?php echo e($reviewCount>1?'s':''); ?>)</span>
            </div>
            <?php endif; ?>

            <div class="product-price-big">PKR <?php echo e(number_format($product->price, 0)); ?></div>
            <?php if($product->weight): ?><div class="product-weight">Package: <?php echo e($product->weight); ?></div><?php endif; ?>

            <p class="product-description"><?php echo e($product->description); ?></p>

            <?php if($product->stock > 0): ?>
                <span class="stock-badge in-stock">✓ In Stock (<?php echo e($product->stock); ?> available)</span>
            <?php else: ?>
                <span class="stock-badge out-stock">Out of Stock</span>
            <?php endif; ?>

            <hr class="divider">

            <?php if($product->stock > 0): ?>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="add-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>" class="qty-input">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;font-size:1rem;padding:13px 28px">
                    🛒 Add to Cart
                </button>
            </form>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
            <form action="<?php echo e(route('wishlist.toggle')); ?>" method="POST" style="margin-bottom:20px">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <?php $inWishlist = auth()->user()->wishlists()->where('product_id',$product->id)->exists(); ?>
                <button type="submit" class="btn btn-outline" style="width:100%;justify-content:center">
                    <?php echo e($inWishlist ? '💚 In Wishlist — Remove' : '🤍 Add to Wishlist'); ?>

                </button>
            </form>
            <?php endif; ?>

            <div class="product-attrs">
                <div class="attr-item"><div class="attr-label">Category</div><div class="attr-val"><?php echo e($product->category->name); ?></div></div>
                <?php if($product->weight): ?><div class="attr-item"><div class="attr-label">Weight</div><div class="attr-val"><?php echo e($product->weight); ?></div></div><?php endif; ?>
                <div class="attr-item"><div class="attr-label">Organic</div><div class="attr-val"><?php echo e($product->is_organic ? 'Yes, Certified' : 'No'); ?></div></div>
                <div class="attr-item"><div class="attr-label">Availability</div><div class="attr-val"><?php echo e($product->stock > 0 ? 'In Stock' : 'Out of Stock'); ?></div></div>
            </div>
        </div>
    </div>

    
    <div class="reviews-section">
        <h2 class="section-title">Customer Reviews</h2>
        <?php if($product->reviews->isEmpty()): ?>
        <p style="color:var(--muted);margin-bottom:24px">No reviews yet. Be the first!</p>
        <?php else: ?>
        <div style="margin-bottom:28px">
            <?php $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="review-card">
                <div class="review-header">
                    <div>
                        <div class="review-author"><?php echo e($review->user->name); ?></div>
                        <div class="review-date"><?php echo e($review->created_at->format('M d, Y')); ?></div>
                    </div>
                    <?php if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->is_admin)): ?>
                    <form method="POST" action="<?php echo e(route('reviews.destroy', $review->id)); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger" style="font-size:.72rem;padding:3px 9px">Delete</button>
                    </form>
                    <?php endif; ?>
                </div>
                <div class="review-stars">
                    <?php for($i=1;$i<=5;$i++): ?><?php echo e($i <= $review->rating ? '★' : '☆'); ?><?php endfor; ?>
                </div>
                <?php if($review->title): ?><div class="review-title"><?php echo e($review->title); ?></div><?php endif; ?>
                <?php if($review->body): ?><div class="review-body"><?php echo e($review->body); ?></div><?php endif; ?>
                <?php if($review->photo): ?>
                <div style="margin-top:10px">
                    <img src="<?php echo e($review->photo); ?>" alt="Review photo" style="max-width:200px;max-height:200px;border-radius:8px;border:1px solid var(--border);object-fit:cover;cursor:pointer" onclick="window.open(this.src)">
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
        <div class="review-form">
            <h3 style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:16px">Write a Review</h3>
            <form method="POST" action="<?php echo e(route('reviews.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <div style="margin-bottom:14px">
                    <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:6px">Rating *</label>
                    <div class="star-rating">
                        <?php for($i=5;$i>=1;$i--): ?>
                        <input type="radio" name="rating" id="star<?php echo e($i); ?>" value="<?php echo e($i); ?>" <?php echo e(old('rating')==$i?'checked':''); ?>>
                        <label for="star<?php echo e($i); ?>" title="<?php echo e($i); ?> star<?php echo e($i>1?'s':''); ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Review Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Summarize your experience" value="<?php echo e(old('title')); ?>">
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label">Your Review</label>
                    <textarea name="body" class="form-control" rows="3" placeholder="Share what you think about this product..."><?php echo e(old('body')); ?></textarea>
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label class="form-label">📷 Add a Photo (optional)</label>
                    <input type="file" name="review_photo" accept="image/*" class="form-control" style="padding:6px">
                    <div style="font-size:.76rem;color:var(--muted);margin-top:4px">JPG, PNG or WEBP — max 4MB</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
        <?php else: ?>
        <p style="color:var(--muted);font-size:.9rem">
            <a href="<?php echo e(route('login')); ?>" style="color:var(--green);font-weight:600">Sign in</a> to write a review.
        </p>
        <?php endif; ?>
    </div>

    <?php if($related->isNotEmpty()): ?>
    <div class="related-section">
        <h2 class="section-title">You Might Also Like</h2>
        <div class="products-grid" style="margin-top:24px">
            <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-card">
                <a href="<?php echo e(route('product.show', $rel->slug)); ?>">
                    <img src="<?php echo e($rel->image_url); ?>" alt="<?php echo e($rel->name); ?>" loading="lazy"
                         onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80'">
                </a>
                <div class="product-card-body">
                    <div class="product-card-cat"><?php echo e($rel->category->name); ?></div>
                    <a href="<?php echo e(route('product.show', $rel->slug)); ?>">
                        <div class="product-card-name"><?php echo e($rel->name); ?></div>
                    </a>
                    <div class="product-card-desc"><?php echo e($rel->description); ?></div>
                    <div class="product-card-footer">
                        <span class="product-price">PKR <?php echo e(number_format($rel->price, 0)); ?></span>
                        <?php if($rel->is_organic): ?><span class="organic-badge">Organic</span><?php endif; ?>
                    </div>
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" style="margin-top:12px">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($rel->id); ?>">
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Add to Cart</button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/shop/show.blade.php ENDPATH**/ ?>