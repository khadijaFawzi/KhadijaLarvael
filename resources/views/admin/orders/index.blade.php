@extends('admin.layout.master')

@section('title', 'طلبات السوبرماركت')

@section('content')
@php
    // جلب معرف السوبرماركت من المسار
    $supermarketId = request()->route('supermarket_id');
@endphp

<div class="container py-4">


<div class="flex flex-col md:flex-row gap-4 mb-6">
  {{-- طلبات جديدة --}}
  <div class="w-full md:w-1/3">
    <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-2xl shadow-lg flex flex-col items-center">
      <i class="bi bi-bag-plus-fill text-4xl mb-3"></i>
      <h5 class=" mb-1 text-white">طلبات جديدة</h5>
      <p class="text-3xl font-extrabold">{{ $newOrdersCount }}</p>
    </div>
  </div>

  {{-- قيد المعالجة --}}
  <div class="w-full md:w-1/3">
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-6 rounded-2xl shadow-lg flex flex-col items-center">
      <i class="bi bi-hourglass-split text-4xl mb-3"></i>
      <h5 class=" mb-1 text-white">قيد المعالجة</h5>
      <p class="text-3xl font-extrabold">{{ $processingOrdersCount }}</p>
    </div>
  </div>

  {{-- الإجمالي --}}
  <div class="w-full md:w-1/3">
    <div class="bg-blue-600 text-white p-6 rounded-2xl shadow-lg flex flex-col items-center">
      <i class="bi bi-list-check text-4xl mb-3"></i>
      <h5 class=" mb-1 text-white">الإجمالي</h5>
      <p class="text-3xl font-extrabold">{{ $allOrdersCount }}</p>
    </div>
  </div>
</div>





    

    {{-- التحكم والإجراءات --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
    
<form action="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId]) }}"
      method="GET"
      class="flex items-center space-x-2 mb-6">

    <select name="status"
            onchange="this.form.submit()"
            class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-custom">
        <option value="" {{ request('status') == '' ? 'selected' : '' }}>كل الحالات</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>جديد</option>
        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغى</option>
    </select>

    
</form>
{{-- أزرار الطباعة والتصدير --}}
<div class="flex justify-end gap-2 mb-4">
  <button id="printBtn" 
          class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
    <i class="bi bi-printer-fill ml-1"></i> طباعة
  </button>
  <button id="exportBtn" 
          class="bg-custom text-white px-4 py-2 rounded hover:bg-custom_hover transition">
    <i class="bi bi-file-earmark-arrow-down-fill ml-1"></i> تصدير CSV
  </button>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center">
        <i class="bi bi-cart-check-fill text-xl text-custom ml-2"></i>
        <h5 class="text-lg font-bold text-gray-800">قائمة الطلبات</h5>
    </div>
    <div class="p-6 overflow-x-auto">
        <table id="ordersTable" class="min-w-full table-fixed divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-1/12 px-4 py-2 text-center text-gray-600">#</th>
                    <th class="w-3/12 px-4 py-2 text-center text-gray-600">العميل</th>
                    <th class="w-2/12 px-4 py-2 text-center text-gray-600">الإجمالي ({{ config('currency.symbol','﷼') }})</th>
                    <th class="w-2/12 px-4 py-2 text-center text-gray-600">الحالة</th>
                    <th class="w-2/12 px-4 py-2 text-center text-gray-600">حالة الدفع</th>
                    <th class="w-2/12 px-4 py-2 text-center text-gray-600">التاريخ</th>
                    <th class="w-2/12 px-4 py-2 text-center text-gray-600">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3 text-center">{{ $order->id }}</td>
                        <td class="px-4 py-3 text-center">{{ $order->user->username }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusClass = match($order->status) {
                                    'pending'    => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed'  => 'bg-green-100 text-green-800',
                                    'cancelled'  => 'bg-red-100 text-red-800',
                                    default      => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-medium {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $payClass = match($order->payment_status) {
                                    'unpaid'           => 'bg-red-100 text-red-800',
                                    'deposit_uploaded' => 'bg-yellow-100 text-yellow-800',
                                    'paid'             => 'bg-green-100 text-green-800',
                                    'rejected'         => 'bg-gray-100 text-gray-800',
                                    default            => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-block px-2 py-1 rounded-full text-sm font-medium {{ $payClass }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('supermarket.orders.show', ['supermarket_id' => $supermarketId, 'orderId' => $order->id]) }}"
                               class="text-custom hover:underline">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">لا توجد طلبات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



<!-- مكتبة SheetJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>

     document.getElementById('printBtn').addEventListener('click', () => {
    window.print();
  });
  document.getElementById('exportBtn').addEventListener('click', () => {
    const table   = document.getElementById('ordersTable');
    const headers = Array.from(table.querySelectorAll('thead th'))
      .map(th => th.innerText.trim());
    
    // نجمع الصفوف يدوياً
    const data = [ headers ];
    table.querySelectorAll('tbody tr').forEach(tr => {
      const cols = Array.from(tr.querySelectorAll('td')).map((td, i) => {
        let text = td.innerText.trim();
        // إذا كان هذا العمود هو "التاريخ"، أعد تنسيقه إلى DD/MM/YYYY HH:mm
        if (headers[i] === 'التاريخ' && /^\d{4}-\d{2}-\d{2}/.test(text)) {
          const [datePart, timePart] = text.split(' ');
          const [y,m,d] = datePart.split('-');
          text = `${d}/${m}/${y} ${timePart}`;
        }
        return text;
      });
      data.push(cols);
    });

    // أنشئ مصنف وورقة عمل
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(wb, ws, 'Orders');

    // نزّل الملف
    XLSX.writeFile(wb, `orders_${new Date().toISOString().slice(0,10)}.xlsx`);
  });
</script>



@endsection
