<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', 'total', 'status',
    ];

    // علاقة الطلب بالعميل
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // علاقة الطلب بعناصر الطلب
    public function orderItems()
    {
        return $this->hasMany(OrderDetails ::class);
    }
}
