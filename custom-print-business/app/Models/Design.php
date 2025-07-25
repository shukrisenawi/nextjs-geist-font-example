<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'slug',
        'description',
        'image_path',
        'thumbnail_path',
        'additional_price',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'additional_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Hubungan dengan Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Hubungan dengan OrderItem
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope untuk design aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk design featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Dapatkan URL gambar design
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : asset('images/default-design.jpg');
    }

    /**
     * Dapatkan URL thumbnail design
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : $this->getImageUrlAttribute();
    }

    /**
     * Dapatkan harga tambahan yang diformat
     */
    public function getFormattedAdditionalPriceAttribute()
    {
        return $this->additional_price > 0 ? '+RM ' . number_format($this->additional_price, 2) : 'Percuma';
    }

    /**
     * Dapatkan jumlah harga (harga asas produk + harga tambahan design)
     */
    public function getTotalPriceAttribute()
    {
        return $this->product->base_price + $this->additional_price;
    }

    /**
     * Dapatkan jumlah harga yang diformat
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'RM ' . number_format($this->getTotalPriceAttribute(), 2);
    }
}
