<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'status', 'total', 'discount', 'coupon_code',
        'shipping_name', 'shipping_email', 'shipping_phone',
        'shipping_address', 'shipping_city', 'shipping_zip', 'notes',
        'tracking_number', 'shipped_at', 'delivered_at',
        'payment_method', 'payment_status', 'payment_proof', 'shipping_fee',
    ];

    protected $casts = [
        'shipped_at'   => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user(): BelongsTo    { return $this->belongsTo(User::class); }
    public function items(): HasMany     { return $this->hasMany(OrderItem::class); }
    public function orderNotes(): HasMany { return $this->hasMany(OrderNote::class); }
    public function returns(): HasMany   { return $this->hasMany(OrderReturn::class); }

    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'cod'      => 'Cash on Delivery',
            'bank'     => 'Bank Transfer',
            'jazzcash' => 'JazzCash',
            'easypaisa'=> 'EasyPaisa',
            default    => ucfirst($this->payment_method ?? 'cod'),
        };
    }

    public function paymentStatusLabel(): string
    {
        if ($this->payment_method === 'cod') {
            return match ($this->payment_status) {
                'verified' => 'Payment Received',
                'rejected' => 'Rejected',
                default    => 'Pay on Delivery',
            };
        }

        return match ($this->payment_status) {
            'pending'  => 'Awaiting Verification',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default    => ucfirst($this->payment_status ?? 'pending'),
        };
    }

    public function paymentStatusColor(): string
    {
        if ($this->payment_method === 'cod' && $this->payment_status === 'pending') {
            return '#5a7a5a';
        }

        return match ($this->payment_status) {
            'pending'  => '#e9a825',
            'verified' => '#27ae60',
            'rejected' => '#c0392b',
            default    => '#666',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'    => 'Pending',
            'confirmed'  => 'Confirmed',
            'processing' => 'Processing',
            'shipped'    => 'Shipped',
            'delivered'  => 'Delivered',
            'cancelled'  => 'Cancelled',
            default      => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'    => '#e9a825',
            'confirmed'  => '#2d6a4f',
            'processing' => '#1d6fa4',
            'shipped'    => '#8338ec',
            'delivered'  => '#27ae60',
            'cancelled'  => '#c0392b',
            default      => '#666',
        };
    }

    public function statusStep(): int
    {
        return match ($this->status) {
            'pending'    => 0,
            'confirmed'  => 1,
            'processing' => 2,
            'shipped'    => 3,
            'delivered'  => 4,
            default      => 0,
        };
    }
}
