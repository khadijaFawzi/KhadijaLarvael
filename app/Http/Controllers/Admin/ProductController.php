<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Offers;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('product_name', 'LIKE', "%$search%")->get();
        return view('admin.show_Product', compact('products'));
    }

    public function view_product($supermarket_id)
    {
        $category = Category::all();
        $supermarket = SuperMarket::find($supermarket_id);
        return view('admin.product', compact('category', 'supermarket'));
    }

    public function add_products(Request $request, $supermarket_id)
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'Price'        => 'required|numeric',
            'Category_id'  => 'required',
            'Description'  => 'required|string',
            'Image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'barcode'      => 'nullable|string|max:100',
        ];

        $messages = [
            'product_name.required' => 'يرجى إدخال اسم المنتج.',
            'Price.required'        => 'يرجى إدخال السعر.',
            'Price.numeric'         => 'يجب أن يكون السعر رقمًا.',
            'Category_id.required'  => 'يرجى اختيار الفئة.',
            'Description.required'  => 'يرجى إدخال وصف المنتج.',
            'Image.required'        => 'يرجى اختيار صورة.',
            'Image.image'           => 'يجب أن يكون الملف صورة.',
            'Image.mimes'           => 'نوع الصورة غير مدعوم.',
            'Image.max'             => 'حجم الصورة يجب أن لا يتجاوز 2 ميجا بايت.',
            'barcode.max'           => 'الباركود لا يجب أن يتجاوز 100 حرف.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            return redirect()->back()->withErrors(['message' => implode(' ', $errorMessages)])->withInput();
        }

        $image = $request->file('Image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('products'), $imageName);

        $product = new Product();
        $product->product_name   = $request->input('product_name');
        $product->Price          = $request->input('Price');
        $product->Category_id    = $request->input('Category_id');
        $product->Description    = $request->input('Description');
        $product->supermarket_id = $supermarket_id;
        $product->Image          = $imageName;
        $product->barcode        = $request->input('barcode');

        $product->save();

        return redirect()->back()->with('success', 'تم إضافة المنتج بنجاح!');
    }

 public function show_Product(Request $request, $supermarket_id)
{
    $products = Product::where('supermarket_id', $supermarket_id);

    if ($request->has('search')) {
        $products->where('product_name', 'like', '%' . $request->search . '%');
    }

    $products = $products->paginate(10);
    $category = Category::all();

    $supermarket = SuperMarket::find($supermarket_id);

    return view('admin.show_Product', compact('products', 'category', 'supermarket'));
}



    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message', 'تم حذف المنتج بنجاح.');
    }

    public function update_product($supermarket_id, $id)
    {
        $product = Product::find($id);
        $category = Category::all();
        $supermarket = SuperMarket::find($supermarket_id);
        return view('admin.update_product', compact('product', 'category', 'supermarket'));
    }

    public function update_product_confirm(Request $request, $supermarket_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'Price'        => 'required|numeric',
            'Category_id'  => 'required',
            'Description'  => 'nullable|string',
            'barcode'      => 'nullable|string|max:100',
        ], [
            'product_name.required' => 'يرجى إدخال اسم المنتج.',
            'Price.required'        => 'يرجى إدخال السعر.',
            'Price.numeric'         => 'يجب أن يكون السعر رقميًا.',
            'Category_id.required'  => 'يرجى اختيار الفئة.',
            'barcode.max'           => 'الباركود لا يجب أن يتجاوز 100 حرف.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
        }

        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->withErrors(['message' => 'المنتج غير موجود']);
        }

        if ($product->supermarket_id != $supermarket->id) {
            return redirect()->back()->withErrors(['message' => 'المنتج لا ينتمي إلى هذا السوبرماركت']);
        }

        $product->product_name = $request->product_name;
        $product->Price        = $request->Price;
        $product->Category_id  = $request->Category_id;
        $product->Description  = $request->Description;
        $product->barcode      = $request->barcode;

        if ($request->hasFile('image')) {
            $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('products'), $imagename);
            $product->Image = $imagename;
        }

        $product->save();

        return redirect()->back()->with('success', 'تم تعديل المنتج بنجاح!');
    }












    //  public function importProductsForm($supermarket_id)
    // {
    //     $supermarket = SuperMarket::find($supermarket_id);
    //     if (!$supermarket) {
    //         return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
    //     }
        
    //     return view('admin.import_products', compact('supermarket'));
    // }

    // /**
    //  * معالجة استيراد المنتجات من ملف إكسل
    //  */
    // public function importProducts(Request $request, $supermarket_id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'excel_file' => 'required|file|mimes:xlsx,xls|max:10240',
    //     ], [
    //         'excel_file.required' => 'يرجى اختيار ملف إكسل.',
    //         'excel_file.file' => 'يجب أن يكون الملف صالحًا.',
    //         'excel_file.mimes' => 'يجب أن يكون الملف بتنسيق Excel (.xlsx أو .xls).',
    //         'excel_file.max' => 'حجم الملف يجب أن لا يتجاوز 10 ميجابايت.',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $supermarket = SuperMarket::find($supermarket_id);
    //     if (!$supermarket) {
    //         return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
    //     }

    //     try {
    //         $file = $request->file('excel_file');
    //         $spreadsheet = IOFactory::load($file->getPathname());
    //         $worksheet = $spreadsheet->getActiveSheet();
    //         $rows = $worksheet->toArray();
            
    //         // تخطي الصف الأول إذا كان يحتوي على العناوين
    //         $headers = array_shift($rows);
            
    //         // التحقق من وجود الأعمدة المطلوبة
    //         $requiredColumns = ['product_name', 'price', 'category_id', 'description', 'barcode'];
    //         $columnIndexes = [];
            
    //         foreach ($headers as $index => $header) {
    //             $header = trim(strtolower($header));
    //             if (in_array($header, $requiredColumns)) {
    //                 $columnIndexes[$header] = $index;
    //             }
    //         }
            
    //         // التحقق من وجود الأعمدة الإلزامية على الأقل
    //         if (!isset($columnIndexes['product_name']) || !isset($columnIndexes['price']) || !isset($columnIndexes['category_id'])) {
    //             return redirect()->back()->withErrors(['message' => 'الملف لا يحتوي على الأعمدة المطلوبة الأساسية (اسم المنتج، السعر، معرف الفئة).']);
    //         }
            
    //         $successCount = 0;
    //         $errorCount = 0;
    //         $errors = [];
            
    //         foreach ($rows as $index => $row) {
    //             // تخطي الصفوف الفارغة
    //             if (empty($row[$columnIndexes['product_name']])) {
    //                 continue;
    //             }
                
    //             try {
    //                 // إنشاء منتج جديد
    //                 $product = new Product();
    //                 $product->product_name = $row[$columnIndexes['product_name']];
    //                 $product->Price = $row[$columnIndexes['price']];
    //                 $product->Category_id = $row[$columnIndexes['category_id']];
    //                 $product->supermarket_id = $supermarket_id;
                    
    //                 // تعيين الحقول الاختيارية إذا كانت موجودة
    //                 if (isset($columnIndexes['description'])) {
    //                     $product->Description = $row[$columnIndexes['description']] ?? '';
    //                 }
                    
    //                 if (isset($columnIndexes['barcode'])) {
    //                     $product->barcode = $row[$columnIndexes['barcode']] ?? '';
    //                 }
                    
    //                 // تعيين صورة افتراضية إذا كانت غير موجودة
    //                 $product->Image = 'default_product.jpg';
                    
    //                 // حفظ المنتج
    //                 $product->save();
    //                 $successCount++;
    //             } catch (\Exception $e) {
    //                 $errorCount++;
    //                 $errors[] = "خطأ في الصف " . ($index + 2) . ": " . $e->getMessage();
    //             }
    //         }
            
    //         $message = "تم استيراد {$successCount} منتج بنجاح.";
    //         if ($errorCount > 0) {
    //             $message .= " فشل استيراد {$errorCount} منتج.";
    //         }
            
    //         return redirect()->route('show_Product', ['supermarket_id' => $supermarket_id])
    //             ->with('success', $message)
    //             ->with('import_errors', $errors);
                
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['message' => 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage()]);
    //     }
    // }

    // /**
    //  * تنزيل قالب إكسل للمنتجات
    //  */
    // public function downloadExcelTemplate($supermarket_id)
    // {
    //     $supermarket = SuperMarket::find($supermarket_id);
    //     if (!$supermarket) {
    //         return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
    //     }
        
    //     // إنشاء ملف Excel جديد
    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
        
    //     // تعيين العناوين
    //     $sheet->setCellValue('A1', 'product_name');
    //     $sheet->setCellValue('B1', 'price');
    //     $sheet->setCellValue('C1', 'category_id');
    //     $sheet->setCellValue('D1', 'description');
    //     $sheet->setCellValue('E1', 'barcode');
        
    //     // تنسيق العناوين
    //     $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        
    //     // إضافة بيانات الفئات للمساعدة
    //     $categories = Category::all();
    //     $row = 3;
    //     $sheet->setCellValue('G3', 'معرفات الفئات المتاحة:');
    //     $sheet->getStyle('G3')->getFont()->setBold(true);
        
    //     foreach ($categories as $category) {
    //         $row++;
    //         $sheet->setCellValue('G' . $row, $category->id . ' - ' . $category->CategoryName);
    //     }
        
    //     // إنشاء ملف Excel
    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    //     $fileName = 'products_template_' . $supermarket->name . '.xlsx';
    //     $tempPath = storage_path('app/public/' . $fileName);
    //     $writer->save($tempPath);
        
    //     return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    // }


    
}
