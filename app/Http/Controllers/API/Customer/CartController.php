<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\carts;            // نحتفظ باسم الموديل كما هو
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * 1. جلب محتويات السلة مجمّعة حسب السوبرماركت
     *    GET  /customer/cart
     */
    public function index(Request $request)
{
    $user = $request->user();
    $cart = carts::firstOrCreate(['user_id' => $user->id]);

    $items = CartItem::with('product', 'supermarket')
                ->where('cart_id', $cart->id)
                ->get();

    // عدل التجميع ليستخدم id بدل الاسم في المفتاح، وليرسل كلاهما في الاستجابة
   $groups = $items
    ->groupBy(fn($i) => $i->supermarket->id)
    ->map(function ($group, $supermarketId) {
        $supermarketName = $group->first()->supermarket->SupermarketName ?? '';
        return [
            'supermarket_id' => $supermarketId,
            'supermarket'    => $supermarketName,
            'subtotal'       => $group->sum(fn($i) => $i->price * $i->quantity),
            'items'          => $group->map(fn($i) => [
                'id'             => $i->id,
                'product_id'     => $i->product_id,
                'product_name'   => $i->product->product_name,
                'supermarket_id' => $supermarketId,
                'supermarket'    => $supermarketName, // هذا السطر سيحل مشكلتك مع الفلاتر
                'quantity'       => $i->quantity,
                'price'          => $i->price,
                'total'          => $i->price * $i->quantity,
                'image_url'      => asset('products/'.$i->product->Image),
            ])->values(),
        ];
    })->values();


    return response()->json([
        'status' => true,
        'groups' => $groups,
    ]);
}


  /**
 * إضافة منتج إلى السلة
 * POST /customer/cart
 */
public function store(Request $request)
{
    $data = $request->validate([
        'product_id'     => 'required|exists:products,id',
        'supermarket_id' => 'required|exists:super_markets,id',
        'quantity'       => 'required|integer|min:1',
    ]);

    $cart = carts::firstOrCreate(['user_id' => $request->user()->id]);

    try {
        // جلب المنتج ثم السعر عبر accessor
        $product   = Product::findOrFail($data['product_id']);
        $unitPrice = $product->price;   // الآن attribute lowercase يعمل

        if (is_null($unitPrice)) {
            throw new \Exception("Product#{$product->id} has null price.");
        }

        $item = CartItem::firstOrNew([
            'cart_id'        => $cart->id,
            'product_id'     => $data['product_id'],
            'supermarket_id' => $data['supermarket_id'],
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + $data['quantity'];
        $item->price    = $unitPrice;
        $item->save();

        return response()->json([
            'status' => true,
            'item'   => $item,
        ], Response::HTTP_CREATED);

    } catch (\Exception $e) {
        Log::error('Error in CartController@store: '.$e->getMessage(), [
            'payload' => $data,
            'trace'   => $e->getTraceAsString(),
        ]);

        if (config('app.debug')) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'status'  => false,
            'message' => 'حدث خطأ داخلي أثناء إضافة المنتج للعربة',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}



    /**
     * 3. تعديل كمية عنصر
     *    PUT /customer/cart/{id}
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($id);

        DB::transaction(function () use ($item, $data) {
            $item->update(['quantity' => $data['quantity']]);
        });

        return response()->json([
            'status' => true,
            'item'   => $item->fresh(),
        ]);
    }

    /**
     * 4. إزالة عنصر
     *    DELETE /customer/cart/{id}
     */
    public function destroy($id)
    {
        CartItem::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * 5. تفريغ السلة
     *    DELETE /customer/cart/clear
     */
   public function clearSupermarket(Request $request, $supermarket_id)
{
    $cart = carts::firstOrCreate(['user_id' => $request->user()->id]);
    // فقط حذف العناصر التي تعود لسوبرماركت معين
    CartItem::where('cart_id', $cart->id)
        ->where('supermarket_id', $supermarket_id)
        ->delete();

    return response()->json([
        'status' => true,
    ]);
}

}
