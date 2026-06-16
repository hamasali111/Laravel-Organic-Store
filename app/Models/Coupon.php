<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_order', 'uses_left', 'expires_at', 'active', 'per_user_limit'];
    protected $casts = ['expires_at' => 'date', 'active' => 'boolean'];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        if (!$this->active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if (!is_null($this->uses_left) && $this->uses_left <= 0) return false;
        return true;
    }

    public function hasBeenUsedByUser(int $userId): bool
    {
        $limit = $this->per_user_limit ?? 1;
        return $this->usages()->where('user_id', $userId)->count() >= $limit;
    }

    public function discount(float $subtotal): float
    {
        if ($subtotal < $this->min_order) return 0;
        if ($this->type === 'percent') return round($subtotal * ($this->value / 100), 2);
        return min($this->value, $subtotal);
    }
}
