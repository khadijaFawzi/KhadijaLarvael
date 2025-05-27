@extends('general-management.layout')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">المنتجات الأكثر مبيعاً</h1>
    <p class="text-gray-600">تحليل وعرض المنتجات الأعلى مبيعاً في جميع السوبرماركت</p>
</div>

<!-- إحصائيات سريعة -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card bg-gradient-to-br from-indigo-50 to-indigo-100 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-indigo-800 uppercase">إجمالي المبيعات</p>
                <h3 class="text-2xl font-bold text-indigo-900 mt-1">{{ array_sum(array_column($topProducts->toArray(), 'orders_count')) }}</h3>
                <p class="text-xs text-indigo-700 mt-1">
                    <i class="bi bi-graph-up-arrow"></i> للمنتجات الأكثر مبيعاً
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center">
                <i class="bi bi-box-seam text-indigo-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-rose-50 to-rose-100 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-rose-800 uppercase">المنتج الأكثر مبيعاً</p>
                <h3 class="text-2xl font-bold text-rose-900 mt-1 truncate max-w-[180px]">
                    {{ $topProducts->first()->ProductName ?? 'لا يوجد' }}
                </h3>
                <p class="text-xs text-rose-700 mt-1">
                    <i class="bi bi-trophy"></i> {{ $topProducts->first()->orders_count ?? 0 }} عملية شراء
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-rose-200 flex items-center justify-center">
                <i class="bi bi-star text-rose-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-amber-50 to-amber-100 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-amber-800 uppercase">متوسط المبيعات</p>
                <h3 class="text-2xl font-bold text-amber-900 mt-1">
                    {{ count($topProducts) > 0 ? round(array_sum(array_column($topProducts->toArray(), 'orders_count')) / count($topProducts)) : 0 }}
                </h3>
                <p class="text-xs text-amber-700 mt-1">
                    <i class="bi bi-calculator"></i> لكل منتج رائج
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-amber-200 flex items-center justify-center">
                <i class="bi bi-bar-chart text-amber-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-emerald-50 to-emerald-100 p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs font-medium text-emerald-800 uppercase">أفضل سوبرماركت</p>
                <h3 class="text-2xl font-bold text-emerald-900 mt-1 truncate max-w-[180px]">
                    
                </h3>
                <p class="text-xs text-emerald-700 mt-1">
                    <i class="bi bi-shop"></i> {{ $topSupermarket['count'] ?? 0 }} عملية بيع
                </p>
            </div>
            <div class="h-10 w-10 rounded-full bg-emerald-200 flex items-center justify-center">
                <i class="bi bi-building text-emerald-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- كارت المنتجات الأكثر مبيعاً كبطاقات -->
