<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{ 
    protected $table = 'offers'; // تأكد أن اسم الجدول صحيح
    protected $fillable = [
        'supermarket_id',
        'Product_id',
        'start_date',
        'end_date',
        'discount_percentage',
        'Description',
        'image',
        'is_ai_processed',
        'extracted_text',
        'is_verified'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }
}
