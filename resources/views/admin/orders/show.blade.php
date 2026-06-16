@extends('layouts.admin')
@section('title', 'Order #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))
@push('styles')
    <style>
        .tracker-steps {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
            margin: 24px 0 32px
        }

        .tracker-steps::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 28px;
            right: 28px;
            height: 3px;
            background: var(--border);
            z-index: 0
        }

        .ts {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            position: relative;
            z-index: 1;
            flex: 1
        }

        .ts-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 700;
            color: var(--muted)
        }

        .ts-dot.done {
            background: var(--green);
            border-color: var(--green);
            color: #fff
        }

        .ts-dot.active {
            background: #fff;
            border-color: var(--amber);
            color: var(--amber);
            box-shadow: 0 0 0 4px rgba(233, 168, 37, .15)
        }

        .ts-label {
            font-size: .7rem;
            font-weight: 600;
            color: var(--muted);
            text-align: center
        }

        .ts-label.done {
            color: var(--green)
        }

        .ts-label.active {
            color: var(--amber)
        }

        .note-bubble {
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 8px;
            font-size: .88rem
        }

        .note-bubble.admin {
            background: #eef2ff;
            color: #2d3a8c
        }

        .note-bubble.customer {
            background: var(--green-pale);
            color: var(--text)
        }
    </style>
