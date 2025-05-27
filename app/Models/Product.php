<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    /**
     * Cast raw 'Price' column and add accessor
     */
    protected $casts = [
        'Price' => 'decimal:2',
    ];

    /**
     * Accessor to expose lowercase 'price' attribute
     */
    public function getPriceAttribute()
    {
        return $this->attributes['Price'];
    }

    // علاقة المنتج بالعروض
    public function offers()
    {
        return $this->hasMany(Offers::class, 'Product_id');
    }

    // علاقة المنتج بالسوبرماركت
    public function supermarket()
    {
        return $this->belongsTo(SuperMarket::class, 'supermarket_id');
    }

    // علاقة المنتج بعناصر السلة
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }


    // علاقة المنتج بأسعار متعددة (إن وجدت)
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    // علاقة المنتج بالفئة
    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_id');
    }
  


    
public function favorites()
{
    return $this->morphMany(Favorite::class, 'favoritable');
}
public function reviews()
{
    return $this->hasMany(ProductReview::class);
}

public function averageRating()
{
    return $this->reviews()->avg('rating');
}



public function orderDetails()
{
    return $this->hasMany(\App\Models\OrderDetail::class, 'product_id');
}


}


