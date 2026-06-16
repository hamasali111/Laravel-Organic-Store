<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderReturn extends Model
{
    protected $fillable = ['order_id', 'user_id', 'reason', 'details', 'status', 'admin_note'];

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function user(): BelongsTo  { return $this->belongsTo(User::class); }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default    => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'  => '#e9a825',
            'approved' => '#27ae60',
            'rejected' => '#c0392b',
            default    => '#666',
        };
    }
}