@endpush
@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:12px">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Order
            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
        </h1>
        <div style="display:flex;gap:10px">
            <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-outline btn-sm" target="_blank">⬇ Invoice
                PDF</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-gray">← Orders</a>
        </div>
    </div>

    @if (session('success'))
        <div
            style="background:var(--green-pale);border:1px solid var(--green-light);color:var(--green);padding:12px 16px;border-radius:10px;margin-bottom:20px">
            {{ session('success') }}</div>
    @endif

    {{-- Shipping Status Tracker --}}
    @if ($order->status !== 'cancelled')
        <div class="admin-card" style="margin-bottom:20px">
            <h3 style="font-family:'Playfair Display',serif;font-size:1rem;margin-bottom:0;color:var(--muted)">Shipping
                Progress</h3>
            @php
                $steps = [
                    ['key' => 'pending', 'icon' => '🛒', 'label' => 'Placed'],
                    ['key' => 'confirmed', 'icon' => '✅', 'label' => 'Confirmed'],
                    ['key' => 'processing', 'icon' => '⚙️', 'label' => 'Processing'],
                    ['key' => 'shipped', 'icon' => '🚚', 'label' => 'Shipped'],
                    ['key' => 'delivered', 'icon' => '🎉', 'label' => 'Delivered'],
                ];
                $statusIdx = ['pending' => 0, 'confirmed' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
                $cur = $statusIdx[$order->status] ?? 0;
            @endphp
            <div class="tracker-steps">
                @foreach ($steps as $i => $s)
                    @php $cls = $i < $cur ? 'done' : ($i === $cur ? 'active' : ''); @endphp
                    <div class="ts">
                        <div class="ts-dot {{ $cls }}">{{ $i < $cur ? '✓' : $s['icon'] }}</div>
                        <div class="ts-label {{ $cls }}">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 360px;gap:24px">
        <div>
            {{-- Items --}}
            <div class="admin-card" style="margin-bottom:20px">
                <h3
                    style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)">
                    Order Items</h3>
                @foreach ($order->items as $item)
                    <div
                        style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)">
                        <img src="{{ $item->product->image }}"
                            style="width:56px;height:56px;border-radius:8px;object-fit:cover">
                        <div style="flex:1">
                            <div style="font-weight:600;font-size:.9rem">{{ $item->product->name }}</div>
                            <div style="font-size:.78rem;color:var(--muted)">Qty: {{ $item->quantity }} × PKR
                                {{ number_format($item->price, 0) }}</div>
                        </div>
                        <div style="font-weight:700;color:var(--green)">PKR
                            {{ number_format($item->price * $item->quantity, 0) }}</div>
                    </div>
                @endforeach
                @if ($order->discount > 0)
                    <div
                        style="display:flex;justify-content:space-between;font-size:.88rem;padding:8px 0;color:var(--amber)">
                        <span>Discount ({{ $order->coupon_code }})</span><span>−PKR
                            {{ number_format($order->discount, 0) }}</span>
                    </div>
                @endif
                @if (isset($order->shipping_fee) && $order->shipping_fee > 0)
                    <div
                        style="display:flex;justify-content:space-between;font-size:.88rem;padding:4px 0;color:var(--muted)">
                        <span>Shipping</span><span>PKR {{ number_format($order->shipping_fee, 0) }}</span>
                    </div>
                @endif
                <div
                    style="margin-top:14px;padding-top:14px;border-top:2px solid var(--border);display:flex;justify-content:space-between;font-size:1rem;font-weight:700">
                    <span>Total</span><span>PKR {{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="admin-card" style="margin-bottom:20px">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">Shipping Info</h3>
                <div style="font-size:.9rem;line-height:1.8">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_zip }}<br>
                    {{ $order->shipping_email }}
                    @if ($order->shipping_phone)
                        <br>{{ $order->shipping_phone }}
                    @endif
                </div>
                @if ($order->notes)
                    <div
                        style="margin-top:14px;padding-top:12px;border-top:1px solid var(--border);font-size:.84rem;color:var(--muted)">
                        <strong>Order Notes:</strong> {{ $order->notes }}
                    </div>
                @endif
            </div>

            {{-- Payment Info --}}
            <div class="admin-card" style="margin-bottom:20px">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">Payment Info</h3>
                <div style="font-size:.9rem;margin-bottom:12px">
                    <strong>Method:</strong> {{ $order->paymentMethodLabel() }}<br>
                    <strong>Status:</strong>
                    <span style="color:{{ $order->paymentStatusColor() }};font-weight:600">
                        {{ $order->paymentStatusLabel() }}</span>
                </div>
                @if ($order->payment_proof)
                    <div style="margin-bottom:16px">
                        <div style="font-size:.82rem;color:var(--muted);margin-bottom:6px">Payment Proof:</div>
                        <a href="{{ asset($order->payment_proof) }}" target="_blank">
                            <img src="{{ asset($order->payment_proof) }}"
                                style="max-width:100%;max-height:300px;border-radius:8px;border:1px solid var(--border);object-fit:contain;cursor:pointer">
                        </a>
                    </div>
                @endif
                @if ($order->payment_method !== 'cod')
                    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}"
                        style="display:flex;gap:10px;align-items:center">
                        @csrf @method('PUT')
                        <select name="payment_status" class="form-control" style="flex:1">
                            @foreach (['pending' => 'Awaiting Verification', 'verified' => 'Verified', 'rejected' => 'Rejected'] as $val => $lbl)
                                <option value="{{ $val }}"
                                    {{ $order->payment_status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </form>
                @endif
            </div>

            {{-- Return Requests --}}
            @if ($order->returns->isNotEmpty())
                <div class="admin-card" style="margin-bottom:20px">
                    <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">↩ Return Request
                    </h3>
                    @foreach ($order->returns as $ret)
                        <div style="margin-bottom:14px;padding:14px;border:1px solid var(--border);border-radius:10px">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                                <strong>{{ $ret->reason }}</strong>
                                <span
                                    style="color:{{ $ret->statusColor() }};font-weight:600;font-size:.82rem">{{ $ret->statusLabel() }}</span>
                            </div>
                            @if ($ret->details)
                                <div style="font-size:.85rem;color:var(--muted);margin-bottom:10px">{{ $ret->details }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('admin.returns.update', $ret->id) }}">
                                @csrf @method('PUT')
                                <div style="display:flex;gap:8px;margin-bottom:8px">
                                    <select name="status" class="form-control">
                                        @foreach (['pending', 'approved', 'rejected'] as $s)
                                            <option value="{{ $s }}"
                                                {{ $ret->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                </div>
                                <input type="text" name="admin_note" class="form-control" value="{{ $ret->admin_note }}"
                                    placeholder="Admin note to customer (optional)">
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Order Notes / Chat --}}
            <div class="admin-card">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:14px">
                    💬 Order Messages
                </h3>

                @if ($order->orderNotes->isEmpty())
                    <p style="color:var(--muted);font-size:.85rem;margin-bottom:14px">
                        No messages yet.
                    </p>
                @else
                    <div style="margin-bottom:16px">
                        @foreach ($order->orderNotes as $note)
                            <div class="note-bubble {{ $note->is_admin ? 'admin' : 'customer' }}">
                                <div style="font-size:.75rem;font-weight:700;opacity:.7;margin-bottom:3px">
                                    {{ $note->is_admin ? '🛡 You (Admin)' : '👤 ' . ($note->user?->name ?? 'Customer') }}
                                    · {{ $note->created_at->format('M d, h:i A') }}
                                </div>
                                {{ $note->message }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $order->status }}">
                    <textarea name="admin_note" class="form-control" rows="3"
                        placeholder="Send a message to the customer…"
                        style="width:100%;margin-bottom:8px;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-family:inherit;resize:vertical"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <div>
            {{-- Update Status --}}
            <div class="admin-card">
                <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;margin-bottom:16px">Update Order</h3>
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-control">
                            @foreach (['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number" class="form-control"
                            value="{{ $order->tracking_number }}" placeholder="e.g. TRK1234567890">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">Update &
                        Notify Customer</button>
                </form>
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border)">
                    <div style="font-size:.8rem;color:var(--muted)">Placed:
                        {{ $order->created_at->format('M d, Y h:i A') }}</div>
                    @if ($order->shipped_at)
                        <div style="font-size:.8rem;color:var(--muted)">Shipped:
                            {{ $order->shipped_at->format('M d, Y') }}</div>
                    @endif
                    @if ($order->delivered_at)
                        <div style="font-size:.8rem;color:var(--muted)">Delivered:
                            {{ $order->delivered_at->format('M d, Y') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
