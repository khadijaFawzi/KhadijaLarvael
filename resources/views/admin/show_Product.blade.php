@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container mx-auto px-4 py-8 max-h-screen overflow-y-auto">
    <!-- بطاقة إدارة المنتجات -->
    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-box-seam ml-2"></i> إدارة المنتجات
            </h2>
            <a href="{{ route('view_product', ['supermarket_id' => $supermarket->id]) }}" 
               class="bg-[#5c8076] hover:bg-[#4b6e65] text-white py-2 px-6 rounded-lg transition duration-300">
                <i class="bi bi-plus-circle ml-1"></i> إضافة منتج
            </a>
        </div>
        
        <!-- قسم البحث -->
        <div class="mb-6">
            <form action="{{ url('/products') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <input type="text" name="search" class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-10 focus:outline-none focus:ring-2 focus:ring-[#5c8076] focus:border-[#5c8076]" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
                    <span class="absolute right-3 top-3 text-gray-500">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
                <div>
                    <select name="category" class="bg-[#e8f0ee] text-gray-700 py-2 px-6 rounded-lg border border-gray-300 transition duration-300">
                        <option value="">جميع الفئات</option>
                        <option value="" selected="">اختر فئة</option>
                        @foreach($category as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->CategoryName }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-[#5c8076] hover:bg-[#4b6e65] font-bold text-white py-2 px-6 rounded-lg transition duration-300">
                    بحث
                </button>
            </form>
        </div>
        
        <!-- جدول المنتجات -->
        <div class="overflow-x-auto">
            <table class="min-w-full rounded-lg overflow-hidden shadow bg-[#e8f0ee]">
                <thead style="background-color: #5c8076;">
                    <tr>
                        <th class="py-3 px-4 text-right text-white">#</th>
                        <th class="py-3 px-4 text-right text-white">اسم المنتج</th>
                        <th class="py-3 px-4 text-right text-white">السعر</th>
                        <th class="py-3 px-4 text-right text-white">الفئة</th>
                        <th class="py-3 px-4 text-right text-white">الوصف</th>
                        <th class="py-3 px-4 text-right text-white">الباركود</th>
                        <th class="py-3 px-4 text-right text-white">صورة المنتج</th>
                        <th class="py-3 px-4 text-center text-white">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="hover:bg-[#d1e3de] transition-colors">
                        <td class="py-3 px-4 text-gray-800 font-bold">{{$product->id}}</td>
                        <td class="py-3 px-4 text-gray-800">{{$product->product_name}}</td>
                        <td class="py-3 px-4 text-gray-800">{{$product->Price}}</td>
                        <td class="py-3 px-4 text-gray-800">{{$product->Category_id}}</td>
                        <td class="py-3 px-4 text-gray-800">{{$product->Description}}</td>
                        <td class="py-3 px-4 text-gray-800">{{$product->barcode}}</td>
                        <td class="py-3 px-4">
                            <img src="{{ asset('products/'.$product->Image) }}" style="width: 100px; height: 70px; max-width: 100%; border-radius: 5px;" alt="{{ $product->product_name }}">
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('update_product', ['supermarket_id' => $supermarket->id, 'product_id' => $product->id]) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg flex items-center">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="mr-1">تعديل</span>
                                </a>
                                <!-- <a onclick="confirmDelete({{ $product->id }})" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg flex items-center cursor-pointer"> -->
                                    <i class="bi bi-trash"></i>
                                    <span class="mr-1">حذف</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- الترقيم -->
        @if($products->hasPages())
        <div class="mt-6 flex justify-center">
            <div class="flex flex-wrap">
                @if($products->onFirstPage())
                    <span class="mx-1 px-3 py-2 bg-gray-200 text-gray-600 rounded">السابق</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="mx-1 px-3 py-2 bg-white hover:bg-gray-100 text-[#5c8076] border border-gray-300 rounded">السابق</a>
                @endif
                
                @foreach(range(1, $products->lastPage()) as $page)
                    @if($page == $products->currentPage())
                        <span class="mx-1 px-3 py-2 bg-[#5c8076] text-white rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $products->url($page) }}" class="mx-1 px-3 py-2 bg-white hover:bg-gray-100 text-[#5c8076] border border-gray-300 rounded">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="mx-1 px-3 py-2 bg-white hover:bg-gray-100 text-[#5c8076] border border-gray-300 rounded">التالي</a>
                @else
                    <span class="mx-1 px-3 py-2 bg-gray-200 text-gray-600 rounded">التالي</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- سكريبت تأكيد الحذف -->
<script>
    function confirmDelete(productId) {
        if (confirm('هل أنت متأكد من رغبتك في حذف هذا المنتج؟')) {
            window.location.href = "{{ url('delete_product') }}/" + productId;
        }
    }
</script>
@endsection
