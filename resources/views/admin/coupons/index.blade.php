@extends('layouts.admin')
@section('title','Coupons — Admin')
@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">+ Add Coupon</a>
</div>

@if(session('success'))
    <div style="background:#e6f4ea;color:#2d6a4f;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.87rem">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="admin-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order</th>
                <th>Uses Left</th>
                <th>Expires</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($coupons as $coupon)
        <tr>
            <td><strong style="font-family:monospace;font-size:.95rem;color:var(--green)">{{ $coupon->code }}</strong></td>
            <td>{{ ucfirst($coupon->type) }}</td>
            <td>{{ $coupon->type === 'percent' ? $coupon->value . '%' : 'PKR ' . number_format($coupon->value,0) }}</td>
            <td>PKR {{ number_format($coupon->min_order,0) }}</td>
            <td>{{ $coupon->uses_left ?? '∞' }}</td>
            <td>{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : '—' }}</td>
            <td><span style="color:{{ $coupon->active ? 'var(--green)' : 'var(--red)' }};font-weight:600">{{ $coupon->active ? 'Yes' : 'No' }}</span></td>
            <td>
                <div style="display:flex;gap:6px">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-outline">Edit</a>
                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" onsubmit="return confirm('Delete this coupon?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;padding:32px;color:var(--muted)">
                No coupons yet. <a href="{{ route('admin.coupons.create') }}">Add one</a>.
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:20px">{{ $coupons->links() }}</div>
</div>
@endsection
