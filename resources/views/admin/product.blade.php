@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- الحاوية الخارجية مع تمرير رأسي إذا تجاوز المحتوى ارتفاع الشاشة -->
    <div class="container mx-auto px-4 py-8 max-h-screen overflow-y-auto">
        <!-- بطاقة الملف الشخصي -->
        <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="bi bi-box-seam ml-2"></i>    إضافة منتج جديد
                </h2>
            </div>

            <!-- نموذج التعديل داخل منطقة قابلة للتمرير أفقي (إن لزم الأمر) -->
            <div class="overflow-x-auto">
                <form action="{{ route('add_products', ['supermarket_id' => $supermarket->id]) }}" method="POST"  enctype="multipart/form-data" class="space-y-6">
                    @csrf
            
                    
                    <!-- اسم المنتج -->
                    <div class="mb-4">
                                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        اسم المنتج <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="product_name" id="product_name" 
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                        placeholder="أدخل اسم المنتج" required>
                                </div>
                                
                                <!-- السعر -->
                                <div class="mb-4">
                                    <label for="Price" class="block text-sm font-medium text-gray-700 mb-2">
                                        السعر <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex">
                                        <input type="number" name="Price" id="Price" step="0.01" min="0"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                            placeholder="0.00" required>
                                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                                            ر.س
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- صورة المنتج -->
                                <div class="mb-4">
                                    <label for="Image" class="block text-sm font-medium text-gray-700 mb-2">
                                        صورة المنتج <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center">
                                        <label class="w-full flex flex-col items-center px-4 py-6 bg-white text-green-500 rounded-lg border-2 border-dashed border-green-500 cursor-pointer hover:bg-green-50">
                                            <i class="bi bi-cloud-arrow-up text-2xl"></i>
                                            <span class="mt-2 text-sm text-gray-600">اختر صورة أو اسحبها هنا</span>
                                            <input type="file" name="Image" id="Image" class="hidden" accept="image/*" required>
                                        </label>
                                    </div>
                                    <div id="image-preview" class="mt-2 hidden">
                                        <div class="relative">
                                            <img id="preview" src="#" alt="معاينة" class="w-24 h-24 object-cover rounded">
                                            <button type="button" id="remove-image" 
                                                class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 shadow-sm">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- الفئة -->
                                <div class="mb-4">
                                    <label for="Category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        الفئة <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="Category_id" id="Category_id" 
                                            class="appearance-none w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                            required>
                                            <option value="" selected="">اختر فئة</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->CategoryName }}</option>
                        @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 left-0 flex items-center px-3 pointer-events-none">
                                            <i class="bi bi-chevron-down text-gray-500"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- وصف المنتج -->
                            <div class="mb-6">
                                <label for="Description" class="block text-sm font-medium text-gray-700 mb-2">
                                    وصف المنتج
                                </label>
                                <textarea name="Description" id="Description" rows="4"
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="أدخل وصفاً تفصيلياً للمنتج..."></textarea>
                            </div>
                            
                            <!-- الباركود -->
<div class="mb-4">
    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">
        الباركود (اختياري)
    </label>
    <input type="text" name="barcode" id="barcode" 
        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
        placeholder="أدخل كود الباركود إن وجد">
    <p class="text-xs text-gray-500 mt-1">أدخل الباركود من خلف المنتج إن كان متوفراً، أو اتركه فارغاً.</p>
</div>

                            

                            
                            <!-- أزرار الإرسال وإعادة التعيين -->
                            <div class="flex items-center justify-end space-x-4 space-x-reverse">
                                <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <i class="bi bi-arrow-repeat ml-1"></i>
                                    إعادة تعيين
                                </button>
                                <button type="submit" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                                    <i class="bi bi-plus-circle ml-1"></i>
                                    إضافة المنتج
                                </button>
                            </div>
                        </form>
            </div>
               <!-- قسم المعلومات الإضافية -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden form-card">
          
          <div class="p-6">
          <h3 class="text-gray-600 text-sm font-medium mb-4">
                  <i class="bi bi-info-circle-fill mr-1"></i>
                  ملاحظات هامة 
              </h3>
              
              <ul class="text-gray-700 space-y-2">
                  <li class="flex items-start">
                      <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                      <span>احرص على اضافة الفئة عند اسم المنتج ( مثلا كجم) لكي يتم عرضها بشكل صحيح والمكان المناسب للعملاء في تطبيق الجوال</span>
                  </li>
                  <li class="flex items-start">
                      <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                      <span>احرص على اضافة صورة ذات جودة عالية</span>
                  </li>
                  <li class="flex items-start">
                      <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                      <span>احرص على الاضافة باللغة العربية .</span>
                  </li>
              </ul>
          </div>
      </div>
        </div>
    
        </div>
    </div>
    <script>
        // معاينة الصورة
        document.getElementById('Image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('image-preview');
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // إزالة الصورة
        document.getElementById('remove-image').addEventListener('click', function() {
            const input = document.getElementById('Image');
            const imagePreview = document.getElementById('image-preview');
            
            input.value = '';
            imagePreview.classList.add('hidden');
        });
        
        // محاكاة إرسال النموذج
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // التحقق من صحة النموذج
            if (this.checkValidity()) {
                // محاكاة النجاح - في التطبيق الفعلي، سيكون هناك طلب AJAX
                document.getElementById('success-message').classList.remove('hidden');
                
                // إعادة تعيين النموذج بعد 2 ثانية
                setTimeout(() => {
                    this.reset();
                    document.getElementById('image-preview').classList.add('hidden');
                    document.getElementById('success-message').classList.add('hidden');
                }, 2000);
            } else {
                document.getElementById('error-message').classList.remove('hidden');
                
                setTimeout(() => {
                    document.getElementById('error-message').classList.add('hidden');
                }, 2000);
            }
        });
    </script>

@endsection
