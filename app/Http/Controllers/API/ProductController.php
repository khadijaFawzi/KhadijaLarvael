<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // عرض جميع المنتجات لسوبرماركت معين
    public function index($supermarket_id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }

        // استخدام العلاقة المعرفة في نموذج SuperMarket
        $products = $supermarket->products;
        return response()->json($products);
    }

    // عرض منتج محدد
    public function show($supermarket_id, $id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }

        $product = Product::find($id);
        if (!$product || $product->supermarket_id != $supermarket->id) {
            return response()->json(['message' => 'المنتج غير موجود أو لا ينتمي للسوبرماركت'], 404);
        }
        return response()->json($product);
    }

    // إنشاء منتج جديد
    public function store(Request $request, $supermarket_id)
    {
        // تعريف قواعد التحقق والرسائل
        $rules = [
            'product_name' => 'required|string|max:255',
            'Price'        => 'required|numeric',
            'Category_id'  => 'required',
            'Description'  => 'required|string',
            'Image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'product_name.required' => 'يرجى إدخال اسم المنتج.',
            'Price.required'        => 'يرجى إدخال السعر.',
            'Price.numeric'         => 'يجب أن يكون السعر رقميًا.',
            'Category_id.required'  => 'يرجى اختيار الفئة.',
            'Description.required'  => 'يرجى إدخال وصف المنتج.',
            'Image.required'        => 'يرجى اختيار صورة.',
            'Image.image'           => 'يجب أن يكون الملف صورة.',
            'Image.mimes'           => 'صيغة الصورة غير مدعومة.',
            'Image.max'             => 'حجم الصورة يجب ألا يتجاوز 2 ميجا بايت.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // رفع الصورة
        $image = $request->file('Image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('products');
        $image->move($destinationPath, $imageName);

        // إنشاء المنتج
        $product = new Product();
        $product->product_name   = $request->input('product_name');
        $product->Price          = $request->input('Price');
        $product->Category_id    = $request->input('Category_id');
        $product->Description    = $request->input('Description');
        $product->supermarket_id = $supermarket_id;
        $product->Image          = $imageName;
        $product->save();

        return response()->json(['message' => 'تم إضافة المنتج بنجاح!', 'product' => $product], 201);
    }

    // تحديث منتج موجود
    public function update(Request $request, $supermarket_id, $id)
    {
        // التحقق من السوبرماركت والمنتج
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        $product = Product::find($id);
        if (!$product || $product->supermarket_id != $supermarket->id) {
            return response()->json(['message' => 'المنتج غير موجود أو لا ينتمي للسوبرماركت'], 404);
        }

        $rules = [
            'product_name' => 'required|string|max:255',
            'Price'        => 'required|numeric',
            'Category_id'  => 'required',
            'Description'  => 'nullable|string',
            // الصورة اختيارية للتحديث
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->product_name = $request->input('product_name');
        $product->Price        = $request->input('Price');
        $product->Category_id  = $request->input('Category_id');
        $product->Description  = $request->input('Description');

        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('products'), $imagename);
            $product->Image = $imagename;
        }

        $product->save();
        return response()->json(['message' => 'تم تعديل المنتج بنجاح!', 'product' => $product]);
    }

    // حذف منتج
    public function destroy($supermarket_id, $id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        $product = Product::find($id);
        if (!$product || $product->supermarket_id != $supermarket->id) {
            return response()->json(['message' => 'المنتج غير موجود أو لا ينتمي للسوبرماركت'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'تم حذف المنتج بنجاح']);
    }
}
