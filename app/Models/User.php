<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

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
        'phone_number',
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
        return $this->hasOne(SuperMarket::class, 'User_id');
    }

    /**
     * علاقة المستخدم بالطلبات.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * علاقة المستخدم بالعناوين.
     */
    // public function addresses()
    // {
    //     return $this->hasMany(UserAddress::class, 'user_id');
    // }

    /**
     * علاقة المستخدم بالمفضلة.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * علاقة المستخدم بالتقييمات.
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class, 'user_id');
    }

    /**
     * علاقة المستخدم بالإشعارات.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
} 
