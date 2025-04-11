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
                <form action="{{ route('update_product_confirm', ['supermarket_id' => $supermarket->id, 'product_id' => $product->id]) }}" method="POST"  enctype="multipart/form-data" class="space-y-6">
                    @csrf
            
                    
                    <!-- اسم المنتج -->
                    <div class="mb-4">
                                    <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        اسم المنتج <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="product_name" id="product_name" 
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                        placeholder="أدخل اسم المنتج" required value="{{$product->product_name}}">
                                </div>
                                
                                <!-- السعر -->
                                <div class="mb-4">
                                    <label for="Price" class="block text-sm font-medium text-gray-700 mb-2">
                                        السعر <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex">
                                        <input type="number" name="Price" id="Price" step="0.01" min="0"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                            placeholder="0.00" required  value="{{$product->Price}}">
                                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                                          ر.ي
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">صورة المنتج</h2>
                            
                            <div class="flex flex-col md:flex-row items-start gap-6">
                                <!-- Current Profile Image -->
                                <div class="flex-shrink-0">
                                    <div class="w-40 h-40 bg-gray-100 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                    
                                            <img src="{{ asset('products/'.$product->Image) }}"
                                                alt="صورة المنتج" class="w-full h-full object-cover">
                                        
                                    </div>
                                </div>
                                
                                <!-- Upload New Image -->
                                <div class="flex-grow space-y-4">
                                    <label for="Image" class="block text-gray-700 font-medium">
                                        تحديث صورةالمنتج
                                    </label>
                                    
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg px-6 py-8 text-center hover:bg-gray-50 transition-colors">
                                        <input type="file" name="Image" id="Image" class="hidden" accept="image/*">
                                        <label for="Image" class="cursor-pointer">
                                            <div class="text-center">
                                                <i class="bi bi-cloud-arrow-up text-4xl text-gray-400"></i>
                                                <p class="mt-2 text-sm text-gray-600">اضغط هنا لتحميل صورة جديدة</p>
                                                <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF حتى 5MB</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    @error('Image')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                    @enderror
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
                                            <option value="{{$product->Category_id}}" selected="">{{$product->Category_id}}</option>
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
                                <input name="Description" id="Description" rows="4"
                                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="أدخل وصفاً تفصيلياً للمنتج..."value="{{$product->Description}}"></input>
                            </div>
                            
                            <!-- أزرار الإرسال وإعادة التعيين -->
                            <div class="flex items-center justify-end space-x-4 space-x-reverse">
                                <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <i class="bi bi-arrow-repeat ml-1"></i>
                                    إعادة تعيين
                                </button>
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <i class="bi bi-plus-circle ml-1"></i>
                                    إضافة المنتج
                                </button>
                            </div>
                        </form>
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
