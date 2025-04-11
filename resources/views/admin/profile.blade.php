@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

   
        <!-- بطاقة الملف الشخصي -->
        <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="bi bi-box-seam ml-2"></i> الملف الشخصي
                </h2>
            </div>

            <!-- نموذج التعديل داخل منطقة قابلة للتمرير أفقي (إن لزم الأمر) -->
            <div class="overflow-x-auto">
                <form action="{{ route('profile.update', $superMarket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- قسم المعلومات الأساسية -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">المعلومات الأساسية</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- اسم السوبر ماركت -->
                            <div>
                                <label for="SupermarketName" class="block text-gray-700 font-medium mb-2">
                                    اسم السوبر ماركت <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="SupermarketName" id="SupermarketName" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field"
                                    value="{{ $superMarket->SupermarketName }}">
                                @error('SupermarketName')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <!-- الموقع -->
                            <div>
                                <label for="Location" class="block text-gray-700 font-medium mb-2">
                                    الموقع <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="Location" id="Location" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field"
                                    value="{{ $superMarket->Location }}">
                                @error('Location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <!-- البريد الإلكتروني -->
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">
                                    البريد الإلكتروني <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="email" id="email" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field"
                                    value="{{ $user->email }}">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <!-- كلمة السر
                            <div>
                                <label for="password" class="block text-gray-700 font-medium mb-2">
                                    كلمة السر <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="password" id="password" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field"
                                    value="{{ $user->password }}">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> -->
                    </div>
                    
                    <!-- قسم معلومات الاتصال -->
                     <br>
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">معلومات الاتصال</h2>
                        <div>
                            <label for="ContactNumber" class="block text-gray-700 font-medium mb-2">
                                رقم التواصل <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-gray-500 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>
                                <input type="text" name="ContactNumber" id="ContactNumber" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field"
                                    value="{{ $superMarket->ContactNumber }}"
                                    placeholder="05xxxxxxxx" dir="ltr">
                            </div>
                            @error('ContactNumber')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- قسم صورة البروفايل -->
                    <br>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">صورة البروفايل</h2>
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <!-- عرض الصورة الحالية -->
                            <div class="flex-shrink-0">
                                <div class="w-40 h-40 bg-gray-100 rounded-lg overflow-hidden shadow-sm border border-gray-200">
                                    @if(isset($supermarket->profile_image) && $supermarket->profile_image)
                                        <img src="{{ asset('uploads/'.$superMarket->profile_image) }}"
                                             alt="صورة السوبرماركت" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <i class="bi bi-shop text-gray-400 text-5xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- تحميل صورة جديدة -->
                            <div class="flex-grow space-y-4">
                                <label for="profile_image" class="block text-gray-700 font-medium">
                                    تحديث الصورة الشخصية
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg px-6 py-8 text-center hover:bg-gray-50 transition-colors">
                                    <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*">
                                    <label for="profile_image" class="cursor-pointer">
                                        <div class="text-center">
                                            <i class="bi bi-cloud-arrow-up text-4xl text-gray-400"></i>
                                            <p class="mt-2 text-sm text-gray-600">اضغط هنا لتحميل صورة جديدة</p>
                                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF حتى 5MB</p>
                                        </div>
                                    </label>
                                </div>
                                @error('profile_image')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- زر حفظ التغييرات -->
                    <div class="pt-4 flex justify-center md:justify-end">
                        <button type="submit" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                            <i class="bi bi-save mr-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    
       
        <div class="bg-white rounded-lg shadow-sm overflow-hidden form-card">
            <div class="p-6">
                <h3 class="text-gray-600 text-sm font-medium mb-4">
                    <i class="bi bi-info-circle-fill mr-1"></i>
                    معلومات إضافية
                </h3>
                <ul class="text-gray-700 text-sm space-y-2">
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>قم بتحديث بيانات السوبرماركت بانتظام للحفاظ على معلومات دقيقة.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>استخدم صورة واضحة وبجودة عالية لشعار السوبرماركت.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>تأكد من صحة رقم الاتصال لسهولة التواصل مع العملاء.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
