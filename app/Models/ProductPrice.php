<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    protected $table = 'product_prices';

    protected $fillable = [
        'product_id',
        'supermarket_id',
        'price',
        'start_date',
        'end_date'
    ];

    /**
     * العلاقة مع المنتج.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * العلاقة مع السوبر ماركت.
     */
    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}