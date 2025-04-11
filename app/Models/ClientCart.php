<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
    ];

    // علاقة السلة بالعميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // علاقة السلة بعناصرها
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
