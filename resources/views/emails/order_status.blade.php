<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Update — Organic Store</title>
<style>
body{margin:0;padding:0;background:#f0faf2;font-family:'Helvetica Neue',Arial,sans-serif;color:#1a2e1a}
.wrapper{max-width:580px;margin:40px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(45,106,79,.12)}
.header{padding:36px 40px;text-align:center}
.body{padding:36px 40px}
.status-badge{display:inline-block;padding:8px 22px;border-radius:50px;font-size:1rem;font-weight:700;margin-bottom:20px}
.steps{display:flex;justify-content:space-between;margin:28px 0;position:relative}
.steps::before{content:'';position:absolute;top:18px;left:0;right:0;height:2px;background:#d1e8d1;z-index:0}
.step{text-align:center;flex:1;position:relative;z-index:1}
.step-dot{width:36px;height:36px;border-radius:50%;margin:0 auto 6px;display:flex;align-items:center;justify-content:center;font-size:.85rem;font-weight:700;background:#d1e8d1;color:#5a7a5a}
.step-dot.done{background:#2d6a4f;color:#fff}
.step-dot.current{background:#e9a825;color:#fff}
.step-lbl{font-size:.7rem;color:#5a7a5a;font-weight:600}
.step-lbl.done{color:#2d6a4f}
.step-lbl.current{color:#e9a825}
.info-box{background:#f0faf2;border-radius:10px;padding:18px 20px;font-size:.88rem;margin-top:20px}
.track-btn{display:block;text-align:center;margin:24px 0 0;background:#2d6a4f;color:#fff;padding:14px 28px;border-radius:50px;font-weight:600;font-size:.95rem;text-decoration:none}
.footer{background:#f5f8f5;padding:20px 40px;text-align:center;font-size:.78rem;color:#5a7a5a;border-top:1px solid #d1e8d1}
</style>
</head>
<body>
<div class="wrapper">
    @php
        $statusColor = match($order->status) {
            'confirmed'  => ['bg'=>'#2d6a4f','txt'=>'#fff','label'=>'✅ Confirmed'],
            'processing' => ['bg'=>'#1d6fa4','txt'=>'#fff','label'=>'⚙️ Processing'],
            'shipped'    => ['bg'=>'#e9a825','txt'=>'#fff','label'=>'🚚 Shipped'],
            'delivered'  => ['bg'=>'#27ae60','txt'=>'#fff','label'=>'🎉 Delivered'],
            'cancelled'  => ['bg'=>'#c0392b','txt'=>'#fff','label'=>'❌ Cancelled'],
            default      => ['bg'=>'#5a7a5a','txt'=>'#fff','label'=>ucfirst($order->status)],
        };
        $statuses = ['pending','confirmed','processing','shipped','delivered'];
        $currentIdx = array_search($order->status, $statuses);
    @endphp
    <div class="header" style="background:{{ $statusColor['bg'] }}">
        <h1 style="margin:0;color:{{ $statusColor['txt'] }};font-size:1.5rem">Order Update</h1>
        <p style="margin:8px 0 0;color:rgba(255,255,255,.85);font-size:.9rem">
            Your order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} status has changed
        </p>
    </div>
    <div class="body">
        <p style="margin:0 0 8px;font-size:.95rem">Hi <strong>{{ $order->shipping_name }}</strong>,</p>
        <p style="margin:0 0 20px;font-size:.88rem;color:#5a7a5a">Here's the latest update on your order:</p>

        <div style="text-align:center">
            <span class="status-badge" style="background:{{ $statusColor['bg'] }};color:{{ $statusColor['txt'] }}">
                {{ $statusColor['label'] }}
            </span>
        </div>

        @if($order->status !== 'cancelled')
        <div class="steps">
            @foreach($statuses as $i => $s)
            @php $cls = $i < $currentIdx ? 'done' : ($i === $currentIdx ? 'current' : ''); @endphp
            <div class="step">
                <div class="step-dot {{ $cls }}">{{ $i < $currentIdx ? '✓' : ($i + 1) }}</div>
                <div class="step-lbl {{ $cls }}">{{ ucfirst($s) }}</div>
            </div>
            @endforeach
        </div>
        @endif

        @if($order->tracking_number)
        <div class="info-box">
            <strong>📦 Tracking Number:</strong> {{ $order->tracking_number }}<br>
            <span style="font-size:.8rem;color:#5a7a5a">Use this number to track your parcel with the courier.</span>
        </div>
        @endif

        @if($order->status === 'shipped')
        <div class="info-box" style="margin-top:12px;background:#fff8e1;border:1px solid #e9a825">
            🚚 <strong>Your order is on the way!</strong> Estimated delivery in 1–3 business days.
        </div>
        @endif

        @if($order->status === 'delivered')
        <div class="info-box" style="margin-top:12px;background:#d8f3dc">
            🎉 <strong>Your order has been delivered!</strong> We hope you enjoy your organic products.
        </div>
        @endif

        <a href="{{ url('/track-order') }}" class="track-btn">🔍 Track Your Order</a>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Organic Store &bull; Fresh. Natural. Delivered.
    </div>
</div>
</body>
</html>
