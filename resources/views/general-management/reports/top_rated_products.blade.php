@extends('general-management.layout')

@section('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">المنتجات الأعلى تقييماً</h1>
    <p class="text-gray-600">تحليل وعرض المنتجات ذات أعلى متوسط تقييم في جميع السوبرماركت</p>
</div>

@php
    // الإحصاءات السريعة
    $totalReviews     = $topRated->sum('reviews_count');
    $bestProduct      = $topRated->first();
    $avgRatingOverall = $topRated->count() ? round($topRated->avg('avg_rating'), 2) : 0;
    $topSupermarket   = $topRated
        ->groupBy('supermarket.SupermarketName')
        ->map(fn($g) => [
            'name'  => $g->first()->supermarket->SupermarketName ?? 'غير معروف',
            'count' => $g->sum('reviews_count'),
            'avg'   => round($g->avg('avg_rating'), 2),
        ])
        ->sortByDesc('avg')
        ->first();
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
  <!-- إجمالي المراجعات -->
  <div class="stat-card card flex flex-col items-center justify-center p-4">
    <div class="stat-icon bg-indigo-100 text-indigo-600 mb-2"><i class="bi bi-chat-text"></i></div>
    <div class="text-lg font-bold">{{ $totalReviews }}</div>
    <div class="text-gray-500">عدد المراجعات</div>
  </div>

  <!-- المنتج الأعلى تقييماً -->
  <div class="stat-card card flex flex-col items-center justify-center p-4">
    <div class="stat-icon bg-rose-100 text-rose-600 mb-2"><i class="bi bi-star-fill"></i></div>
    <div class="text-lg font-bold">{{ $bestProduct?->ProductName ?? 'لا يوجد' }}</div>
    <div class="text-gray-500">أعلى متوسط تقييم</div>
    <div class="text-xs text-gray-400 mt-1">
      {{ $bestProduct?->avg_rating ?? '' }} ★ ({{ $bestProduct?->reviews_count }} مراجعة)
    </div>
  </div>

  <!-- متوسط التقييم العام -->
  <div class="stat-card card flex flex-col items-center justify-center p-4">
    <div class="stat-icon bg-amber-100 text-amber-600 mb-2"><i class="bi bi-calculator"></i></div>
    <div class="text-lg font-bold">{{ $avgRatingOverall }}</div>
    <div class="text-gray-500">متوسط التقييم العام</div>
    <div class="text-xs text-gray-400 mt-1">لكل منتج</div>
  </div>

  <!-- أفضل سوبرماركت بالتقييم -->
  <div class="stat-card card flex flex-col items-center justify-center p-4">
    <div class="stat-icon bg-emerald-100 text-emerald-600 mb-2"><i class="bi bi-building"></i></div>
    <div class="text-lg font-bold">{{ $topSupermarket['name'] ?? 'لا يوجد' }}</div>
    <div class="text-gray-500">أفضل سوبرماركت</div>
    <div class="text-xs text-gray-400 mt-1">
      {{ $topSupermarket['avg'] ?? 0 }} ★ ({{ $topSupermarket['count'] ?? 0 }} مراجعة)
    </div>
  </div>
</div>
<!-- سلايدر أعلى التقييم -->
<div class="card mb-8">
  <div class="card-header flex items-center justify-between">
    <h2 class="text-lg font-semibold text-gray-900">أعلى 5 منتجات تقييماً</h2>
  </div>
  <div class="card-body pt-4">
    {{-- هنا نُسمي الحاوية الرئيسية mySwiper --}}
    <div class="swiper mySwiper">
      {{-- شريط الشرائح --}}
      <div class="swiper-wrapper">
        @foreach($topRated->take(5) as $i => $p)
          @php $pct = $p->avg_rating / 5 * 100; @endphp
          <div class="swiper-slide p-2">
            <div class="bg-white rounded-lg shadow-md p-4 h-full flex flex-col">
              <!-- محتوى الشريحة كما في السابق -->
              <div class="flex justify-between mb-4">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 text-indigo-800 font-bold">
                  {{ $i+1 }}
                </span>
                <div class="text-xl font-bold text-gray-900">{{ $p->avg_rating }} ★</div>
              </div>
              <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $p->product_name }}</h3>
              <p class="text-sm text-gray-600 mb-3">{{ $p->supermarket->SupermarketName ?? 'غير معروف' }}</p>
              <div class="mt-auto">
                <div class="bg-gray-100 h-1.5 rounded-full">
                  <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                </div>
                <div class="flex justify-between mt-2 text-xs">
                  <span class="text-gray-600">النسبة من ★5</span>
                  <span class="font-medium text-indigo-600">{{ round($pct) }}%</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- نقاط الترقيم -->
      <div class="swiper-pagination"></div>
      <!-- أزرار التنقل -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.mySwiper', {
      slidesPerView: 1,
      spaceBetween: 20,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        640: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        1024: { slidesPerView: 4 },
      },
    });
  });
