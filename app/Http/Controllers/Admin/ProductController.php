<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Offers;
use App\Models\SuperMarket;
use Illuminate\Http\Request;

 use Illuminate\Support\Facades\Validator;
 
class ProductController extends Controller
{
    
    public function searchProduct(Request $request)
    {
        $search = $request->input('search');  // استلام كلمة البحث

        // البحث عن المنتجات
        $products = Product::where('product_name', 'LIKE', "%$search%")->get();

        // تمرير المنتجات إلى العرض
        return view('admin.show_Product', compact('products'));
    }
    public function view_product($supermarket_id){
        $category = Category::all();
        $supermarket = SuperMarket::find($supermarket_id);
       
        return view('admin.product', compact('category', 'supermarket'));
    }
   



   

public function add_products(Request $request, $supermarket_id)
{
    // تعريف قواعد التحقق ورسائل الخطأ المخصصة
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
        'Price.numeric'         => 'يجب أن يكون السعر رقمًا.',
        'Category_id.required'  => 'يرجى اختيار الفئة.',
        'Description.required'  => 'يرجى إدخال وصف المنتج.',
        'Image.required'        => 'يرجى اختيار صورة.',
        'Image.image'           => 'يجب أن يكون الملف صورة.',
        'Image.mimes'           => 'نوع الصورة غير مدعوم، يجب أن تكون jpeg, png, jpg, gif, svg.',
        'Image.max'             => 'حجم الصورة يجب أن لا يتجاوز 2 ميجا بايت.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    // إذا فشل التحقق، يتم إعادة التوجيه مع رسائل الخطأ المخصصة
    if ($validator->fails()) {
        // يمكنك دمج كل رسائل الخطأ في رسالة واحدة إذا رغبت
        $errorMessages = $validator->errors()->all();
        return redirect()->back()->withErrors(['message' => implode(' ', $errorMessages)])->withInput();
    }

    // معالجة رفع الصورة
    $image = $request->file('Image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $destinationPath = public_path('products');
    $image->move($destinationPath, $imageName);

    // إنشاء المنتج وتعبئة الحقول
    $product = new Product();
    $product->product_name   = $request->input('product_name');
    $product->Price          = $request->input('Price');
    $product->Category_id    = $request->input('Category_id');
    $product->Description    = $request->input('Description');
    $product->supermarket_id = $supermarket_id;
    $product->Image          = $imageName;

    $product->save();

    return redirect()->back()->with('success', 'تم إضافة المنتج بنجاح!');
}



public function show_Product(Request $request)
{
    // جلب المنتجات بناءً على البحث أو بدونها
    $products = Product::query();

    if ($request->has('search')) {
        $products->where('product_name', 'like', '%' . $request->search . '%');
    }
    
    $products = $products->paginate(10);

    // جلب جميع الفئات
    $category = Category::all();

    return view('admin.show_Product', compact('products', 'category'));
}
    

   
     

     
     public function delete_product($id){
        $product=Product::find($id);
        $product->delete();
        return redirect()->back()->with('message','product Deleted Successfully');


     }

    
     public function update_product($supermarket_id,$id){
        $product=Product::find($id);
        $category= category::all();
        $supermarket = SuperMarket::find($supermarket_id);
        return view('admin.update_product',compact('product','category','supermarket'));

     }

    

     public function update_product_confirm(Request $request, $supermarket_id, $id)
     {
         // التحقق من صحة البيانات المُرسلة
         $validator = Validator::make($request->all(), [
             'product_name' => 'required|string|max:255',
             'Price'        => 'required|numeric',
             'Category_id'  => 'required',
             'Description'  => 'nullable|string',
         ], [
             'product_name.required' => 'يرجى إدخال اسم المنتج.',
             'Price.required'        => 'يرجى إدخال السعر.',
             'Price.numeric'         => 'يجب أن يكون السعر رقميًا.',
             'Category_id.required'  => 'يرجى اختيار الفئة.',
         ]);
     
         if ($validator->fails()) {
             // إعادة التوجيه مع رسائل الخطأ والبيانات القديمة
             return redirect()->back()->withErrors($validator)->withInput();
         }
     
         // البحث عن السوبرماركت بناءً على المعرف
         $supermarket = SuperMarket::find($supermarket_id);
         if (!$supermarket) {
             return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
         }
     
         // البحث عن المنتج بناءً على المعرف
         $product = Product::find($id);
         if (!$product) {
             return redirect()->back()->withErrors(['message' => 'المنتج غير موجود']);
         }
     
         // التأكد من أن المنتج ينتمي للسوبرماركت الحالي
         if ($product->supermarket_id != $supermarket->id) {
             return redirect()->back()->withErrors(['message' => 'المنتج لا ينتمي إلى هذا السوبرماركت']);
         }
     
         // تحديث بيانات المنتج
         $product->product_name = $request->product_name;
         $product->Price        = $request->Price;
         $product->Category_id  = $request->Category_id;
         $product->Description  = $request->Description;
     
         // التحقق من رفع صورة جديدة
         if ($request->hasFile('image')) {
             $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
             $request->file('image')->move(public_path('products'), $imagename);
             $product->Image = $imagename;
         }
     
         $product->save();
     
         return redirect()->back()->with('success', 'تم تعديل المنتج بنجاح!');
     }
     


   

}
