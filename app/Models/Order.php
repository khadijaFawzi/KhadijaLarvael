<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'supermarket_id',
        'status',
        'total',
        'delivery_fee',
        'payment_status',
        'deposit_receipt',
        'delivery_status',
        'tracking_code',
    ];

    // علاقة الطلب بالمستخدم (العميل)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة الطلب بالسوبرماركت
    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }

    // علاقة الطلب بتفاصيل المنتجات
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
