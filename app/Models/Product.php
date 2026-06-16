<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price',
        'stock', 'image', 'is_featured', 'is_organic', 'weight',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_organic'  => 'boolean',
        'price'       => 'decimal:2',
    ];

    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }
    public function orderItems(): HasMany  { return $this->hasMany(OrderItem::class); }
    public function reviews(): HasMany     { return $this->hasMany(Review::class); }
    public function wishlists(): HasMany   { return $this->hasMany(Wishlist::class); }

    public function avgRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80';
        }
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return asset(ltrim($this->image, '/'));
    }
}
