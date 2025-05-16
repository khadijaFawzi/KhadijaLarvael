@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('message'))
    <div class="alert alert-info mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
        {{ session('message') }}
    </div>
@endif

<div class="container mx-auto px-4 py-8">
    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex flex-wrap justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-tag ml-2"></i> قائمة العروض
                @if(isset($supermarket))
                    - {{ $supermarket->SupermarketName }}
                @endif
            </h2>
            
            <div class="flex space-x-2 space-x-reverse mt-2 md:mt-0">
                <a href="{{ route('view_offers', ['supermarket_id' => $supermarket->id]) }}" class="btn bg-custom hover:bg-custom_hover text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="bi bi-plus-lg ml-1"></i> إضافة عرض
                </a>
                <a href="{{ route('offers_process', ['supermarket_id' => $supermarket->id]) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    <i class="bi bi-image ml-1"></i> إضافة بالصورة
                </a>
            </div>
        </div>
        
        <!-- بحث -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <form action="#" method="GET" class="flex flex-wrap items-center">
                <div class="flex-grow ml-2 mb-2 md:mb-0">
                    <input type="text" name="search" placeholder="البحث عن عرض..." 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        value="{{ request('search') }}">
                </div>
                <div>
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-300">
                        <i class="bi bi-search ml-1"></i> بحث
                    </button>
                </div>
            </form>
        </div>
        
        <!-- تصفية حسب الفئة -->
        @if(isset($category) && $category->count() > 0)
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('Show_offersProces', ['supermarket_id' => $supermarket->id]) }}" 
               class="px-3 py-1 rounded-full {{ request('category_id') ? 'bg-gray-200 text-gray-800' : 'bg-custom text-white' }} text-sm font-medium">
                الكل
            </a>
            
            @foreach($category as $cat)
            <a href="{{ route('Show_offersProces', ['supermarket_id' => $supermarket->id, 'category_id' => $cat->id]) }}" 
               class="px-3 py-1 rounded-full {{ request('category_id') == $cat->id ? 'bg-custom text-white' : 'bg-gray-200 text-gray-800' }} text-sm font-medium">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
        @endif
        
        <!-- قائمة العروض -->
        @if(isset($offers) && $offers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 border-b text-right">صورة العرض</th>
                            <th class="py-3 px-4 border-b text-right">المنتج</th>
                            <th class="py-3 px-4 border-b text-right">نسبة الخصم</th>
                            <th class="py-3 px-4 border-b text-right">تاريخ البدء</th>
                            <th class="py-3 px-4 border-b text-right">تاريخ الانتهاء</th>
                            <th class="py-3 px-4 border-b text-right">الحالة</th>
                            <th class="py-3 px-4 border-b text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($offers as $offer)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    @if($offer->image)
                                        <img src="{{ asset('offers/' . $offer->image) }}" alt="صورة العرض" class="w-16 h-16 object-cover rounded-md">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                            <i class="bi bi-image text-2xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($offer->product)
                                        {{ $offer->product->product_name }}
                                    @else
                                        <span class="text-gray-400">غير محدد</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                        {{ $offer->discount_percentage }}%
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($offer->start_date)->format('Y/m/d') }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($offer->end_date)->format('Y/m/d') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $startDate = \Carbon\Carbon::parse($offer->start_date);
                                        $endDate = \Carbon\Carbon::parse($offer->end_date);
                                    @endphp
                                    
                                    @if($now->lt($startDate))
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">قادم</span>
                                    @elseif($now->gt($endDate))
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">منتهي</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">نشط</span>
                                    @endif
                                    
                                    @if(isset($offer->is_ai_processed) && $offer->is_ai_processed)
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded mr-1">تم التحليل بالذكاء الاصطناعي</span>
                                    @endif
                                    
                                    @if(isset($offer->is_verified) && $offer->is_verified)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded mr-1">تم التحقق</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        @if(isset($offer->is_ai_processed) && $offer->is_ai_processed && !$offer->is_verified)
                                            <a href="{{ route('edit_ai_offer', ['supermarket_id' => $supermarket->id, 'id' => $offer->id]) }}" 
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white p-1.5 rounded-md" title="تحقق من التحليل">
                                                <i class="bi bi-check-circle"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('update_offers', ['supermarket_id' => $supermarket->id, 'id' => $offer->id]) }}" 
                                               class="bg-blue-500 hover:bg-blue-600 text-white p-1.5 rounded-md" title="تعديل">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        
                                        
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-md" title="حذف">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <img src="{{ asset('img/empty.svg') }}" alt="لا توجد عروض" class="w-32 h-32 mx-auto mb-4 opacity-50">
                <h3 class="text-xl font-medium text-gray-500 mb-2">لا توجد عروض</h3>
                <p class="text-gray-400 mb-6">ابدأ بإضافة عروض جديدة لمنتجاتك</p>
                <div class="flex justify-center space-x-3 space-x-reverse">
                    <a href="{{ route('view_offers', ['supermarket_id' => $supermarket->id]) }}" class="btn bg-custom hover:bg-custom_hover text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        <i class="bi bi-plus-lg ml-1"></i> إضافة عرض
                    </a>
                    <a href="{{ route('offers_process', ['supermarket_id' => $supermarket->id]) }}" class="btn bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        <i class="bi bi-image ml-1"></i> إضافة بالصورة
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection