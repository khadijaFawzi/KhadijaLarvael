<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\SuperMarket;
use Illuminate\Http\Request;

class SupermarketController extends Controller
{
    /**
     * عرض جميع السوبرماركتات المسجلة
     */
    public function index()
    {
        $supermarkets = SuperMarket::with('user:id,name,email') // ربط بيانات المستخدم في حال احتجت
            ->select('id', 'SupermarketName', 'Location', 'ContactNumber', 'description', 'bank_account', 'profile_image')
            ->get();

        return response()->json([
            'status' => true,
            'supermarkets' => $supermarkets
        ], 200);
    }
}

