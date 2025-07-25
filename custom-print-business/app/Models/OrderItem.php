<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'design_id',
        'product_name',
        'design_name',
        'quantity',
        'unit_price',
        'total_price',
        'size',
        'material',
        'custom_design_details',
        'custom_design_file',
        'special_instructions',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Hubungan dengan Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Hubungan dengan Product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Hubungan dengan Design
     */
    public function design(): BelongsTo
    {
        return $this->belongsTo(Design::class);
    }

    /**
     * Dapatkan harga unit yang diformat
     */
    public function getFormattedUnitPriceAttribute()
    {
        return 'RM ' . number_format($this->unit_price, 2);
    }

    /**
     * Dapatkan harga total yang diformat
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'RM ' . number_format($this->total_price, 2);
    }
}
