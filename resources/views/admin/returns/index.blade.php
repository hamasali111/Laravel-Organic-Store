@extends('layouts.admin')
@section('title','Return Requests — Admin')
@section('content')
<h1 style="font-family:'Playfair Display',serif;font-size:1.6rem;margin-bottom:24px">↩ Return Requests</h1>

@if(session('success'))<div style="background:var(--green-pale);border:1px solid var(--green-light);color:var(--green);padding:12px 16px;border-radius:10px;margin-bottom:20px">{{ session('success') }}</div>@endif

<div class="admin-card">
    @if($returns->isEmpty())
        <p style="color:var(--muted);text-align:center;padding:40px">No return requests yet.</p>
    @else
    <table class="data-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Customer</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($returns as $ret)
        <tr>
            <td><a href="{{ route('admin.orders.show', $ret->order_id) }}" style="color:var(--green);font-weight:600">#{{ str_pad($ret->order_id,6,'0',STR_PAD_LEFT) }}</a></td>
            <td>{{ $ret->user->name }}<br><small style="color:var(--muted)">{{ $ret->user->email }}</small></td>
            <td>{{ $ret->reason }}</td>
            <td>{{ $ret->created_at->format('M d, Y') }}</td>
            <td><span style="color:{{ $ret->statusColor() }};font-weight:600;font-size:.82rem">{{ $ret->statusLabel() }}</span></td>
            <td>
                <form method="POST" action="{{ route('admin.returns.update', $ret->id) }}" style="display:flex;gap:6px;align-items:center">
                    @csrf @method('PUT')
                    <select name="status" class="form-control" style="font-size:.8rem;padding:5px 8px">
                        @foreach(['pending','approved','rejected'] as $s)
                        <option value="{{ $s }}" {{ $ret->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-top:20px">{{ $returns->links() }}</div>
    @endif
</div>
@endsection
