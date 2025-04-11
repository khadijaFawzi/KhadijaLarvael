<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'supermarket_id', 'quantity', 'price',
    ];

    // علاقة عنصر الطلب بالطلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // علاقة عنصر الطلب بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // علاقة عنصر الطلب بالسوبرماركت (إن وجد)
    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}
