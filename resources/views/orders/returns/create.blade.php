@extends('layouts.app')
@section('title','Return Request — Order #' . str_pad($order->id,6,'0',STR_PAD_LEFT))
@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a><span>›</span>
    <a href="{{ route('orders.index') }}">Orders</a><span>›</span>
    <a href="{{ route('orders.show', $order->id) }}">#{{ str_pad($order->id,6,'0',STR_PAD_LEFT) }}</a><span>›</span>
    Return Request
</div>
<div style="max-width:640px;margin:40px auto;padding:0 24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:8px">Request Return / Refund</h1>
    <p style="color:var(--muted);margin-bottom:28px">Order #{{ str_pad($order->id,6,'0',STR_PAD_LEFT) }} — Placed {{ $order->created_at->format('M d, Y') }}</p>

    @if($existing)
    <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:10px;padding:16px;margin-bottom:24px">
        <strong>You already have a return request</strong> — Status: <strong>{{ $existing->statusLabel() }}</strong><br>
        <span style="font-size:.86rem;color:var(--muted)">{{ $existing->reason }}</span>
    </div>
    @endif

    <div style="background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:28px">
        <form method="POST" action="{{ route('orders.returns.store', $order->id) }}">
            @csrf
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.83rem;font-weight:600;margin-bottom:6px">Reason for Return *</label>
                <select name="reason" class="form-control" required style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-size:.9rem">
                    <option value="">Select a reason…</option>
                    <option value="Wrong item received" {{ old('reason')==='Wrong item received'?'selected':'' }}>Wrong item received</option>
                    <option value="Damaged / defective product" {{ old('reason')==='Damaged / defective product'?'selected':'' }}>Damaged / defective product</option>
                    <option value="Product not as described" {{ old('reason')==='Product not as described'?'selected':'' }}>Product not as described</option>
                    <option value="Quality not satisfactory" {{ old('reason')==='Quality not satisfactory'?'selected':'' }}>Quality not satisfactory</option>
                    <option value="Changed my mind" {{ old('reason')==='Changed my mind'?'selected':'' }}>Changed my mind</option>
                    <option value="Other" {{ old('reason')==='Other'?'selected':'' }}>Other</option>
                </select>
                @error('reason')<div style="color:var(--red);font-size:.78rem;margin-top:4px">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:22px">
                <label style="display:block;font-size:.83rem;font-weight:600;margin-bottom:6px">Additional Details (optional)</label>
                <textarea name="details" class="form-control" rows="4" placeholder="Describe the issue in detail…" style="width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;font-size:.9rem;font-family:inherit;resize:vertical">{{ old('details') }}</textarea>
            </div>

            <div style="background:var(--green-pale);border-radius:10px;padding:14px 16px;font-size:.84rem;color:var(--green);margin-bottom:20px">
                🌱 We review return requests within 24–48 hours. You'll receive a confirmation email once processed.
            </div>

            <div style="display:flex;gap:12px">
                <button type="submit" class="btn btn-primary">Submit Return Request</button>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-gray">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
