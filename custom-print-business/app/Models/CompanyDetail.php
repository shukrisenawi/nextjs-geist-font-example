<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_description',
        'company_address',
        'company_phone',
        'company_email',
        'company_website',
        'whatsapp_number',
        'facebook_url',
        'instagram_url',
        'logo_path',
        'business_hours',
        'terms_and_conditions',
        'privacy_policy',
        'shipping_fee',
        'tax_rate',
    ];

    protected $casts = [
        'business_hours' => 'array',
        'shipping_fee' => 'decimal:2',
        'tax_rate' => 'decimal:2',
    ];

    /**
     * Dapatkan URL logo syarikat
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : asset('images/default-logo.png');
    }

    /**
     * Dapatkan yuran penghantaran yang diformat
     */
    public function getFormattedShippingFeeAttribute()
    {
        return 'RM ' . number_format($this->shipping_fee, 2);
    }

    /**
     * Dapatkan kadar cukai dalam peratus
     */
    public function getTaxRatePercentageAttribute()
    {
        return $this->tax_rate . '%';
    }

    /**
     * Dapatkan maklumat syarikat (singleton)
     */
    public static function getCompanyInfo()
    {
        return self::first() ?? self::create([
            'company_name' => 'Custom Print Business',
            'company_description' => 'Perniagaan percetakan custom untuk sticker dan baju sublimation',
            'company_address' => 'Alamat syarikat akan diisi',
            'company_phone' => '012-3456789',
            'company_email' => 'info@customprint.com',
            'whatsapp_number' => '012-3456789',
            'shipping_fee' => 10.00,
            'tax_rate' => 6.00,
        ]);
    }
}
