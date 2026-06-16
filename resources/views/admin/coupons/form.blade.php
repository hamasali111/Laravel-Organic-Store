@extends('layouts.admin')
@section('title', isset($coupon) ? 'Edit Coupon' : 'Add Coupon')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">{{ isset($coupon) ? 'Edit Coupon' : 'Add Coupon' }}</h1>
    <a href="{{ route('admin.coupons.index') }}" class="btn btn-gray">← Back</a>
</div>
<div class="admin-card" style="max-width:500px">
    <form method="POST" action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}">
        @csrf @if(isset($coupon)) @method('PUT') @endif
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Code *</label>
                <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code ?? '') }}" style="text-transform:uppercase" required>
            </div>
            <div class="form-group">
                <label class="form-label">Type *</label>
                <select name="type" class="form-control">
                    <option value="percent" {{ old('type', $coupon->type ?? '') === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount (Rs)</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Discount Value *</label>
                <input type="number" name="value" step="0.01" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Min Order Amount (Rs)</label>
                <input type="number" name="min_order" step="0.01" class="form-control" value="{{ old('min_order', $coupon->min_order ?? 0) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Total Uses Limit</label>
                <input type="number" name="uses_left" class="form-control" value="{{ old('uses_left', $coupon->uses_left ?? '') }}" placeholder="Leave blank for unlimited">
            </div>
            <div class="form-group">
                <label class="form-label">Per-User Limit <span style="font-size:.75rem;color:var(--muted)">(times per account)</span></label>
                <input type="number" name="per_user_limit" min="1" class="form-control" value="{{ old('per_user_limit', $coupon->per_user_limit ?? 1) }}" placeholder="1">
                <div style="font-size:.75rem;color:var(--muted);margin-top:4px">Set to 1 for one-time-per-user (e.g. WELCOM10)</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Expires At</label>
            <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}">
        </div>
        <label style="display:flex;align-items:center;gap:8px;font-size:.88rem;margin-bottom:20px;cursor:pointer">
            <input type="checkbox" name="active" value="1" {{ old('active', $coupon->active ?? true) ? 'checked' : '' }}>
            Active
        </label>
        @if($errors->any())
            <div style="background:#fde8e8;color:var(--red);padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
                @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif
        <button type="submit" class="btn btn-primary">{{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}</button>
    </form>
</div>
@endsection
