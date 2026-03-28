<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $routeKeyName = 'slug';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'category_id',
        'sku',
        'stock_quantity',
        'low_stock_threshold',
        'is_active',
        'is_featured',
        'image',
        'images',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'custom_schema',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'images' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->where('status', 'approved')->avg('rating') ?? 0;
    }

    public function reviewCount(): int
    {
        return $this->reviews()->where('status', 'approved')->count();
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity > 0 && $this->stock_quantity <= $this->low_stock_threshold;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return static::where('slug', $value)->first() ?? static::find($value);
    }
}
