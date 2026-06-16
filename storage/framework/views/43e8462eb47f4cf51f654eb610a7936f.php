<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #fff;
        }

        .page {
            padding: 40px 48px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #2d6a4f;
            padding-bottom: 24px;
            margin-bottom: 28px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 700;
            color: #2d6a4f;
        }

        .logo-sub {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }

        .invoice-meta {
            text-align: right;
        }

        .invoice-meta h2 {
            font-size: 20px;
            color: #2d6a4f;
            font-weight: 700;
        }

        .invoice-meta p {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }

        .grid2 {
            display: table;
            width: 100%;
            margin-bottom: 28px;
        }

        .col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .col h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #888;
            margin-bottom: 8px;
        }

        .col p {
            font-size: 13px;
            line-height: 1.7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead th {
            background: #2d6a4f;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
        }

        tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e8e8e8;
            font-size: 12.5px;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .totals-table {
            width: auto;
            margin-left: auto;
            min-width: 280px;
        }

        .totals-table td {
            padding: 6px 12px;
            font-size: 13px;
        }

        .totals-table .grand-total td {
            font-size: 15px;
            font-weight: 700;
            color: #2d6a4f;
            border-top: 2px solid #2d6a4f;
            padding-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        .status-confirmed {
            background: #d8f3dc;
            color: #2d6a4f;
        }

        .status-shipped {
            background: #ede7f6;
            color: #5e35b1;
        }

        .status-delivered {
            background: #e8f5e9;
            color: #27ae60;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <div>
                <div class="logo-text"> Organic Store</div>
                <div class="logo-sub">Pure. Natural. Nourishing.</div>
                <div style="margin-top:10px;font-size:11px;color:#666">
                    Email: support@organicstore.com<br>
                    WhatsApp: +92 303-2144809
                </div>
            </div>
            <div class="invoice-meta">
                <h2>INVOICE</h2>
                <p>#<?php echo e(str_pad($order->id, 6, '0', STR_PAD_LEFT)); ?></p>
                <p style="margin-top:6px">Date: <?php echo e($order->created_at->format('M d, Y')); ?></p>
                <p>
                    <span class="badge status-<?php echo e($order->status); ?>"><?php echo e($order->statusLabel()); ?></span>
                </p>
            </div>
        </div>

        <div class="grid2">
            <div class="col" style="padding-right:24px">
                <h4>Bill To</h4>
                <p>
                    <strong><?php echo e($order->shipping_name); ?></strong><br>
                    <?php echo e($order->shipping_address); ?><br>
                    <?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_zip); ?><br>
                    <?php echo e($order->shipping_email); ?>

                    <?php if($order->shipping_phone): ?>
                        <br><?php echo e($order->shipping_phone); ?>

                    <?php endif; ?>
                </p>
            </div>
            <div class="col">
                <h4>Payment</h4>
                <p>
                    <strong>Method:</strong> <?php echo e($order->paymentMethodLabel()); ?><br>
                    <strong>Status:</strong> <?php echo e($order->paymentStatusLabel()); ?><br>
                    <?php if($order->tracking_number): ?>
                        <strong>Tracking #:</strong> <?php echo e($order->tracking_number); ?><br>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td>
                            <strong><?php echo e($item->product->name); ?></strong>
                            <?php if($item->product->is_organic): ?>
                                <br><span style="font-size:11px;color:#2d6a4f">🌱 Certified Organic</span>
                            <?php endif; ?>
                        </td>
                        <td>PKR <?php echo e(number_format($item->price, 0)); ?></td>
                        <td><?php echo e($item->quantity); ?></td>
                        <td style="text-align:right;font-weight:600">PKR
                            <?php echo e(number_format($item->price * $item->quantity, 0)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <table class="totals-table">
            <tr>
                <td style="color:#666">Subtotal</td>
                <td style="text-align:right">PKR
                    <?php echo e(number_format($order->total - ($order->shipping_fee ?? 0) + ($order->discount ?? 0), 0)); ?></td>
            </tr>
            <?php if($order->discount > 0): ?>
                <tr>
                    <td style="color:#2d6a4f">Discount (<?php echo e($order->coupon_code); ?>)</td>
                    <td style="text-align:right;color:#2d6a4f">-PKR <?php echo e(number_format($order->discount, 0)); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td style="color:#666">Shipping</td>
                <td style="text-align:right">
                    <?php echo e(($order->shipping_fee ?? 0) == 0 ? 'Free' : 'PKR ' . number_format($order->shipping_fee, 0)); ?>

                </td>
            </tr>
            <tr class="grand-total">
                <td>Grand Total</td>
                <td style="text-align:right">PKR <?php echo e(number_format($order->total, 0)); ?></td>
            </tr>
        </table>

        <?php if($order->notes): ?>
            <div
                style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-top:20px;font-size:12px">
                <strong>Order Notes:</strong> <?php echo e($order->notes); ?>

            </div>
        <?php endif; ?>

        <div class="footer">
            <p>Thank you for shopping with Organic Store! </p>
            <p style="margin-top:4px">This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\PMLS\Organic Hamas\resources\views/orders/invoice.blade.php ENDPATH**/ ?>