</script>


<!-- رسم بياني متوسط التقييم -->
<div class="card mb-8">
  <div class="card-header"><h2 class="text-lg font-semibold text-gray-900">متوسط التقييم لكل منتج</h2></div>
  <div class="card-body pt-0"><div class="h-80"><canvas id="ratingChart"></canvas></div></div>
</div>

<!-- جدول البيانات -->
<div class="card">
  <div class="card-header flex items-center justify-between">
    <h2 class="text-lg font-semibold text-gray-900">قائمة المنتجات الأعلى تقييماً</h2>
    <div class="flex gap-2">
      <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm hover:bg-gray-50">
        <i class="bi bi-printer mr-1"></i> طباعة
      </button>
    </div>
  </div>
 <div class="overflow-x-auto">
  <div class="overflow-x-auto">
  <table class=>
    <!-- تحديد عرض الأعمدة -->
    <colgroup>
      <col class="w-1/12">
      <col class="w-3/12">
      <col class="w-3/12">
      <col class="w-2/12">
      <col class="w-3/12">
    </colgroup>

    <thead class="bg-gray-50">
      <tr>
        <th class="px-6 py-4">#</th>
        <th class="px-6 py-4">اسم المنتج</th>
        <th class="px-6 py-4">اسم السوبرماركت</th>
        <th class="px-6 py-4">متوسط التقييم</th>
        <th class="px-6 py-4">عدد المراجعات</th>
      </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-100">
      @foreach($topRated as $p)
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4">{{ $p->id }}</td>
          <td class="px-6 py-4">{{ $p->product_name }}</td>
          <td class="px-6 py-4">{{ $p->supermarket->SupermarketName ?? '-' }}</td>
          <td class="px-6 py-4 font-semibold">{{ $p->avg_rating }} ★</td>
          <td class="px-6 py-4">{{ $p->reviews_count }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>


</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const topRated   = @json($topRated);
    const names      = topRated.map(p => p.product_name);
    const ratings    = topRated.map(p => p.avg_rating);

    // تهيئة Swiper كما سبق…

    // إعداد المخطط مع عرض كل التسميات تحت كل عمود
    new Chart(document.getElementById('ratingChart'), {
        type: 'bar',
        data: {
            labels: names,
            datasets: [{
                label: 'متوسط التقييم',
                data: ratings,
                backgroundColor: names.map((_,i)=>`rgba(79,70,229,${0.6 + i*0.04})`),
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: {
                        display: true,
                        text: 'التقييم من 5'
                    }
                },
                x: {
                    // اجعل التسمية تظهر دائماً وتجنب auto-skip
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 45,
                        font: { family: 'Cairo' }
                    },
                    title: {
                        display: true,
                        text: 'اسم المنتج',
                        font: { family: 'Cairo', size: 14 }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => `متوسط التقييم: ${ctx.raw} ★`
                    }
                }
            }
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
  new Swiper('.swiper', {
    // نحدد pagination و navigation
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    slidesPerView: 1,
    spaceBetween: 20,
    breakpoints: {
      640: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 4 },
    }
  });
});
</script>

@endsection
