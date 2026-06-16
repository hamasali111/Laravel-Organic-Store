<?php $__env->startSection('title', 'Checkout — Organic_store'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .checkout-layout {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 24px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 40px;
            align-items: start;
        }

        .form-section {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            margin-bottom: 24px;
        }

        .form-section h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: .83rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .9rem;
            font-family: inherit;
            background: var(--bg);
            transition: border-color .2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green-light);
            background: white;
        }

        .error-text {
            color: var(--red);
            font-size: .78rem;
            margin-top: 4px;
        }

        .order-summary {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            position: sticky;
            top: 88px;
        }

        .order-summary h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .order-item:last-of-type {
            border-bottom: none;
        }

        .order-item img {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .order-item-name {
            font-size: .88rem;
            font-weight: 600;
        }

        .order-item-meta {
            font-size: .78rem;
            color: var(--muted);
        }

        .order-item-price {
            font-size: .9rem;
            font-weight: 700;
            color: var(--green);
            margin-left: auto;
            flex-shrink: 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: .9rem;
            margin-bottom: 10px;
        }

        .summary-row.total {
            font-size: 1.1rem;
            font-weight: 700;
            border-top: 2px solid var(--border);
            padding-top: 14px;
            margin-top: 6px;
        }

        .payment-option {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .payment-option:has(input:checked) {
            border-color: var(--green);
            background: var(--green-pale);
        }

        .payment-option input {
            margin-top: 2px;
            accent-color: var(--green);
        }

        .payment-icon {
            font-size: 1.4rem;
        }

        .payment-label {
            font-weight: 600;
            font-size: .9rem;
        }

        .payment-desc {
            font-size: .78rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .payment-details-box {
            background: #f8fffe;
            border: 1px solid var(--green-light);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
            font-size: .88rem;
            line-height: 1.7;
        }

        .payment-details-box strong {
            color: var(--green);
        }

        @media(max-width:768px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Home</a> <span>›</span>
        <a href="<?php echo e(route('cart.index')); ?>">Cart</a> <span>›</span>
        Checkout
    </div>

    <div class="checkout-layout">
        <div>
            <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:28px">Checkout</h1>

            <form action="<?php echo e(route('checkout.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-section">
                    <h3>Contact Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control"
                                value="<?php echo e(old('name', auth()->user()->name ?? '')); ?>" placeholder="Ahmed Khan" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error-text"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo e(old('email', auth()->user()->email ?? '')); ?>" placeholder="ahmed@example.com"
                                required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error-text"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>"
                            placeholder="03XX-XXXXXXX">
                    </div>
                </div>

                <div class="form-section">
                    <h3>Shipping Address</h3>
                    <div class="form-group">
                        <label>Street Address *</label>
                        <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>"
                            placeholder="House 12, Block B, Street 5" required>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="error-text"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City *</label>
                            <input type="text" name="city" class="form-control" value="<?php echo e(old('city')); ?>"
                                placeholder="BahawlNagar" required>
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error-text"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label>ZIP / Postal Code *</label>
                            <input type="text" name="zip" class="form-control" value="<?php echo e(old('zip')); ?>"
                                placeholder="63100" required>
                            <?php $__errorArgs = ['zip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error-text"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Order Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Any special delivery instructions?"><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>

                
                <div class="form-section">
                    <h3>Payment Method</h3>

                    <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-text" style="margin-bottom:12px"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['payment_proof'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-text" style="margin-bottom:12px"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod"
                            <?php echo e(old('payment_method', 'cod') === 'cod' ? 'checked' : ''); ?>

                            onchange="togglePaymentDetails(this.value)">
                        <div class="payment-icon">🚚</div>
                        <div>
                            <div class="payment-label">Cash on Delivery</div>
                            <div class="payment-desc">Pay when your order arrives at your door</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="bank"
                            <?php echo e(old('payment_method') === 'bank' ? 'checked' : ''); ?> onchange="togglePaymentDetails(this.value)">
                        <div class="payment-icon">🏦</div>
                        <div>
                            <div class="payment-label">Bank Transfer</div>
                            <div class="payment-desc">Transfer to our bank account and upload proof</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="jazzcash"
                            <?php echo e(old('payment_method') === 'jazzcash' ? 'checked' : ''); ?>

                            onchange="togglePaymentDetails(this.value)">
                        <div class="payment-icon">📱</div>
                        <div>
                            <div class="payment-label">JazzCash</div>
                            <div class="payment-desc">Send to our JazzCash number and upload screenshot</div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="easypaisa"
                            <?php echo e(old('payment_method') === 'easypaisa' ? 'checked' : ''); ?>

                            onchange="togglePaymentDetails(this.value)">
                        <div class="payment-icon">💚</div>
                        <div>
                            <div class="payment-label">EasyPaisa</div>
                            <div class="payment-desc">Send to our EasyPaisa number and upload screenshot</div>
                        </div>
                    </label>

                    
                    <div id="payment-details-bank" class="payment-details-box" style="display:none;margin-top:14px">
                        <strong>Bank Transfer Details:</strong><br>
                        Bank: HBL Pakistan<br>
                        Account Title: <strong>Organic Store</strong><br>
                        Account Number: <strong>1234-5678-9012</strong><br>
                        IBAN: <strong>PK36HABB0000123456789012</strong><br>
                        <span style="color:var(--amber)">⚠ Upload your transfer screenshot below</span>
                    </div>
                    <div id="payment-details-jazzcash" class="payment-details-box" style="display:none;margin-top:14px">
                        <strong>JazzCash Details:</strong><br>
                        Mobile Number: <strong>0303-2144809</strong><br>
                        Account Name: <strong>Organic Store</strong><br>
                        <span style="color:var(--amber)">⚠ Send exact amount and upload screenshot below</span>
                    </div>
                    <div id="payment-details-easypaisa" class="payment-details-box" style="display:none;margin-top:14px">
                        <strong>EasyPaisa Details:</strong><br>
                        Mobile Number: <strong>0303-2144809</strong><br>
                        Account Name: <strong>Organic Store</strong><br>
                        <span style="color:var(--amber)">⚠ Send exact amount and upload screenshot below</span>
                    </div>

                    <div id="proof-upload-section" style="display:none;margin-top:16px">
                        <label style="display:block;font-size:.83rem;font-weight:600;margin-bottom:6px">Upload Payment
                            Screenshot *</label>
                        <input type="file" name="payment_proof" accept="image/*" class="form-control"
                            id="proof-input">
                        <div style="font-size:.76rem;color:var(--muted);margin-top:4px">JPG, PNG or WEBP — max 5MB</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"
                    style="width:100%;justify-content:center;font-size:1.05rem;padding:15px 28px">
                    Place Order — PKR <?php echo e(number_format($total + $shippingFee, 0)); ?>

                </button>
                <p style="text-align:center;font-size:.78rem;color:var(--muted);margin-top:12px">🔒 Secure order processing
                    &nbsp;|&nbsp;  Organic guarantee</p>
            </form>
        </div>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-item">
                    <img src="<?php echo e($item->product->image); ?>" alt="<?php echo e($item->product->name); ?>">
                    <div style="flex:1">
                        <div class="order-item-name"><?php echo e($item->product->name); ?></div>
                        <div class="order-item-meta">Qty: <?php echo e($item->quantity); ?></div>
                    </div>
                    <div class="order-item-price">PKR <?php echo e(number_format($item->product->price * $item->quantity, 0)); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="summary-row"><span>Subtotal</span><span>PKR <?php echo e(number_format($subtotal, 0)); ?></span></div>
            <?php if(isset($discount) && $discount > 0): ?>
                <div class="summary-row" style="color:var(--green)"><span>🎟 <?php echo e($coupon); ?></span><span>-PKR
                        <?php echo e(number_format($discount, 0)); ?></span></div>
            <?php endif; ?>
            <div class="summary-row">
                <span>Shipping</span>
                <span><?php echo e($shippingFee == 0 ? 'Free 🎉' : 'PKR ' . number_format($shippingFee, 0)); ?></span>
            </div>
            <?php if($shippingFee > 0): ?>
                <p
                    style="font-size:.76rem;color:var(--green);background:var(--green-pale);padding:7px 10px;border-radius:8px;margin-bottom:10px">
                    Add PKR <?php echo e(number_format(5000 - $total, 0)); ?> more for free shipping!
                </p>
            <?php endif; ?>
            <div class="summary-row total">
                <span>Total</span>
                <span>PKR <?php echo e(number_format($total + $shippingFee, 0)); ?></span>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function togglePaymentDetails(method) {
                ['bank', 'jazzcash', 'easypaisa'].forEach(m => {
                    document.getElementById('payment-details-' + m).style.display = 'none';
                });
                const proofSection = document.getElementById('proof-upload-section');
                if (method !== 'cod') {
                    document.getElementById('payment-details-' + method).style.display = 'block';
                    proofSection.style.display = 'block';
                    document.getElementById('proof-input').required = true;
                } else {
                    proofSection.style.display = 'none';
                    document.getElementById('proof-input').required = false;
                }
            }
            // Init on load
            document.addEventListener('DOMContentLoaded', function() {
                const checked = document.querySelector('input[name="payment_method"]:checked');
                if (checked) togglePaymentDetails(checked.value);
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/checkout/index.blade.php ENDPATH**/ ?>