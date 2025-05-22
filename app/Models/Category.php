<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'CategoryName',
        'icon',    
    ];
    // في الموديل Category.php
public function products()
{
    return $this->hasMany(Product::class);
}

}
