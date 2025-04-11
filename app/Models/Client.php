<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // تحديد الحقول القابلة للملء
    protected $fillable = [
        'name', 'email', 'phone'
    ];

    public function cart()
    {
        return $this->hasOne(ClientCart::class);
    }

    // علاقة العميل بالطلبات
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // علاقة العميل بالمفضلة
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    // يمكن إضافة علاقات مع جداول أخرى إذا كانت موجودة
}
