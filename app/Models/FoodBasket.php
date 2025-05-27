<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodBasket extends Model
{
   use HasFactory;

    protected $fillable = [
        'supermarket_id','name',  'price',   'image', 'description', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function supermarket()
{
    return $this->belongsTo(Supermarket::class,'supermarket_id');
}

}
