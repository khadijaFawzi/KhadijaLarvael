@extends('general-management.layout')

@section('styles')
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection



@section('content')
@php
    /* تأكّد من تمرير هذه المتغيّرات من الكنترولر */
    $usersCount        = $usersCount        ?? 0;
    $ordersCount       = $ordersCount       ?? 0;
    $productsCount     = $productsCount     ?? 0;
    $categoriesCount   = $categoriesCount   ?? 0;

    // بيانات الرسم البياني (مثال – بدِّلها بما تريد)
    $ordersDates  = ['الأحد','الإثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت'];
    $ordersSeries = [15, 25, 18, 35, 30, 38, 28];

    // نسب توزيع المستخدمين (0-1)
    $customerPercentage    = $customerPercentage    ?? 0.55;
    $supermarketPercentage = $supermarketPercentage ?? 0.32;
    $adminPercentage       = $adminPercentage       ?? 0.13;
@endphp


<!-- عنوان -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">لوحة القيادة</h1>
    <p class="text-gray-600">مرحبًا بك في لوحة تحكم الإدارة العامة</p>
</div>


<!-- بطاقات الإحصاءات -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- بطاقة --}}
    <div class="card p-6 bg-white shadow animate-fade-in">
        <div class="flex items-start">
            <div class="stat-icon bg-blue-100 text-blue-600 mr-5">
                <i class="bi bi-people text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">إجمالي المستخدمين</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $usersCount }}</h3>
                <p class="text-xs text-green-600 mt-1 flex items-center"><i class="bi bi-graph-up-arrow ml-1"></i> +12%</p>
            </div>
        </div>
    </div>

    <div class="card p-6 bg-white shadow animate-fade-in">
        <div class="flex items-start">
            <div class="stat-icon bg-green-100 text-green-600 mr-5">
                <i class="bi bi-cart3 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">إجمالي الطلبات</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $ordersCount }}</h3>
                <p class="text-xs text-green-600 mt-1 flex items-center"><i class="bi bi-graph-up-arrow ml-1"></i> +8%</p>
            </div>
        </div>
    </div>

    <div class="card p-6 bg-white shadow animate-fade-in">
        <div class="flex items-start">
            <div class="stat-icon bg-purple-100 text-purple-600 mr-5">
                <i class="bi bi-box-seam text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">إجمالي المنتجات</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $productsCount }}</h3>
                <p class="text-xs text-green-600 mt-1 flex items-center"><i class="bi bi-graph-up-arrow ml-1"></i> +5%</p>
            </div>
        </div>
    </div>

    <div class="card p-6 bg-white shadow animate-fade-in">
        <div class="flex items-start">
            <div class="stat-icon bg-amber-100 text-amber-600 mr-5">
                <i class="bi bi-tags text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">إجمالي الفئات</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ $categoriesCount }}</h3>
                <p class="text-xs text-amber-600 mt-1 flex items-center"><i class="bi bi-plus-circle ml-1"></i> +2</p>
            </div>
        </div>
    </div>
</div>


<!-- الرسوم البيانية -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- مخطط منطقة الطلبات --}}
    <div class="card lg:col-span-2">
        <div class="card-header p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">إحصائيات الطلبات</h2>
        </div>
        <div class="p-4 pt-0">
            <div id="ordersChart" class="h-80"></div>
        </div>
    </div>

    {{-- مخطط دائري للمستخدمين --}}
    <div class="card">
        <div class="card-header p-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">توزيع المستخدمين</h2>
        </div>
        <div class="p-4 pt-0 flex flex-col items-center">
            <div id="usersPieChart" class="h-60 w-full"></div>
        </div>
    </div>
</div>



{{-- مثال صف واحد من الجداول (أضف الجدولين كما تحتاج) --}}
<div class="card">
    <div class="card-header p-4 border-b">
        <h2 class="text-lg font-semibold text-gray-900">آخر المستخدمين المسجلين</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-5 py-3">المستخدم</th>
                    <th class="px-5 py-3">البريد الإلكتروني</th>
                    <th class="px-5 py-3">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lastUsers ?? [] as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-4">{{ $user->username }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



{{-- ########## JavaScript ########## --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
//الاخطا  من  وليست في عمل الكود الكود شغال 
// كل الاكواد شغالة الخلل من جافاسكريبت 
// كل الاكواد شغالة
    /* ========== تمرير بيانات من PHP إلى جافاسكريبت ========== */
    const ordersDates  = @json($ordersDates);
    const ordersSeries = @json($ordersSeries);

    /* ----- مخطط منطقة الطلبات (ApexCharts) ----- */
    new ApexCharts(document.querySelector('#ordersChart'), {
        series: [{ name: 'الطلبات', data: ordersSeries }],
        chart:  { type:'area', height:320, fontFamily:'Cairo, sans-serif', toolbar:{show:false}, zoom:{enabled:false} },
        colors: ['#3B82F6'],
        stroke: { curve:'smooth', width:3 },
        fill:   { type:'gradient', gradient:{ shadeIntensity:1, opacityFrom:0.7, opacityTo:0.3, stops:[0,90,100] } },
        dataLabels:{ enabled:false },
        xaxis:{ categories:ordersDates, labels:{ style:{ fontFamily:'Cairo, sans-serif' } } },
        yaxis:{ labels:{ style:{ fontFamily:'Cairo, sans-serif' } } },
        tooltip:{ y:{ formatter:v => v + ' طلب' } },
        grid:{ borderColor:'#f1f1f1', strokeDashArray:4 },
        markers:{ size:5, colors:['#3B82F6'], strokeColors:'#fff', strokeWidth:2 }
    }).render();


    /* ----- مخطط دائري للمستخدمين ----- */
    new ApexCharts(document.querySelector('#usersPieChart'), {
        series: [
            {{ $customerPercentage    * 100 }},
            {{ $supermarketPercentage * 100 }},
            {{ $adminPercentage       * 100 }}
        ],
        chart:{ type:'donut', height:240, fontFamily:'Cairo, sans-serif' },
        labels:['عملاء','سوبرماركت','إداريون'],
        colors:['#3B82F6','#10B981','#8B5CF6'],
        legend:{ show:false },
        dataLabels:{ enabled:false },
        plotOptions:{ pie:{ donut:{ size:'70%', labels:{ show:true,
            name:{ show:true, fontFamily:'Cairo, sans-serif' },
            value:{ show:true, fontFamily:'Cairo, sans-serif', formatter:v=>Math.round(v)+'%' },
            total:{ show:true, label:'الإجمالي', fontFamily:'Cairo, sans-serif', formatter:()=> '{{ $usersCount }}' }
        }}}}
    }).render();
});
</script>
@endsection
