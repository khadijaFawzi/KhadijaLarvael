<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
 use App\Models\SuperMarket;
class OfferController extends Controller
{
 
  
public function index()
{
    // نجلب العروض مع العلاقات
    $offers = Offers::with('product','supermarket')->get();

    $data = $offers->map(function($offer) {
        $SupermarketName = SuperMarket::where('id', $offer->supermarket_id)
                                 ->value('SupermarketName');
        $originalPrice = $offer->product?->Price; // السعر الأصلي من المنتج

        // حساب السعر بعد الخصم
        $discountedPrice = null;
        if ($originalPrice && $offer->discount_percentage) {
            $discountedPrice = $originalPrice - ($originalPrice * ($offer->discount_percentage / 100));
            $discountedPrice = round($discountedPrice, 2);
        }

        return [
            'id'                  => $offer->id,
            'supermarket_id'      => $offer->supermarket_id,
            'SupermarketName'     => $SupermarketName,
            'product_id'          => $offer->product_id,
            'product_name'        => $offer->product?->product_name,
            'Image'               => $offer->product?->Image,
            'start_date'          => optional($offer->start_date)->toDateString(),
            'end_date'            => optional($offer->end_date)->toDateString(),
            'discount_percentage' => (string)$offer->discount_percentage,
            'original_price'      => $originalPrice,
            'discounted_price'    => $discountedPrice,
            'Description'         => $offer->Description,
            'offer_image'         => $offer->image,
            'is_verified'         => (int)$offer->is_verified,
        ];
    });

    return response()->json($data);
}



    // POST /api/offers
    public function store(Request $request)
    {
        $data = $request->validate([
            'supermarket_id'      => 'required|exists:super_markets,id',
            'product_id'          => 'nullable|exists:products,id',
            'start_date'          => 'nullable|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'Description'         => 'nullable|string',
            'image'               => 'nullable|image|max:2048',
            'is_ai_processed'     => 'nullable|boolean',
            'extracted_text'      => 'nullable|string',
            'is_verified'         => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('offers', 'public');
        }

        $offer = Offers::create($data);
        return response()->json($offer, Response::HTTP_CREATED);
    }

    // GET /api/offers/{id}
    public function show($id)
    {
        $offer = Offers::with('product')->findOrFail($id);
        return response()->json($offer);
    }

    // PUT/PATCH /api/offers/{id}
    public function update(Request $request, $id)
    {
        $offer = Offers::findOrFail($id);

        $data = $request->validate([
            'supermarket_id'      => 'sometimes|required|exists:super_markets,id',
            'product_id'          => 'nullable|exists:products,id',
            'start_date'          => 'nullable|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'Description'         => 'nullable|string',
            'image'               => 'nullable|image|max:2048',
            'is_ai_processed'     => 'nullable|boolean',
            'extracted_text'      => 'nullable|string',
            'is_verified'         => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('offers', 'public');
        }

        $offer->update($data);
        return response()->json($offer);
    }

    // DELETE /api/offers/{id}
    public function destroy($id)
    {
        Offers::findOrFail($id)->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function offersBySupermarket($id)
{
    // جلب عروض السوبرماركت المحدد مع العلاقات
    $offers = Offers::with('product', 'supermarket')
        ->where('supermarket_id', $id)
        ->get();

    $data = $offers->map(function($offer) {
        $SupermarketName = $offer->supermarket?->SupermarketName;
        $originalPrice = $offer->product?->Price;

        $discountedPrice = null;
        if ($originalPrice && $offer->discount_percentage) {
            $discountedPrice = $originalPrice - ($originalPrice * ($offer->discount_percentage / 100));
            $discountedPrice = round($discountedPrice, 2);
        }

        return [
            'id'                  => $offer->id,
            'supermarket_id'      => $offer->supermarket_id,
            'supermarket_name'    => $SupermarketName,
            'product_id'          => $offer->product_id,
            'product_name'        => $offer->product?->product_name,
            'product_image'       => $offer->product?->Image,
            'start_date'          => optional($offer->start_date)->toDateString(),
            'end_date'            => optional($offer->end_date)->toDateString(),
            'discount_percentage' => (string)$offer->discount_percentage,
            'original_price'      => $originalPrice,
            'discounted_price'    => $discountedPrice,
            'description'         => $offer->Description,
            'offer_image'         => $offer->image,
            'is_verified'         => (int)$offer->is_verified,
        ];
    });

    return response()->json([
        'status' => true,
        'offers' => $data,
    ]);
}


}