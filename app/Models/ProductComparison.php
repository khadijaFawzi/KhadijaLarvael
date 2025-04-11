<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComparison extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'supermarket_id',
        'price',
    ];

    // العلاقة مع النموذج الخاص بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // العلاقة مع النموذج الخاص بالسوبرماركت
    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}
