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
            ->select('id', 'SupermarketName', 'Location', 'ContactNumber', 'description', 'profile_image')
            ->get();

        return response()->json([
            'status' => true,
            'supermarkets' => $supermarkets
        ], 200);
    }

    public function offersBySupermarket($id)
{
    // تحقق أن السوبرماركت موجود
    $supermarket = Supermarket::find($id);
    if (!$supermarket) {
        return response()->json(['status' => false, 'message' => 'Supermarket not found'], 404);
    }
    // جلب العروض التابعة لهذا السوبرماركت فقط (يفترض وجود علاقة offers في المودل)
    $offers = $supermarket->offers; // لو عندك علاقة Offers
    // أو
    // $offers = Offer::where('supermarket_id', $id)->get();

    return response()->json(['status' => true, 'offers' => $offers]);
}

}

