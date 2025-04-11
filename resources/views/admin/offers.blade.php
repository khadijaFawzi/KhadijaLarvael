@extends('admin.layout.master')

@section('content')
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة عرض جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
        }
        .form-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .form-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .custom-input {
            transition: border-color 0.3s ease;
        }
        .custom-input:focus {
            border-color: #ff9800;
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.25);
        }
        .btn-submit {
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(255, 152, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container mx-auto py-6 px-4">
        <!-- رسائل الخطأ -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- رسالة النجاح -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <!-- بطاقة النموذج -->
        <div class="bg-white rounded-lg overflow-hidden form-card mb-6">
            <div class="bg-orange-500 text-white py-4 px-6">
                <div class="flex items-center">
                    <i class="bi bi-tag-fill text-2xl ml-2"></i>
                    <h2 class="text-xl font-bold">إضافة عرض جديد</h2>
                </div>
            </div>
            
            <form action="{{ route('add_offers', ['supermarket_id' => $supermarket->id]) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- اختيار المنتج -->
                    <div>
                        <label for="product_id" class="block text-gray-700 font-medium mb-2">المنتج</label>
                        <div class="relative">
                            <select name="product_id" id="product_id" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none" required>
                                <option value="" selected disabled>اختر المنتج</option>
                                @foreach($product as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-700">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- نسبة التخفيض -->
                    <div>
                        <label for="discount_percentage" class="block text-gray-700 font-medium mb-2">نسبة التخفيض (%)</label>
                        <div class="relative">
                            <input type="number" name="discount_percentage" id="discount_percentage" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none" min="1" max="100" step="0.01" required>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-700">
                                <i class="bi bi-percent"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- تاريخ بدء العرض -->
                    <div>
                        <label for="start_date" class="block text-gray-700 font-medium mb-2">تاريخ بدء العرض</label>
                        <div class="relative">
                            <input type="date" name="start_date" id="start_date" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none" required>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-700">
                                <i class="bi bi-calendar-plus"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- تاريخ انتهاء العرض -->
                    <div>
                        <label for="end_date" class="block text-gray-700 font-medium mb-2">تاريخ انتهاء العرض</label>
                        <div class="relative">
                            <input type="date" name="end_date" id="end_date" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none" required>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-700">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- وصف العرض -->
                <div class="mb-6">
                    <label for="Description" class="block text-gray-700 font-medium mb-2">وصف العرض</label>
                    <div class="relative">
                        <textarea name="Description" id="Description" rows="4" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none resize-none" placeholder="اكتب وصفًا للعرض هنا..."></textarea>
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="flex items-center justify-end space-x-4 space-x-reverse">
                                <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    <i class="bi bi-arrow-repeat ml-1"></i>
                                    إعادة تعيين
                                </button>
                                <button type="submit" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                                    <i class="bi bi-plus-circle ml-1"></i>
                                    إضافة العرض
                                </button>
                            </div>
            </form>
        </div>
        
        <!-- قسم المعلومات الإضافية -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden form-card">
          
            <div class="p-6">
            <h3 class="text-gray-600 text-sm font-medium mb-4">
                    <i class="bi bi-info-circle-fill mr-1"></i>
                    معلومات إضافية
                </h3>
                
                <ul class="text-gray-700 space-y-2">
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>يمكنك تحديد نسبة خصم تتراوح بين 1% و 100%.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>تأكد من أن تاريخ انتهاء العرض يأتي بعد تاريخ بدء العرض.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="bi bi-check-circle-fill text-green-500 mt-1 ml-2"></i>
                        <span>يمكنك عرض جميع العروض النشطة والمنتهية من خلال صفحة "عرض العروض".</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    <script>
        // التحقق من صحة التواريخ
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            // تعيين تاريخ اليوم كأقل تاريخ ممكن للبدء
            const today = new Date().toISOString().split('T')[0];
            startDateInput.min = today;
            
            // التأكد من أن تاريخ الانتهاء بعد تاريخ البدء
            startDateInput.addEventListener('change', function() {
                endDateInput.min = startDateInput.value;
                if (endDateInput.value && endDateInput.value < startDateInput.value) {
                    endDateInput.value = startDateInput.value;
                }
            });
        });
    </script>
</body>
</html>
@endsection