<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{ 
    protected $table = 'offers'; // تأكد أن اسم الجدول صحيح

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }
}