<div class="card mb-8">
    <div class="card-header flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">المنتجات الأكثر مبيعاً</h2>
        <div class="swiper-pagination"></div>
    </div>
    <div class="card-body pt-4">
        <div class="swiper-container">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach($topProducts->take(5) as $index => $product)
                    <div class="swiper-slide p-2">
                        <div class="bg-white rounded-lg shadow-md p-4 border border-gray-100 h-full flex flex-col">
                            <div class="flex justify-between mb-4">
                                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-800 font-bold text-lg">
                                    {{ $index + 1 }}
                                </span>
                                <div class="text-xl font-bold text-gray-900">
                                    {{ $product->orders_count }}
                                    <span class="text-sm text-gray-500">مبيعات</span>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $product->ProductName }}</h3>
                            <p class="text-sm text-gray-600 mb-3">{{ $product->supermarket->SupermarketName ?? 'سوبر ماركت غير معروف' }}</p>
                            <div class="mt-auto">
                                <div class="bg-gray-100 h-1.5 rounded-full w-full">
                                    @php
                                        $maxCount = $topProducts->max('orders_count');
                                        $percentage = $maxCount > 0 ? ($product->orders_count / $maxCount) * 100 : 0;
                                    @endphp
                                    <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-xs">
                                    <span class="text-gray-600">نسبة المبيعات</span>
                                    <span class="font-medium text-indigo-600">{{ round($percentage) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-4 space-x-2 space-x-reverse">
                <button class="swiper-button-prev bg-white border border-gray-300 rounded-full w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-gray-100">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <button class="swiper-button-next bg-white border border-gray-300 rounded-full w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-gray-100">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- الرسم البياني -->
<div class="card mb-8">
    <div class="card-header">
        <h2 class="text-lg font-semibold text-gray-900">توزيع المبيعات حسب المنتج</h2>
    </div>
    <div class="card-body pt-0">
        <div class="h-80">
            <canvas id="productsChart"></canvas>
        </div>
    </div>
</div>

<!-- جدول البيانات -->
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">قائمة المنتجات الأكثر مبيعاً</h2>
        <div class="flex gap-2">
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-medium hover:bg-gray-50">
                <i class="bi bi-file-excel mr-1"></i> تصدير
            </button>
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-medium hover:bg-gray-50">
                <i class="bi bi-printer mr-1"></i> طباعة
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-4">#</th>
                    <th scope="col" class="px-6 py-4">اسم المنتج</th>
                    <th scope="col" class="px-6 py-4">اسم السوبرماركت</th>
                    <th scope="col" class="px-6 py-4">عدد مرات البيع</th>
                    <th scope="col" class="px-6 py-4">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($topProducts as $index => $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                {{ $index + 1 }}
                            </div>
                            <div class="mr-3">
                                <p class="text-sm font-medium text-gray-900">{{ $product->ProductName }}</p>
                                <p class="text-xs text-gray-500">كود: #{{ $product->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm text-gray-900">{{ $product->supermarket->SupermarketName ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-semibold text-indigo-900">{{ $product->orders_count }}</span>
                            <span class="mr-2 text-xs text-white bg-indigo-600 px-2 py-0.5 rounded-full">
                                @php
                                    $maxCount = $topProducts->max('orders_count');
                                    $percentage = $maxCount > 0 ? ($product->orders_count / $maxCount) * 100 : 0;
                                @endphp
                                {{ round($percentage) }}%
                            </span>
                        </div>
                        <div class="w-36 mt-1 bg-gray-200 rounded-full h-1">
                            <div class="bg-indigo-600 h-1 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-left">
                        <button class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 rounded-lg px-3 py-1 text-sm transition-colors">
                            <i class="bi bi-eye ml-1"></i>تفاصيل
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // إعداد Swiper للمنتجات الأكثر مبيعًا
        const swiper = new Swiper('.swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
        });
//الاخطا  من css وليست في عمل الكود الكود شغال 
        // بيانات من الكونترولر
        const productNames = [@foreach($topProducts as $product) '{{ $product->ProductName }}', @endforeach];
        const orderCounts = [@foreach($topProducts as $product) {{ $product->orders_count }}, @endforeach];
        
        // إنشاء الألوان
        const generateColors = (count) => {
            const colors = [
                'rgba(79, 70, 229, 0.8)', 'rgba(99, 102, 241, 0.8)', 'rgba(129, 140, 248, 0.8)', 
                'rgba(165, 180, 252, 0.8)', 'rgba(199, 210, 254, 0.8)', 'rgba(224, 231, 255, 0.8)',
                'rgba(67, 56, 202, 0.8)', 'rgba(55, 48, 163, 0.8)', 'rgba(49, 46, 129, 0.8)', 'rgba(30, 27, 75, 0.8)'
            ];
            return Array(count).fill().map((_, i) => colors[i % colors.length]);
        };
        
        // إنشاء رسم بياني
        const ctx = document.getElementById('productsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'عدد مرات البيع',
                    data: orderCounts,
                    backgroundColor: generateColors(productNames.length),
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `عدد مرات البيع: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Cairo'
                            }
                        },
                        title: {
                            display: true,
                            text: 'عدد مرات البيع',
                            font: {
                                family: 'Cairo',
                                size: 14
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: 'Cairo'
                            },
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    });
</script>
@endsection