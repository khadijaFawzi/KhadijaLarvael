<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $table = 'offers';

    protected $fillable = [
        'supermarket_id',
        'product_id',        // مطابق للمَيجرِيشِن
        'start_date',
        'end_date',
        'discount_percentage',
        'Description',      
        'image',
        'is_ai_processed',
        'extracted_text',
        'is_verified',
    ];

    // علاقة المنتج: مفتاح أجنبي product_id (صغير)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // علاقة السوبرماركت
    public function supermarket()
    {
        return $this->belongsTo(SuperMarket::class, 'supermarket_id');
    }

    
    protected $casts = [
        'start_date' => 'date',      // يحول إلى Carbon
        'end_date'   => 'date',
    ];
}
