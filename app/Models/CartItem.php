<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cart_id', 'product_id', 'supermarket_id', 'quantity', 'price',
    ];

    // علاقة عنصر السلة بالسلة
    public function cart()
    {
        return $this->belongsTo(Carts::class, 'cart_id');
    }

    // علاقة عنصر السلة بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // علاقة عنصر السلة بالسوبرماركت (قد تكون اختيارية)
    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}
