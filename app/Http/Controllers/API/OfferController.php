<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Offers;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * عرض قائمة بجميع العروض لسوبرماركت معين.
     */
    public function index($supermarket_id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        $offers = Offers::with('product')->where('supermarket_id', $supermarket_id)->get();
        return response()->json([
            'offers' => $offers,
            'supermarket' => $supermarket
        ]);
    }

    /**
     * عرض عرض محدد.
     */
    public function show($supermarket_id, $id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        $offer = Offers::with('product')->where('supermarket_id', $supermarket_id)->find($id);
        if (!$offer) {
            return response()->json(['message' => 'العرض غير موجود'], 404);
        }
        return response()->json(['offer' => $offer, 'supermarket' => $supermarket]);
    }

    /**
     * إنشاء عرض جديد.
     */
    public function store(Request $request, $supermarket_id)
    {
        // تعريف قواعد التحقق والرسائل المخصصة
        $rules = [
            'product_id'          => 'required|exists:products,id',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'Description'         => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        $messages = [
            'product_id.required'          => 'يرجى اختيار المنتج.',
            'product_id.exists'            => 'المنتج المحدد غير موجود.',
            'start_date.required'          => 'يرجى إدخال تاريخ بدء العرض.',
            'start_date.date'              => 'تاريخ بدء العرض غير صالح.',
            'end_date.required'            => 'يرجى إدخال تاريخ انتهاء العرض.',
            'end_date.date'                => 'تاريخ انتهاء العرض غير صالح.',
            'end_date.after_or_equal'      => 'يجب أن يكون تاريخ انتهاء العرض بعد أو يساوي تاريخ بدء العرض.',
            'discount_percentage.required' => 'يرجى إدخال نسبة التخفيض.',
            'discount_percentage.numeric'  => 'يجب أن تكون نسبة التخفيض رقمية.',
            'discount_percentage.min'      => 'يجب أن تكون نسبة التخفيض على الأقل 0.',
            'discount_percentage.max'      => 'يجب ألا تزيد نسبة التخفيض عن 100.',
            'Description.string'           => 'الوصف يجب أن يكون نصاً.',
            'image.image'                  => 'يجب أن يكون الملف صورة.',
            'image.mimes'                  => 'صيغة الصورة غير مدعومة (jpeg, png, jpg, gif, svg).',
            'image.max'                    => 'حجم الصورة يجب ألا يتجاوز 2 ميجا بايت.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // إنشاء عرض جديد وتعبئة الحقول
        $offer = new Offers();
        $offer->product_id          = $request->product_id;
        $offer->start_date          = $request->start_date;
        $offer->end_date            = $request->end_date;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->Description         = $request->Description;
        $offer->supermarket_id      = $supermarket_id;
    
        // معالجة الصورة إذا تم رفعها
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('offers'), $imagename);
            $offer->image = $imagename;
        }
    
        $offer->save();
    
        return response()->json(['message' => 'تم إضافة العرض بنجاح!', 'offer' => $offer], 201);
    }

    /**
     * تحديث عرض موجود.
     */
    public function update(Request $request, $supermarket_id, $id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
    
        $offer = Offers::find($id);
        if (!$offer) {
            return response()->json(['message' => 'العرض غير موجود'], 404);
        }
    
        // التأكد من أن المنتج المرتبط بالعرض موجود وينتمي للسوبرماركت الحالي
        $product = $offer->product;
        if (!$product) {
            return response()->json(['message' => 'المنتج المرتبط بالعرض غير موجود'], 404);
        }
        if ($product->supermarket_id != $supermarket->id) {
            return response()->json(['message' => 'العرض لا ينتمي إلى هذا السوبرماركت'], 403);
        }
    
        $rules = [
            'product_id'          => 'required|exists:products,id',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'Description'         => 'nullable|string',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // تحديث بيانات العرض
        $offer->product_id          = $request->product_id;
        $offer->start_date          = $request->start_date;
        $offer->end_date            = $request->end_date;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->Description         = $request->Description;
    
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('offers'), $imagename);
            $offer->image = $imagename;
        }
    
        $offer->save();
    
        return response()->json(['message' => 'تم تعديل العرض بنجاح!', 'offer' => $offer]);
    }

    /**
     * حذف عرض.
     */
    public function destroy($supermarket_id, $id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
    
        $offer = Offers::find($id);
        if (!$offer) {
            return response()->json(['message' => 'العرض غير موجود'], 404);
        }
    
        $offer->delete();
    
        return response()->json(['message' => 'تم حذف العرض بنجاح']);
    }

    /**
     * البحث عن العروض بناءً على اسم المنتج.
     */
    public function search(Request $request, $supermarket_id)
    {
        $search = $request->input('search');
        $offers = Offers::whereHas('product', function ($query) use ($search) {
            $query->where('product_name', 'LIKE', "%$search%");
        })->where('supermarket_id', $supermarket_id)->get();
    
        return response()->json([
            'offers' => $offers,
            'message' => $offers->isEmpty() ? 'لا توجد نتائج مطابقة للبحث.' : ''
        ]);
    }
}
