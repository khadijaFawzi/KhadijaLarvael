<?php
namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;

use App\Models\Offers;

class FavoriteController extends Controller
{
   
    // جلب قائمة المفضلات للمستخدم (منتجات وعروض)
// جلب قائمة المفضلات للمستخدم (منتجات وعروض)
    public function index(Request $request)
    {
        $user = $request->user();

        // 1. بناء الاستعلام الأساسي
        $query = Favorite::where('user_id', $user->id)
                         ->with('favoritable');

        // 2. فلترة حسب النوع (منتج أو عرض)
        if ($request->filled('type')) {
            $class = $request->type === 'product'
                     ? Product::class
                     : Offers::class;
            $query->where('favoritable_type', $class);
        }

        // 3. فلترة حسب السوبرماركت
        if ($request->filled('supermarket_id')) {
            $query->whereHas('favoritable', function($q) use ($request) {
                $q->where('supermarket_id', $request->supermarket_id);
            });
        }

        // 4. فلترة حسب نطاق تاريخ الإضافة
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // 5. تطبيق الترتيب والتقسيم (pagination)
        $favorites = $query->orderBy('created_at', 'desc')
                           ->paginate(20);

        // 6. تحويل كل Favorite إلى مصفوفة بيانات موحدة
        $data = $favorites->getCollection()->map(function($fav) {
            $item = $fav->favoritable;
            if (! $item) {
                // العنصر محذوف أو غير موجود
                return null;
            }

            $type = class_basename($fav->favoritable_type); // 'Product' أو 'Offer'

            // إعداد البنية لكل نوع
            if ($type === 'Product') {
                return [
                    'type'             => 'product',
                    'id'               => $item->id,
                    'name'             => $item->product_name,
                    'supermarket_id'   => $item->supermarket_id,
                    'supermarket_name' => $item->supermarket->SupermarketName ?? '',
                    'favorited_at'     => $fav->created_at->toDateTimeString(),
                ];
            }

            // Offer
            return [
                'type'               => 'offer',
                'id'                 => $item->id,
                'product_id'         => $item->product_id,
                'product_name'       => $item->product_name,
                'supermarket_id'     => $item->supermarket_id,
                'supermarket_name'   => $item->supermarket->SupermarketName ?? '',
                'discount_percentage'=> $item->discount_percentage,
                'description'        => $item->description,
                'offer_image'        => $item->offer_image,
                'favorited_at'       => $fav->created_at->toDateTimeString(),
            ];
        })->filter()->values();

        // 7. إعادة JSON مع بيانات pagination
        return response()->json([
            'data'       => $data,
            'pagination' => [
                'current_page' => $favorites->currentPage(),
                'last_page'    => $favorites->lastPage(),
                'per_page'     => $favorites->perPage(),
                'total'        => $favorites->total(),
            ],
        ]);
    }


    // إضافة عنصر للمفضلة
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:product,offer'],
            'product_id' => ['required_if:type,product', 'integer'],
            'offer_id'   => ['required_if:type,offer', 'integer'],
        ]);

        $user = $request->user();
        if ($data['type'] === 'product') {
            $product = Product::find($data['product_id']);
            if (!$product) return response()->json(['message' => 'Product not found.'], 404);
            $favorite = Favorite::firstOrCreate([
                'user_id'          => $user->id,
                'favoritable_id'   => $data['product_id'],
                'favoritable_type' => Product::class,
            ]);
        } else {
            $offer = Offers::find($data['offer_id']);
            if (!$offer) return response()->json(['message' => 'Offer not found.'], 404);
            $favorite = Favorite::firstOrCreate([
                'user_id'          => $user->id,
                'favoritable_id'   => $data['offer_id'],
                'favoritable_type' => Offers::class,
            ]);
        }
        return response()->json(['favorite' => $favorite], 201);
    }

    public function destroy(Request $request)
{
    $data = $request->validate([
        'type' => ['required', 'in:product,offer'],
        'id'   => ['required', 'integer'],
    ]);

    $user = $request->user();
    $favoritableType = $data['type'] === 'product' ? Product::class : Offers::class;

    // جلب المفضلة بدون exception
    $favorite = Favorite::where('user_id', $user->id)
        ->where('favoritable_id', $data['id'])
        ->where('favoritable_type', $favoritableType)
        ->first();

    if (! $favorite) {
        return response()->json([
            'message' => 'Favorite not found for this user and type/id.'
        ], 404);
    }

    $favorite->delete();
    return response()->noContent();
}

}
