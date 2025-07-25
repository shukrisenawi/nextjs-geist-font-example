<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_price',
        'sizes',
        'materials',
        'image',
        'gallery',
        'is_active',
        'allow_custom_design',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sizes' => 'array',
        'materials' => 'array',
        'gallery' => 'array',
        'is_active' => 'boolean',
        'allow_custom_design' => 'boolean',
    ];

    /**
     * Hubungan dengan Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Hubungan dengan Design
     */
    public function designs(): HasMany
    {
        return $this->hasMany(Design::class);
    }

    /**
     * Hubungan dengan OrderItem
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Dapatkan design yang aktif sahaja
     */
    public function activeDesigns(): HasMany
    {
        return $this->hasMany(Design::class)->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Dapatkan design yang featured
     */
    public function featuredDesigns(): HasMany
    {
        return $this->hasMany(Design::class)->where('is_featured', true)->where('is_active', true);
    }

    /**
     * Scope untuk produk aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Dapatkan URL gambar utama produk
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-product.jpg');
    }

    /**
     * Dapatkan harga yang diformat
     */
    public function getFormattedPriceAttribute()
    {
        return 'RM ' . number_format($this->base_price, 2);
    }

    /**
     * Semak jika produk mempunyai saiz
     */
    public function hasSizes()
    {
        return !empty($this->sizes);
    }

    /**
     * Semak jika produk mempunyai bahan
     */
    public function hasMaterials()
    {
        return !empty($this->materials);
    }
}
