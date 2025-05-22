@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('import_errors'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تنبيه!</p>
            <p>تم استيراد بعض المنتجات بنجاح، ولكن هناك أخطاء في بعض المنتجات:</p>
            <ul class="list-disc mr-6 mt-2">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">خطأ!</p>
            <ul class="list-disc mr-6 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- الحاوية الخارجية -->
    <div class="container mx-auto px-4 py-8 max-h-screen overflow-y-auto">
        <!-- بطاقة استيراد المنتجات -->
        <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="bi bi-file-earmark-excel ml-2"></i> استيراد المنتجات من ملف إكسل
                </h2>
                <div>
                    <a href="{{ route('show_Product', ['supermarket_id' => $supermarket->id]) }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        <i class="bi bi-arrow-right ml-1"></i> رجوع
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- قسم استيراد الملف -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6 space-y-6">
                            <form action="{{ route('import_products', ['supermarket_id' => $supermarket->id]) }}" 
                                  method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf
                                
                                <!-- شرح الاستيراد -->
                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="bi bi-info-circle-fill text-blue-500 text-lg"></i>
                                        </div>
                                        <div class="mr-3">
                                            <h3 class="text-blue-800 font-semibold mb-1">كيفية استيراد المنتجات</h3>
                                            <p class="text-blue-700 text-sm">
                                                قم بتحميل القالب أدناه، وإضافة بياناتك ثم رفع الملف مرة أخرى لاستيراد المنتجات دفعة واحدة.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- حقل رفع الملف -->
                                <div class="mb-4">
                                    <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                                        ملف إكسل <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center">
                                        <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-indigo-500 rounded-lg border-2 border-dashed border-indigo-500 cursor-pointer hover:bg-indigo-50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="mt-2 text-sm text-gray-600">اختر ملف Excel أو اسحبه هنا</span>
                                            <span class="text-xs text-gray-500 mt-1">(.xlsx, .xls)</span>
                                            <input type="file" name="excel_file" id="excel_file" class="hidden" accept=".xlsx, .xls" required>
                                        </label>
                                    </div>
                                    <div id="file-name" class="mt-2 text-sm text-gray-600"></div>
                                </div>

                                <!-- زر التحميل والعودة -->
                                <div class="flex items-center justify-end space-x-4 space-x-reverse mt-6">
                                    <a href="{{ route('download_excel_template', ['supermarket_id' => $supermarket->id]) }}" 
                                       class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                        <i class="bi bi-download ml-1"></i> تحميل قالب
                                    </a>
                                    <button type="submit" id="submit-btn" disabled
                                            class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300 opacity-50 cursor-not-allowed">
                                        <i class="bi bi-upload ml-1"></i> استيراد المنتجات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- قسم المعلومات الإضافية -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-gray-600 text-sm font-medium mb-4">
                                <i class="bi bi-info-circle-fill mr-1"></i>
                                إرشادات الاستيراد
                            </h3>
                            
                            <ul class="text-gray-700 space-y-3 text-sm">
                                <li class="flex items-start">
                                    <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                                    <span>يجب أن يحتوي الملف على الأعمدة التالية (باللغة الإنجليزية): اسم المنتج (product_name)، السعر (price)، رقم الفئة (category_id).</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                                    <span>معرف الفئة (category_id) يجب أن يكون موجوداً في النظام.</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                                    <span>سيتم استخدام صورة افتراضية للمنتجات المضافة، ويمكنك تعديلها لاحقاً.</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                                    <span>احرص على أن تكون الأسعار بصيغة رقمية صحيحة.</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                                    <span>يمكنك إضافة معلومات اختيارية مثل الوصف (description) والباركود (barcode).</span>
                                </li>
                            </ul>

                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-600 mb-2">الفئات المتاحة:</h4>
                                <div class="max-h-48 overflow-y-auto pr-2">
                                    <table class="min-w-full">
                                        <thead>
                                            <tr>
                                                <th class="text-right px-2 py-2 text-xs font-medium text-gray-500">المعرّف</th>
                                                <th class="text-right px-2 py-2 text-xs font-medium text-gray-500">اسم الفئة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\Models\Category::all() as $category)
                                                <tr>
                                                    <td class="px-2 py-1 text-xs text-gray-600">{{ $category->id }}</td>
                                                    <td class="px-2 py-1 text-xs text-gray-600">{{ $category->CategoryName }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // عرض اسم الملف المختار
        document.getElementById('excel_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            const fileNameElement = document.getElementById('file-name');
            const submitBtn = document.getElementById('submit-btn');
            
            if (fileName) {
                fileNameElement.textContent = `تم اختيار: ${fileName}`;
                fileNameElement.classList.add('text-green-600');
                
                // تفعيل زر الإرسال
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                fileNameElement.textContent = '';
                
                // تعطيل زر الإرسال
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
@endsection
