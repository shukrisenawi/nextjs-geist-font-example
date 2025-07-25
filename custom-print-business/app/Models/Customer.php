<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends User
{
    use HasFactory;

    protected $table = 'users';

    /**
     * Hubungan dengan pesanan
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Dapatkan pesanan terbaru
     */
    public function recentOrders()
    {
        return $this->orders()->latest()->limit(5);
    }

    /**
     * Dapatkan pesanan yang aktif
     */
    public function activeOrders()
    {
        return $this->orders()->whereNotIn('status', ['delivered', 'cancelled']);
    }

    /**
     * Dapatkan pesanan yang telah selesai
     */
    public function completedOrders()
    {
        return $this->orders()->where('status', 'delivered');
    }
}
