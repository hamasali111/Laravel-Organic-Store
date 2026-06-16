<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed — Organic Store</title>
<style>
body{margin:0;padding:0;background:#f0faf2;font-family:'Helvetica Neue',Arial,sans-serif;color:#1a2e1a}
.wrapper{max-width:580px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(45,106,79,.12)}
.header{background:#2d6a4f;padding:36px 40px;text-align:center}
.header h1{margin:0;color:#fff;font-size:1.6rem;letter-spacing:-.02em}
.header p{margin:8px 0 0;color:rgba(255,255,255,.8);font-size:.9rem}
.body{padding:36px 40px}
.order-id{background:#f0faf2;border:1px solid #d1e8d1;border-radius:10px;padding:16px 20px;text-align:center;margin-bottom:28px}
.order-id .num{font-size:1.4rem;font-weight:700;color:#2d6a4f}
.order-id .lbl{font-size:.78rem;color:#5a7a5a;text-transform:uppercase;letter-spacing:.06em}
h2{font-size:1rem;color:#2d6a4f;margin:0 0 14px}
table.items{width:100%;border-collapse:collapse;margin-bottom:20px}
table.items th{text-align:left;font-size:.74rem;text-transform:uppercase;color:#5a7a5a;padding:6px 0;border-bottom:2px solid #d1e8d1}
table.items td{padding:10px 0;border-bottom:1px solid #f0faf2;font-size:.88rem}
table.items td:last-child{text-align:right;font-weight:600}
.totals{margin-top:4px}
.total-row{display:flex;justify-content:space-between;font-size:.88rem;padding:5px 0}
.total-row.grand{font-size:1.05rem;font-weight:700;color:#2d6a4f;border-top:2px solid #d1e8d1;margin-top:6px;padding-top:10px}
.ship-box{background:#f0faf2;border-radius:10px;padding:18px 20px;margin-top:24px;font-size:.88rem;line-height:1.7}
.track-btn{display:block;text-align:center;margin:28px 0;background:#2d6a4f;color:#fff;padding:14px 28px;border-radius:50px;font-weight:600;font-size:.95rem;text-decoration:none}
.footer{background:#f5f8f5;padding:20px 40px;text-align:center;font-size:.78rem;color:#5a7a5a;border-top:1px solid #d1e8d1}
</style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🌿 Order Confirmed!</h1>
        <p>Thank you for shopping with Organic Store</p>
    </div>
    <div class="body">
        <p style="margin:0 0 24px;font-size:.95rem;color:#1a2e1a">
            Hi <strong><?php echo e($order->shipping_name); ?></strong>, your organic order has been placed successfully.
            We'll get it ready for you soon!
        </p>

        <div class="order-id">
            <div class="lbl">Order Number</div>
            <div class="num">#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></div>
        </div>

        <h2>Items Ordered</h2>
        <table class="items">
            <thead>
                <tr><th>Product</th><th>Qty</th><th style="text-align:right">Price</th></tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product->name ?? 'Product'); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td>PKR <?php echo e(number_format($item->price * $item->quantity, 0)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="totals">
            <?php if($order->discount > 0): ?>
            <div class="total-row">
                <span>Subtotal</span>
                <span>PKR <?php echo e(number_format($order->total + $order->discount, 0)); ?></span>
            </div>
            <div class="total-row" style="color:#e9a825">
                <span>Discount (<?php echo e($order->coupon_code); ?>)</span>
                <span>−PKR <?php echo e(number_format($order->discount, 0)); ?></span>
            </div>
            <?php endif; ?>
            <div class="total-row grand">
                <span>Total Paid</span>
                <span>PKR <?php echo e(number_format($order->total, 0)); ?></span>
            </div>
        </div>

        <div class="ship-box">
            <strong>📦 Shipping To:</strong><br>
            <?php echo e($order->shipping_name); ?><br>
            <?php echo e($order->shipping_address); ?><br>
            <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_zip); ?>

        </div>

        <a href="<?php echo e(url('/track-order')); ?>" class="track-btn">🚚 Track Your Order</a>

        <p style="font-size:.84rem;color:#5a7a5a;text-align:center;margin:0">
            Estimated delivery: <strong>2–5 business days</strong><br>
            Questions? Reply to this email and we'll help.
        </p>
    </div>
    <div class="footer">
        &copy; <?php echo e(date('Y')); ?> Organic Store &bull; Fresh. Natural. Delivered.
    </div>
</div>
</body>
</html>
<?php /**PATH C:\Users\PMLS\Downloads\Organic_Hamas_fixed\hamas organic store\resources\views/emails/order_confirmation.blade.php ENDPATH**/ ?>