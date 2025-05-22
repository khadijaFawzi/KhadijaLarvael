<?php
namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // جلب قائمة المفضلات للمستخدم
    public function index(Request $request)
    {
        $user = $request->user();
        $favorites = Favorite::with('product.supermarket')
                        ->where('user_id', $user->id)
                        ->get();

        $data = $favorites->map(function($fav) {
            $prod   = $fav->product;
            $market = $prod->supermarket;
            return [
                'product_id'       => $prod->id,
                'product_name'     => $prod->name,
                'supermarket_id'   => $market->id,
                'supermarket_name' => $market->supermarket_name,
                'favorited_at'     => $fav->created_at->toDateTimeString(),
            ];
        });

        return response()->json($data);
    }

    // إضافة منتج إلى المفضلة
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
        ]);

        $user = $request->user();

        // 2. التأكد من عدم تكرار الإضافة
        $favorite = Favorite::firstOrCreate([
            'user_id'    => $user->id,
            'product_id' => $data['product_id'],
        ]);

        // 3. إرجاع استجابة مناسبة
        return response()->json([
            'message' => $favorite->wasRecentlyCreated 
                         ? 'Added to favorites.' 
                         : 'Already in favorites.',
            'favorite' => $favorite,
        ], $favorite->wasRecentlyCreated ? 201 : 200);
    }

    // إزالة منتج من المفضلة
    public function destroy(Request $request, $product_id)
    {
        $fav = Favorite::where('user_id', $request->user()->id)
                       ->where('product_id', $product_id)
                       ->first();

        if ($fav) {
            $fav->delete();
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'Not found.'], 404);
    }
}
