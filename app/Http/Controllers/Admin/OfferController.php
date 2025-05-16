<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Offers;
use App\Models\SuperMarket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OfferController extends Controller
{
    // ضف الطرق الجديدة بعد الطرق الحالية
    
    public function offers_process($supermarket_id)
    {
        $supermarket = SuperMarket::find($supermarket_id);
        $product=Product::all();
        return view('admin.offersProces', compact('supermarket','product'));
    }

    public function process_offer_image(Request $request, $supermarket_id)
    {
        // تأكد من التحقق من صحة البيانات المرسلة وإضافة التحقق من المنتج
        $validator = Validator::make($request->all(), [
            'image'      => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_id' => 'required|exists:products,id', // تحقق أن المنتج موجود
        ], [
            'image.required'      => 'يرجى اختيار صورة',
            'image.image'         => 'الملف المختار يجب أن يكون صورة',
            'image.mimes'         => 'صيغة الصورة غير مدعومة (jpeg, png, jpg, gif)',
            'image.max'           => 'حجم الصورة يجب ألا يتجاوز 2 ميجا بايت',
            'product_id.required' => 'يرجى اختيار منتج',
            'product_id.exists'   => 'المنتج المحدد غير موجود',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // حفظ الصورة
        $imagename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('offers'), $imagename);
    
        // إنشاء سجل العرض وتعيين الحقول المطلوبة
        $offer = new Offers();
        $offer->supermarket_id = $supermarket_id;
        $offer->product_id     = $request->input('product_id'); // إضافة قيمة المنتج لتفادي الخطأ
        $offer->image          = $imagename;
        $offer->save();
    
        // تحليل الصورة
        $this->analyzeOfferImage($offer);
    
        return redirect()->route('edit_ai_offer', ['supermarket_id' => $supermarket_id, 'id' => $offer->id])
            ->with('success', 'تم رفع الصورة وتحليلها بنجاح. يرجى مراجعة المعلومات المستخرجة وتعديلها إذا لزم الأمر.');
    }
    
    public function edit_ai_offer($supermarket_id, $id)
    {
        $offer = Offers::find($id);
        if (!$offer) {
            return redirect()->back()->withErrors(['message' => 'العرض غير موجود']);
        }
        
        $supermarket = SuperMarket::find($supermarket_id);
        if (!$supermarket) {
            return redirect()->back()->withErrors(['message' => 'السوبرماركت غير موجود']);
        }
        
        $products = Product::all();
        
        return view('admin.edit_ai_offer', compact('offer', 'supermarket', 'products'));
    }
    
    public function update_ai_offer(Request $request, $supermarket_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'Description' => 'nullable|string',
        ], [
            'product_id.required' => 'يرجى اختيار المنتج',
            'product_id.exists' => 'المنتج المحدد غير موجود',
            'start_date.required' => 'يرجى إدخال تاريخ بدء العرض',
            'start_date.date' => 'تاريخ بدء العرض غير صالح',
            'end_date.required' => 'يرجى إدخال تاريخ انتهاء العرض',
            'end_date.date' => 'تاريخ انتهاء العرض غير صالح',
            'end_date.after_or_equal' => 'يجب أن يكون تاريخ انتهاء العرض بعد أو يساوي تاريخ بدء العرض',
            'discount_percentage.required' => 'يرجى إدخال نسبة التخفيض',
            'discount_percentage.numeric' => 'يجب أن تكون نسبة التخفيض رقمية',
            'discount_percentage.min' => 'يجب أن تكون نسبة التخفيض على الأقل 0',
            'discount_percentage.max' => 'يجب ألا تزيد نسبة التخفيض عن 100',
            'Description.string' => 'الوصف يجب أن يكون نصاً',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $offer = Offers::find($id);
        if (!$offer) {
            return redirect()->back()->withErrors(['message' => 'العرض غير موجود']);
        }
        
       // $offer->Product_id = $request->product_id;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->discount_percentage = $request->discount_percentage;
        $offer->Description = $request->Description;
        $offer->is_verified = true;
        $offer->save();
        
        return redirect()->route('Show_offersProces', ['supermarket_id' => $supermarket_id])
            ->with('success', 'تم تحديث العرض بنجاح');
    }
    
    private function analyzeOfferImage(Offers $offer)
    {
        $imagePath = public_path('offers/' . $offer->image);
        
        try {
            // استخدام Tesseract OCR لاستخراج النص من الصورة
            $tesseract = new TesseractOCR($imagePath);
            $tesseract->lang('ara', 'eng'); // دعم اللغة العربية والإنجليزية
            $extractedText = $tesseract->run();
            
            // استخراج المعلومات من النص
            $discount = $this->extractDiscount($extractedText);
            $dates = $this->extractDates($extractedText);
            $productName = $this->extractProductName($extractedText);
            
            // محاولة العثور على المنتج المناسب
            $product = null;
            if (!empty($productName)) {
                $product = Product::where('product_name', 'LIKE', "%$productName%")->first();
            }
            
            // تحديث العرض بالبيانات المستخرجة
            $updateData = [
                'extracted_text' => $extractedText,
                'is_ai_processed' => true
            ];
            
            if ($product) {
                $updateData['Product_id'] = $product->id;
            }
            
            if (!empty($discount)) {
                $updateData['discount_percentage'] = $discount;
            }
            
            if (!empty($dates['start_date'])) {
                $updateData['start_date'] = $dates['start_date'];
            }
            
            if (!empty($dates['end_date'])) {
                $updateData['end_date'] = $dates['end_date'];
            }
            
            $offer->update($updateData);
            
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، احتفظ بمعلومات الخطأ
            $offer->update([
                'extracted_text' => 'خطأ في تحليل الصورة: ' . $e->getMessage(),
                'is_ai_processed' => false
            ]);
        }
    }
    
    private function extractDiscount($text)
    {
        // استخراج نسبة الخصم من النص
        if (preg_match('/خصم\s*(\d+)%/i', $text, $matches) || 
            preg_match('/(\d+)%\s*خصم/i', $text, $matches) ||
            preg_match('/تخفيض\s*(\d+)%/i', $text, $matches)) {
            return (float) $matches[1];
        }
        
        // البحث عن أي رقم متبوع بعلامة %
        if (preg_match('/(\d+)%/i', $text, $matches)) {
            return (float) $matches[1];
        }
        
        return null;
    }
    
    private function extractDates($text)
    {
        $dates = [
            'start_date' => null,
            'end_date' => null
        ];
        
        // البحث عن تاريخ البدء
        if (preg_match('/من\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/i', $text, $matches)) {
            $dates['start_date'] = $this->formatDate($matches[1]);
        }
        
        // البحث عن تاريخ الانتهاء
        if (preg_match('/إلى\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/i', $text, $matches) ||
            preg_match('/حتى\s*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/i', $text, $matches)) {
            $dates['end_date'] = $this->formatDate($matches[1]);
        }
        
        // إذا لم يتم العثور على تواريخ واضحة، يمكن استخدام التاريخ الحالي كتاريخ بدء
        // وإضافة شهر واحد كتاريخ انتهاء
        if (is_null($dates['start_date'])) {
            $dates['start_date'] = date('Y-m-d');
        }
        
        if (is_null($dates['end_date'])) {
            $dates['end_date'] = date('Y-m-d', strtotime('+1 month'));
        }
        
        return $dates;
    }
    
    private function formatDate($dateString)
    {
        // تحويل التاريخ إلى تنسيق Y-m-d
        $date = str_replace(['/', '.'], '-', $dateString);
        $parts = explode('-', $date);
        
        // التحقق من عدد الأجزاء
        if (count($parts) != 3) {
            return null;
        }
        
        // التحقق من تنسيق التاريخ (يوم-شهر-سنة أو سنة-شهر-يوم)
        if (strlen($parts[2]) == 4) {
            // تنسيق يوم-شهر-سنة
            return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
        } elseif (strlen($parts[0]) == 4) {
            // تنسيق سنة-شهر-يوم
            return $dateString;
        } else {
            // تنسيق غير معروف، نفترض يوم-شهر-سنة مع إضافة 2000 للسنة إذا كانت أقل من 100
            $year = (int)$parts[2];
            if ($year < 100) {
                $year += 2000;
            }
            return "$year-{$parts[1]}-{$parts[0]}";
        }
    }
    
    private function extractProductName($text)
    {
        // نقسم النص إلى أسطر
        $lines = explode("\n", $text);
        
        // نبحث عن سطر يبدأ بكلمة "منتج" أو يحتوي على اسم محتمل للمنتج
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos(strtolower($line), 'منتج') === 0 || 
                strpos(strtolower($line), 'اسم المنتج') !== false) {
                // نزيل كلمة "منتج" أو "اسم المنتج" من بداية السطر
                $productName = preg_replace('/(منتج|اسم المنتج)[:]*\s*/i', '', $line);
                return trim($productName);
            }
        }
        
        // إذا لم نجد سطر يبدأ بكلمة "منتج"، نفترض أن أول سطر يحتوي على اسم المنتج
        // أو نبحث عن سطر طويل نسبيًا
        foreach ($lines as $line) {
            $line = trim($line);
            if (strlen($line) > 10 && !preg_match('/\d+%|\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}/', $line)) {
                return $line;
            }
        }
        
        return null;
    }
   
    public function show_offers($supermarket_id) {
        $offers = Offers::with('product')->where('supermarket_id', $supermarket_id)->get();
        $supermarket = SuperMarket::find($supermarket_id);
        $category = Category::all();
        return view('admin.show_offers', compact('offers', 'supermarket','category'));
    }
    
    public function view_offers(){
        $product=Product::all();
        return view('admin.offers',compact('product'));
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
    public function Show_offersProces($supermarket_id)
    {
        
    // جلب بيانات السوبرماركت بناءً على المعرف
    $supermarket = Supermarket::find($supermarket_id);
    
    // التأكد من أن السوبرماركت موجود، وإلا يمكن إعادة توجيه المستخدم أو عرض خطأ
    if (!$supermarket) {
        return redirect()->back()->with('message', 'السوبرماركت غير موجود');
    }
    
    // جلب العروض الخاصة بالسوبرماركت
    $offers = Offers::where('supermarket_id', $supermarket->id)->get();
    
    // تمرير المتغيرات إلى الـ view باستخدام الدالة compact أو مصفوفة
    return view('admin.Show_offersProces', compact('supermarket', 'offers'));

    /* أو يمكنك استخدام الطريقة التالية:
    
    return view('admin.Show_offersProces', [
        'supermarket' => $supermarket,
        'offers' => $offers
    ]);
    */
    }

}