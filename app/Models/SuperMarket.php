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

    public function products()
    {
        return $this->hasMany(Product::class,'supermarket_id');
    }
 
    

   
}


