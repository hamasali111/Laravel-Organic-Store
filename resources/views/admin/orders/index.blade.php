@extends('layouts.admin')
@section('title', 'Orders — Admin')
@push('styles')
    <style>
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: .74rem;
            font-weight: 600
        }
    </style>
@endpush
@section('content')
    <div style="margin-bottom:24px">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem">Orders</h1>
    </div>
    <div class="admin-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td><strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>
                            <div style="font-weight:600">{{ $order->shipping_name }}</div>
                            <div style="font-size:.76rem;color:var(--muted)">{{ $order->shipping_email }}</div>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items()->count() }}</td>
                        <td><strong>PKR {{ number_format($order->total, 0) }}</strong></td>
                        <td><span class="status-badge"
                                style="background:{{ $order->statusColor() }}22;color:{{ $order->statusColor() }}">{{ $order->statusLabel() }}</span>
                        </td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline">Manage</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:20px">{{ $orders->links() }}</div>
    </div>
@endsection
