<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Offers;
use App\Models\SuperMarket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function view_offers(){
        $product=Product::all();
        return view('admin.offers',compact('product'));
    }


    public function show_offers($supermarket_id) {
        $offers = Offers::with('product')->where('supermarket_id', $supermarket_id)->get();
        $supermarket = SuperMarket::find($supermarket_id);
        $category = Category::all();
        return view('admin.show_offers', compact('offers', 'supermarket','category'));
    }
    



    public function add_offers(Request $request, $supermarket_id)
    {
        // تعريف قواعد التحقق مع رسائل الخطأ المخصصة
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
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // إنشاء عرض جديد وتعبئة الحقول
        $offer = new Offers();
        $offer->product_id          = $request->product_id;
        $offer->start_date          = $request->start_date;
        $offer->end_date            = $request->end_date;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->Description         = $request->Description;
        $offer->supermarket_id      = $supermarket_id;
    
        // معالجة الصورة في حال تم رفعها
        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('offers'), $imagename);
            $offer->image = $imagename;
        }
    
        $offer->save();
    
        return redirect()->back()->with('success', 'تم إضافة العرض بنجاح!');
    }
    

public function searchOffers(Request $request)
{
    $search = $request->input('search');

    // البحث عن العروض بناءً على اسم المنتج
    $offers = Offers::whereHas('product', function ($query) use ($search) {
        $query->where('product_name', 'LIKE', "%$search%");
    })->get();

    return view('admin.show_offers', compact('offers'))->with('message', $offers->isEmpty() ? 'لا توجد نتائج مطابقة للبحث.' : '');
}




    public function update_offers($supermarket_id, $id)
{
    $offer = Offers::find($id);
    if (!$offer) {
        return redirect()->back()->withErrors(['message' => 'العرض غير موجود']);
    }
    // جلب كل المنتجات إن كان ذلك مطلوبًا
    $products = Product::all();
    // الحصول على السوبرماركت كنموذج مفرد
    $currentSupermarket = SuperMarket::find($supermarket_id);
    if (!$currentSupermarket) {
        return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
    }
    return view('admin.update_offers', compact('offer', 'products', 'currentSupermarket'));
}


public function update_offers_confirm(Request $request, $supermarket_id, $id)
{
    // البحث عن العرض
    $offer = Offers::find($id);
    if (!$offer) {
        return redirect()->back()->withErrors(['message' => 'العرض غير موجود']);
    }
    
    // البحث عن السوبرماركت
    $currentSupermarket = SuperMarket::find($supermarket_id);
    if (!$currentSupermarket) {
        return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
    }
    
    // التأكد من أن المنتج المرتبط بالعرض موجود وأنه ينتمي للسوبرماركت الحالي
    $product = $offer->product;
    if (!$product) {
        return redirect()->back()->withErrors(['message' => 'المنتج المرتبط بالعرض غير موجود']);
    }
   
    
    // تحديث بيانات العرض
    $offer->Product_id          = $request->Product_id;
    $offer->start_date          = $request->start_date; 
    $offer->end_date            = $request->end_date; 
    $offer->discount_percentage = $request->discount_percentage;
    $offer->Description         = $request->Description;
    
    // معالجة الصورة إذا تم رفعها
    if ($request->hasFile('image')) {
        $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('offers'), $imagename);
        $offer->image = $imagename;
    }
    
    $offer->save();
    
    return redirect()->back()->with('success', 'تم تعديل العرض بنجاح!');
}

public function delete_offers($id){
    $offers=Offers::find($id);
    $offers->delete();
    return redirect()->back()->with('message','product Deleted Successfully');
}




public function offers_process(){
    return view('admin.offersProces');
}





}
