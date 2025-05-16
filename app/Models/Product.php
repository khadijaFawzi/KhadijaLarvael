<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    // علاقة المنتج بالعروض (لم تتغير)
    public function offers()
    {
        return $this->hasMany(Offers::class, 'Product_id');
    }
    public function supermarket()
    {
    return $this->belongsTo(SuperMarket::class, 'supermarket_id'); // تأكد من أن 'supermarket_id' هو اسم العمود
    }


    

    // إضافة علاقة المنتج مع السلة (cart_items)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    // إضافة علاقة المنتج مع الطلبات (order_items)
    public function orderItems()
    {
        return $this->hasMany(OrderDetails::class, 'product_id');
    }
   
    public function prices()
    {
    return $this->hasMany(ProductPrice::class, 'product_id');
    }
    public function category()
{
    return $this->belongsTo(Category::class, 'Category_id');
}
}
