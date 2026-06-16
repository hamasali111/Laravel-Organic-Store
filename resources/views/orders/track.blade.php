@extends('layouts.app')
@section('title', 'Track Your Order — Organic Store')
@push('styles')
<style>
.track-wrap{max-width:700px;margin:60px auto;padding:0 24px}
.track-hero{text-align:center;margin-bottom:40px}
.track-hero h1{font-family:'Playfair Display',serif;font-size:2.2rem;color:var(--green);margin-bottom:10px}
.track-hero p{color:var(--muted);font-size:.95rem}
.track-form-card{background:var(--white);border:1px solid var(--border);border-radius:20px;padding:36px;box-shadow:var(--shadow);margin-bottom:32px}
.track-form-card h2{font-family:'Playfair Display',serif;font-size:1.2rem;margin-bottom:20px;color:var(--text)}
.tracker-card{background:var(--white);border:1px solid var(--border);border-radius:20px;padding:36px;box-shadow:var(--shadow-md)}
.tracker-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:32px;flex-wrap:wrap;gap:12px}
.tracker-header h2{font-family:'Playfair Display',serif;font-size:1.3rem;margin:0;color:var(--text)}
.status-pill{display:inline-block;padding:6px 16px;border-radius:50px;font-size:.82rem;font-weight:700}
/* Stepper */
.stepper{display:flex;align-items:flex-start;justify-content:space-between;margin:0 0 36px;position:relative}
.stepper::before{content:'';position:absolute;top:22px;left:36px;right:36px;height:3px;background:var(--border);z-index:0}
.step{display:flex;flex-direction:column;align-items:center;gap:8px;position:relative;z-index:1;flex:1}
.step-circle{width:44px;height:44px;border-radius:50%;border:3px solid var(--border);background:var(--white);display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:var(--muted);transition:all .3s}
.step-circle.done{background:var(--green);border-color:var(--green);color:#fff}
.step-circle.active{background:#fff;border-color:var(--amber);color:var(--amber);box-shadow:0 0 0 4px rgba(233,168,37,.15)}
.step-line{position:absolute;top:22px;left:50%;right:-50%;height:3px;z-index:-1}
.step-label{font-size:.72rem;font-weight:600;color:var(--muted);text-align:center;max-width:64px}
.step-label.done{color:var(--green)}
.step-label.active{color:var(--amber)}
.step-date{font-size:.65rem;color:var(--muted);text-align:center;margin-top:2px}
/* Progress bar */
.progress-bar-wrap{background:var(--border);border-radius:50px;height:8px;margin-bottom:32px;overflow:hidden}
.progress-bar-fill{height:100%;background:linear-gradient(90deg,var(--green),#40916c);border-radius:50px;transition:width .6s ease}
.order-items-list{border-top:1px solid var(--border);padding-top:20px;margin-top:4px}
.oi-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)}
.oi-row img{width:48px;height:48px;border-radius:8px;object-fit:cover}
.tracking-num{background:var(--green-xpale);border:1px dashed var(--green);border-radius:10px;padding:14px 18px;margin-bottom:20px;font-size:.88rem}
</style>
@endpush

@section('content')
<div class="track-wrap">
    <div class="track-hero">
        <div style="font-size:3rem;margin-bottom:14px">📦</div>
        <h1>Track Your Order</h1>
        <p>Enter your order number and email address to get the latest status update.</p>
    </div>

    <div class="track-form-card">
        <h2>🔍 Look Up Order</h2>
        @if($errors->any())
        <div style="background:#fde8e8;color:var(--red);padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:.87rem">
            @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
        </div>
        @endif
        <form method="POST" action="{{ route('orders.track.search') }}">
            @csrf
            <div class="form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:600;margin-bottom:5px;color:var(--text)">Order Number</label>
                    <input type="text" name="order_id" class="form-control" placeholder="e.g. 000001" value="{{ old('order_id') }}" required style="padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.9rem;width:100%;background:var(--bg)">
                </div>
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:600;margin-bottom:5px;color:var(--text)">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@email.com" value="{{ old('email') }}" required style="padding:10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:.9rem;width:100%;background:var(--bg)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top:18px;width:100%;justify-content:center;padding:12px">Track Order →</button>
        </form>
    </div>

    @isset($order)
    @php
        $steps = [
            ['key'=>'pending',    'label'=>'Order Placed', 'icon'=>'🛒', 'date'=>$order->created_at],
            ['key'=>'confirmed',  'label'=>'Confirmed',    'icon'=>'✅', 'date'=>$order->updated_at && $order->status !== 'pending' ? $order->updated_at : null],
            ['key'=>'processing', 'label'=>'Processing',   'icon'=>'⚙️', 'date'=>null],
            ['key'=>'shipped',    'label'=>'Shipped',      'icon'=>'🚚', 'date'=>$order->shipped_at],
            ['key'=>'delivered',  'label'=>'Delivered',    'icon'=>'🎉', 'date'=>$order->delivered_at],
        ];
        $statusOrder = ['pending'=>0,'confirmed'=>1,'processing'=>2,'shipped'=>3,'delivered'=>4,'cancelled'=>-1];
        $currentStep = $statusOrder[$order->status] ?? 0;
        $progressPct = $order->status === 'cancelled' ? 0 : round(($currentStep / 4) * 100);
    @endphp

    <div class="tracker-card">
        <div class="tracker-header">
            <div>
                <h2>Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                <div style="font-size:.82rem;color:var(--muted);margin-top:4px">Placed {{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <span class="status-pill" style="background:{{ $order->statusColor() }}22;color:{{ $order->statusColor() }}">
                {{ $order->statusLabel() }}
            </span>
        </div>

        @if($order->status === 'cancelled')
        <div style="background:#fde8e8;color:var(--red);border-radius:12px;padding:18px;text-align:center;margin-bottom:24px;font-weight:600">
            ❌ This order was cancelled.
        </div>
        @else
        <div class="progress-bar-wrap">
            <div class="progress-bar-fill" style="width:{{ $progressPct }}%"></div>
        </div>

        <div class="stepper">
            @foreach($steps as $i => $step)
            @php
                $isDone    = $currentStep > $i;
                $isActive  = $currentStep === $i;
                $circleClass = $isDone ? 'done' : ($isActive ? 'active' : '');
                $labelClass  = $isDone ? 'done' : ($isActive ? 'active' : '');
            @endphp
            <div class="step">
                <div class="step-circle {{ $circleClass }}">{{ $isDone ? '✓' : $step['icon'] }}</div>
                <div class="step-label {{ $labelClass }}">{{ $step['label'] }}</div>
                @if($step['date'])
                <div class="step-date">{{ \Carbon\Carbon::parse($step['date'])->format('d M') }}</div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        @if($order->tracking_number)
        <div class="tracking-num">
            📦 <strong>Tracking Number:</strong> <span style="font-family:monospace;font-size:1rem;letter-spacing:.05em">{{ $order->tracking_number }}</span>
            <div style="font-size:.76rem;color:var(--muted);margin-top:4px">Use this number with your courier to track your parcel.</div>
        </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
            <div style="background:var(--bg);border-radius:12px;padding:16px;font-size:.85rem;line-height:1.7">
                <strong style="display:block;margin-bottom:6px;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--muted)">Shipping To</strong>
                {{ $order->shipping_name }}<br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_zip }}
            </div>
            <div style="background:var(--bg);border-radius:12px;padding:16px;font-size:.85rem;line-height:1.7">
                <strong style="display:block;margin-bottom:6px;font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--muted)">Payment</strong>
                <div>Total: <strong>PKR {{ number_format($order->total, 0) }}</strong></div>
                @if($order->discount > 0)
                <div style="color:var(--amber)">Saved: PKR {{ number_format($order->discount, 0) }}</div>
                @endif
                <div style="color:var(--green);font-weight:600;margin-top:4px">Cash on Delivery</div>
            </div>
        </div>

        <div class="order-items-list">
            <div style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:var(--muted);margin-bottom:8px">Items</div>
            @foreach($order->items as $item)
            <div class="oi-row">
                <img src="{{ $item->product->image ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=120&q=70' }}" alt="{{ $item->product->name ?? '' }}">
                <div style="flex:1">
                    <div style="font-weight:600;font-size:.88rem">{{ $item->product->name ?? 'Product' }}</div>
                    <div style="font-size:.78rem;color:var(--muted)">Qty: {{ $item->quantity }}</div>
                </div>
                <div style="font-weight:700;color:var(--green);font-size:.9rem">PKR {{ number_format($item->price * $item->quantity, 0) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endisset
</div>
@endsection
