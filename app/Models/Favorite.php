<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', 'product_id',
    ];

    // علاقة المفضلة بالعميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // علاقة المفضلة بالمنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
