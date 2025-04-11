<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function offers()
    {
        return $this->hasMany(Offers::class, 'Product_id');
    }

    public function supermarket()
    {
        return $this->belongsTo(Supermarket::class);
    }
}
