<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuperMarket extends Model
{
    use HasFactory;

    protected $fillable = [
        'User_id', 'SupermarketName', 'Location', 'ContactNumber', 'profile_image',
    ];

    /**
     * العلاقة مع المنتجات.
     * سيسترجع جميع المنتجات المرتبطة بهذا السوبر ماركت.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'supermarket_id');
    }

    /**
     * العلاقة مع أسعار المنتجات.
     * سيسترجع جميع أسعار المنتجات لهذا السوبر ماركت.
     */
    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class, 'supermarket_id');
    }

    /**
     * استرجاع أسعار المنتج المحدد في السوبر ماركت.
     * يمكن استخدامه مع المنتج لتحديد الأسعار.
     */
    public function getProductPrice(Product $product)
    {
        return $this->productPrices()->where('product_id', $product->id)->first();
    }
    public function user()
    {
    return $this->belongsTo(User::class, 'User_id');
    }

    

}
