<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
     protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'note',
    ];

    // علاقة تفاصيل الطلب بالطلب الرئيسي
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة تفاصيل الطلب بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
