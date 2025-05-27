@extends('general-management.layout')

@section('content')

<!-- إشعارات النجاح -->
@if(session('success'))
<div class="alert-container animate__animated animate__fadeIn">
    <div class="bg-green-50 border-r-4 border-green-500 rounded-lg p-4 mb-6 shadow-lg flex items-center">
        <div class="text-green-500 rounded-full bg-white mr-3">
            <!-- أيقونة نجاح -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-grow">
            <div class="font-bold text-lg text-green-800">تم بنجاح!</div>
            <div class="text-sm text-green-700">{{ session('success') }}</div>
        </div>
        <button type="button" class="text-green-700 hover:text-green-900 close-alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>
@endif

<!-- عنوان الصفحة -->
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">إضافة فئة جديدة</h1>
        <p class="text-gray-600 mt-1">قم بإدخال المعلومات المطلوبة لإضافة فئة جديدة</p>
    </div>
    <a href="{{ route('general_management.categories.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 rtl:mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        العودة للفئات
    </a>
</div>

<!-- بطاقة إضافة فئة -->
<div class="card bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100 py-4 px-6">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-900">إضافة فئة جديدة</h3>
        </div>
    </div>

    <form 
        action="{{ route('general_management.categories.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="category-form"
    >
        @csrf
        <!-- حقول النموذج -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- بيانات الفئة -->
                <div>
                    <div class="mb-6">
                        <label for="categoryName" class="block text-sm font-medium text-gray-700 mb-2">اسم الفئة <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="CategoryName" 
                                id="categoryName" 
                                class="block w-full pr-10 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('CategoryName') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror" 
                                placeholder="أدخل اسم الفئة"
                                value="{{ old('CategoryName') }}"
                                required
                            >
                        </div>
                        @error('CategoryName')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">يرجى إدخال اسم واضح ومختصر للفئة (مثلاً: خضروات، فواكه، منتجات الألبان)</p>
                    </div>

                    <div class="mb-6">
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">أيقونة الفئة <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex items-center">
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="icon" 
                                    id="icon" 
                                    class="absolute opacity-0 h-full w-full cursor-pointer"
                                    accept="image/*"
                                    onchange="previewImage(this)"
                                    required
                                >
                                <label for="icon" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none cursor-pointer flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>اختر صورة</span>
                                </label>
                                <span id="file-name" class="mr-2 text-sm text-gray-500">لم يتم اختيار ملف</span>
                            </div>
                        </div>
                        @error('icon')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">الصيغ المدعومة: JPG, PNG، WEBP. الحجم المثالي: 512×512 بكسل.</p>
                        @enderror
                    </div>
                </div>

                <!-- معاينة الصورة -->
                <div class="flex flex-col items-center justify-center bg-gray-50 rounded-lg border border-dashed border-gray-300 p-6">
                    <div id="image-preview-container" class="mb-4 w-40 h-40 flex items-center justify-center bg-white rounded-lg shadow">
                        <div id="no-preview" class="text-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm">معاينة الأيقونة</p>
                        </div>
                        <img id="image-preview" src="#" alt="معاينة" class="max-h-full max-w-full object-contain hidden">
                    </div>
                    <p class="text-sm text-gray-600">سيتم عرض الأيقونة بهذا الشكل في تطبيق العميل وصفحة الفئات</p>
                </div>
            </div>
        </div>

        <!-- زر الإرسال -->
        <div class="px-6 py-4 bg-gray-50 flex items-center justify-between">
            <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                إضافة فئة جديدة
            </button>
            <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">إعادة تعيين</button>
        </div>
    </form>
</div>

<!-- نصائح لتصنيف المنتجات -->
<div class="card mt-6 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        نصائح لإنشاء فئات فعّالة
    </h3>
    <ul class="text-gray-600 space-y-2 mr-5 list-disc">
        <li>استخدم أسماء واضحة ومفهومة للفئات تساعد العملاء على العثور على المنتجات بسهولة.</li>
        <li>اختر أيقونة معبرة لكل فئة تساعد على تمييزها بصرياً.</li>
        <li>حافظ على تناسق نظام التصنيف بحيث لا يكون هناك تداخل كبير بين الفئات.</li>
        <li>فكر في طريقة بحث المستخدمين عن المنتجات عند إنشاء فئات جديدة.</li>
    </ul>
</div>

<script>
    // معاينة الصورة
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const noPreview = document.getElementById('no-preview');
        const fileName = document.getElementById('file-name');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                noPreview.classList.add('hidden');
                fileName.textContent = input.files[0].name;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // إغلاق الإشعارات
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('.close-alert');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert-container').remove();
            });
        });
        
        // إغلاق تلقائي للإشعارات بعد 5 ثوان
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-container');
            alerts.forEach(alert => {
                alert.classList.add('animate__fadeOut');
                setTimeout(() => {
                    alert.remove();
                }, 500);
            });
        }, 5000);
        
        // التحقق من النموذج
        const form = document.querySelector('.category-form');
        form.addEventListener('submit', function(event) {
            const categoryName = document.getElementById('categoryName');
            const icon = document.getElementById('icon');
            
            let isValid = true;
            
            if (!categoryName.value.trim()) {
                event.preventDefault();
                categoryName.classList.add('border-red-500');
                isValid = false;
            } else {
                categoryName.classList.remove('border-red-500');
            }
            
            if (icon.files.length === 0) {
                event.preventDefault();
                icon.parentElement.classList.add('border-red-500');
                isValid = false;
            } else {
                icon.parentElement.classList.remove('border-red-500');
            }
            
            return isValid;
        });
    });
</script>

<style>
    .animate__animated { animation-duration: 0.5s; }
    .animate__fadeIn { animation-name: fadeIn; }
    .animate__fadeOut { animation-name: fadeOut; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeOut { from { opacity: 1; transform: translateY(0); } to { opacity: 0; transform: translateY(-20px); } }
</style>
@endsection
