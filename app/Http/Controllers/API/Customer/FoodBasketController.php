<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FoodBasket;
class FoodBasketController extends Controller
{
    // عرض جميع السلات لسوبرماركت محدد
    public function index($supermarket_id)
    {
        $foodBaskets = FoodBasket::where('supermarket_id', $supermarket_id)->get();

        return response()->json([
            'status' => true,
            'data' => $foodBaskets
        ]);
    }


    public function all()
{
    // جلب كل السلات مع اسم السوبرماركت المرتبط
    $foodBaskets = \App\Models\FoodBasket::with('supermarket')->latest()->get();
    return response()->json([
        'status' => true,
        'data' => $foodBaskets,
    ]);
}

}
