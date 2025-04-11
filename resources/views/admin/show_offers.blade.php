@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


    <!-- بطاقة إدارة المنتجات -->
    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-box-seam ml-2"></i> إدارة العروض
            </h2>
            <a href="{{ route('view_offers', ['supermarket_id' => $supermarket->id]) }}" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                <i class="bi bi-plus-circle ml-1"></i> إضافة عرض جديد
            </a>
        </div>
        
        <!-- قسم البحث -->
        <div class="mb-6">
            <form action="{{ url('/products') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <input type="text" name="search" class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
                    <span class="absolute right-3 top-3 text-gray-500">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
                <div>
                    <select name="category" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                        <option value="">جميع الفئات</option>
                        <option value="" selected="">اختر فئة</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->CategoryName }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-custom hover:bg-indigo-700 text-black py-2 px-6 rounded-lg transition duration-300">
                    بحث
                </button>
            </form>
        </div>
        
        <!-- رسالة نجاح -->
        
        <!-- جدول المنتجات -->
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border">الرقم</th>
                                    <th class="border">رقم المنتج</th>
                                    <th class="border">اسم المنتج</th>
                                    <th class="border">تاريخ بدء العرض</th>
                                    <th class="border">تاريخ انتهاء العرض</th>
                                    <th class="border">نسبة التخفيض</th>
                                    <th class="border">السعر الأصلي</th>
                                    <th class="border">السعر بعد التخفيض</th>
                                    <th class="border">وصف</th>
                                    <th class="border">صورة المنتج</th>
                                    <th class="border">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($offers as $offer)
                                    <tr>
                                        <td>{{ $offer->id }}</td>
                                        <td>{{ $offer->Product_id }}</td>
                                        <td>{{ optional($offer->product)->product_name ?? 'غير متوفر' }}</td>
                                        <td>{{ $offer->start_date }}</td>
                                        <td>{{ $offer->end_date }}</td>
                                        <td>{{ $offer->discount_percentage }}</td>
                                        <td>{{ optional($offer->product)->Price ?? 'غير متوفر' }}</td>
                                        <td>
                                            @php
                                                $original_price = optional($offer->product)->Price ?? 0;
                                                $discount_percentage = $offer->discount_percentage;
                                                $discounted_price = $original_price - ($original_price * ($discount_percentage / 100));
                                            @endphp
                                            {{ number_format($discounted_price, 2) }}
                                        </td>
                                        <td>{{ $offer->Description }}</td>
                                        <td>
                                            @if(optional($offer->product)->Image)
                                                <img src="{{ asset('products/' . $offer->product->Image) }}" alt="{{ $offer->product->product_name }}" style="width: 100px; height: auto;">
                                            @else
                                                <span>لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" onclick="return confirm('Are you sure to Delete this')" href="{{ url('delete_offers', $offer->id) }}">Delete</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('update_offers', ['supermarket_id' => $offer->supermarket_id, 'id' => $offer->id]) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    عرض <span class="font-medium">1</span> إلى <span class="font-medium">3</span> من أصل <span class="font-medium">10</span> عروض
                                </p>
                            </div>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <a href="#" class="btn bg-white text-gray-700 border border-gray-300">السابق</a>
                                <a href="#" class="btn bg-blue-500 text-white border border-blue-500">1</a>
                                <a href="#" class="btn bg-white text-gray-700 border border-gray-300">2</a>
                                <a href="#" class="btn bg-white text-gray-700 border border-gray-300">3</a>
                                <a href="#" class="btn bg-white text-gray-700 border border-gray-300">التالي</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            </div> 
        </form>
    </main>

    <!-- سكريبت تأكيد الحذف -->
    <script>
        function confirmDelete(productId) {
            if (confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج؟')) {
                window.location.href = "{{ url('delete_product') }}/" + productId;
            }
        }
    </script>
@endsection
