<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * تحميل العلاقة مع السوبرماركت تلقائيًا عند استدعاء المستخدم.
     */
    protected $with = ['supermarket'];

    /**
     * الحقول القابلة للملء بشكل جماعي.
     */
    protected $fillable = [
        'Role_id',
        'username',
        'email',
        'password',
        
    ];

    /**
     * الحقول المخفية عند الإرسال إلى الواجهات.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * الحقول التي يجب أن يتم تحويلها لأنواع بيانات معينة.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * علاقة المستخدم بالسوبرماركت.
     */
    public function supermarket()
    {
        return $this->hasOne(SuperMarket::class, 'User_id'); // تأكد من أن User_id هو المفتاح الأجنبي الصحيح في قاعدة البيانات
        return $this->belongsTo(SuperMarket::class, 'supermarket_id');
    
    }

}
