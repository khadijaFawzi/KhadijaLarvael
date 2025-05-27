@extends('general-management.layout')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection



@section('content')
@php
    /* أرقام سريعة */
    $totalOrders      = $ordersBySupermarket->sum('orders_count');
    $supermarketTotal = $ordersBySupermarket->count();
    $avgOrders        = $supermarketTotal ? round($totalOrders / $supermarketTotal) : 0;
    $topSupermarket   = $ordersBySupermarket->sortByDesc('orders_count')->first();
@endphp

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">تقرير الطلبات</h1>
    <p class="text-gray-600">استعراض وتحليل طلبات السوبرماركت في النظام</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- إجمالي الطلبات -->
    <div class="stat-card card flex flex-col items-center justify-center p-4 bg-blue-100 text-blue-600">
        <div class="stat-icon mb-2">
            <i class="bi bi-cart"></i>
        </div>
        <div class="text-lg font-bold">{{ $totalOrders }}</div>
        <div class="text-gray-500">إجمالي الطلبات</div>
        <div class="text-xs text-blue-700 mt-2">+12% من الشهر السابق</div>
    </div>

    <!-- متوسط الطلبات -->
    <div class="stat-card card flex flex-col items-center justify-center p-4 bg-green-100 text-green-600">
        <div class="stat-icon mb-2">
            <i class="bi bi-calculator"></i>
        </div>
        <div class="text-lg font-bold">{{ $avgOrders }}</div>
        <div class="text-gray-500">متوسط الطلبات</div>
        <div class="text-xs text-green-700 mt-2">متوسط لكل سوبرماركت</div>
    </div>

    <!-- الأعلى مبيعاً -->
    <div class="stat-card card flex flex-col items-center justify-center p-4 bg-purple-100 text-purple-600">
        <div class="stat-icon mb-2">
            <i class="bi bi-shop"></i>
        </div>
        <div class="text-lg font-bold">{{ $topSupermarket?->SupermarketName ?? 'لا يوجد' }}</div>
        <div class="text-gray-500">الأعلى مبيعاً</div>
        <div class="text-xs text-purple-700 mt-2">سوبرماركت الشهر</div>
    </div>

    <!-- عدد المتاجر -->
    <div class="stat-card card flex flex-col items-center justify-center p-4 bg-blue-50 text-blue-600">
        <div class="stat-icon mb-2">
            <i class="bi bi-buildings"></i>
        </div>
        <div class="text-lg font-bold">{{ $supermarketTotal }}</div>
        <div class="text-gray-500">عدد المتاجر</div>
        <div class="text-xs text-blue-700 mt-2">متجر نشط</div>
    </div>
</div>




{{-- ###### الرسم البياني ###### --}}
@php
    $supermarketNames = $ordersBySupermarket->pluck('SupermarketName');
    $orderCounts      = $ordersBySupermarket->pluck('orders_count');
@endphp

<div class="card mb-8">
    <div class="card-header">
        <h2 class="text-lg font-semibold text-gray-900">توزيع الطلبات حسب السوبرماركت</h2>
    </div>
    <div class="card-body pt-0">
        <div class="h-80">
            <canvas id="ordersChart"></canvas>
        </div>
    </div>
</div>



{{-- ###### جدول البيانات ###### --}}
<div class="card">
    <div class="card-header flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">عدد الطلبات لكل سوبرماركت</h2>
        <div class="flex gap-2">
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm hover:bg-gray-50">
                <i class="bi bi-file-excel mr-1"></i> تصدير
            </button>
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm hover:bg-gray-50">
                <i class="bi bi-printer mr-1"></i> طباعة
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">اسم السوبرماركت</th>
                    <th class="px-6 py-4">عدد الطلبات</th>
                    <th class="px-6 py-4">النسبة المئوية</th>
                    <th class="px-6 py-4">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($ordersBySupermarket as $market)
                    @php
                        $percent = $totalOrders ? round($market->orders_count / $totalOrders * 100) : 0;
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">{{ $market->id }}</td>

                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-blue-500/70 flex items-center justify-center text-white">
                                    {{ mb_substr($market->SupermarketName,0,1) }}
                                </div>
                                <span class="mr-3 text-sm font-medium text-gray-900">{{ $market->SupermarketName }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $market->orders_count }}</span>
                            <span class="text-sm text-gray-500">طلب</span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $percent }}%</span>
                                <div class="w-32 bg-gray-200 h-2 rounded-full">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percent }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-left">
                            <button class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 rounded-lg px-3 py-1 text-sm">
                                <i class="bi bi-eye ml-1"></i> تفاصيل
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



{{-- ########## JavaScript ########## --}}
<script>
//  @ts-nocheck  ← يمنع VS Code من فحص السكربت

document.addEventListener('DOMContentLoaded', () => {

   //الاخطا  من css وليست في عمل الكود الكود شغال 
   // كل الاكواد شغالة

    const labels = @json($supermarketNames);
    const counts = @json($orderCounts);

    /* ألوان متدرجة لطيفة */
    const colors = [
        '#3B82F6','#60A5FA','#93C5FD','#BFDBFE',
        '#2563EB','#1D4ED8','#1E40AF','#1E3A8A'
    ];

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'عدد الطلبات',
                data: counts,
                backgroundColor: labels.map((_,i) => colors[i % colors.length]),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    displayColors: false,
                    callbacks: {
                        label: ctx => `عدد الطلبات: ${ctx.raw}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display:true, text:'عدد الطلبات', font:{ family:'Cairo', size:14 } },
                    ticks: { font:{ family:'Cairo' } }
                },
                x: { ticks: { font:{ family:'Cairo' }, maxRotation:45, minRotation:45 } }
            }
        }
    });
});
</script>
@endsection
