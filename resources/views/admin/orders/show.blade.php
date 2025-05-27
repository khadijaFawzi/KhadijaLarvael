@extends('admin.layout.master')

@section('title', "تفاصيل الطلب #{$order->id}")

@section('content')
@php
    $supermarketId = request()->route('supermarket_id');
@endphp

<div class="container mx-auto px-4 py-6 space-y-6">
  <!-- رأس الصفحة -->
  <div class="bg-white rounded-lg shadow px-6 py-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">تفاصيل الطلب #{{ $order->id }}</h2>
    <span class="text-gray-600">تاريخ الطلب  {{ $order->created_at->format('Y-m-d H:i') }}</span>
  </div>

  <!-- بيانات العميل ومعلومات الطلب -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- بيانات العميل -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4 text-gray-800">بيانات العميل</h3>
      <ul class="space-y-2 text-gray-700">
        <li><span class="font-medium">الاسم:</span> {{ $order->user->name }}</li>
        <li><span class="font-medium">البريد الإلكتروني:</span> {{ $order->user->email }}</li>
        <li><span class="font-medium">الهاتف:</span> {{ $order->user->phone ?? '-' }}</li>
      </ul>
    </div>
    <!-- معلومات الطلب -->
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4 text-gray-800">معلومات الطلب</h3>
      <ul class="space-y-2 text-gray-700">
        <li><span class="font-medium">الحالة:</span> {{ ucfirst($order->status) }}</li>
        <li><span class="font-medium">حالة الدفع:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</li>
       
        <li><span class="font-medium">كود التتبع:</span> {{ $order->tracking_code ?? '-' }}</li>
      </ul>
    </div>
  </div>

  <!-- الإيصال المرفوع -->
  @if($order->payment_status === 'deposit_uploaded' && $order->deposit_receipt)
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold mb-4 text-gray-800">الإيصال المرفوع</h3>
      <img src="{{ Storage::url($order->deposit_receipt) }}"
           alt="deposit receipt"
           class="rounded-lg shadow max-w-xs">
    </div>
  @endif

  <!-- تفاصيل المنتجات -->
<div>
  <h3 class="text-lg font-semibold mb-4 text-gray-800">تفاصيل المنتجات</h3>
  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="table-fixed w-full divide-y divide-gray-200 text-center">
      <!-- تعريف أعمدة العرض -->
      <colgroup>
        <col class="w-1/12">
        <col class="w-3/12">
        <col class="w-2/12">
        <col class="w-2/12">
        <col class="w-2/12">
        <col class="w-2/12">
      </colgroup>
      <thead class="bg-gray-50">
        <tr>
          <th class="px-2 py-3 text-gray-600">#</th>
          <th class="px-2 py-3 text-gray-600">المنتج</th>
          <th class="px-2 py-3 text-gray-600">الكمية</th>
          <th class="px-2 py-3 text-gray-600">سعر الوحدة ({{ config('currency.symbol','﷼') }})</th>
          <th class="px-2 py-3 text-gray-600">المجموع</th>
          <th class="px-2 py-3 text-gray-600">ملاحظات</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        @foreach($order->orderDetails as $detail)
          <tr>
            <td class="px-2 py-3">{{ $loop->iteration }}</td>
            <td class="px-2 py-3">{{ $detail->product->product_name }}</td>
            <td class="px-2 py-3">{{ $detail->quantity }}</td>
            <td class="px-2 py-3">{{ number_format($detail->price, 2) }}</td>
            <td class="px-2 py-3">{{ number_format($detail->quantity * $detail->price, 2) }}</td>
            <td class="px-2 py-3">{{ $detail->note ?? '-' }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-gray-50">
        <tr>
          <td colspan="4" class="px-2 py-3 font-medium text-gray-700 text-right">الإجمالي الكلي:</td>
          <td colspan="2" class="px-2 py-3 font-semibold text-gray-800">
            {{ number_format($order->total, 2) }} {{ config('currency.symbol','﷼') }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>


<!-- نماذج التحديث بمحاذاة أزرار في نفس المستوى -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <!-- تحديث حالة الدفع -->
  <div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">تحديث حالة الدفع</h3>
    <form action="{{ route('supermarket.orders.payment', ['supermarket_id' => $supermarketId, 'orderId' => $order->id]) }}"
          method="POST"
          class="flex flex-col flex-grow">
      @csrf
      @method('PATCH')
      <select name="payment_status"
              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-custom mb-4">
        <option value="unpaid" {{ $order->payment_status=='unpaid' ? 'selected' : '' }}>غير مدفوع</option>
        <option value="deposit_uploaded" {{ $order->payment_status=='deposit_uploaded' ? 'selected' : '' }}>إيصال مرفوع</option>
        <option value="paid" {{ $order->payment_status=='paid' ? 'selected' : '' }}>مدفوع</option>
        <option value="rejected" {{ $order->payment_status=='rejected' ? 'selected' : '' }}>مرفوض</option>
      </select>
      <button type="submit"
              class="mt-auto w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
        حفظ الدفع
      </button>
    </form>
  </div>

  <!-- تحديث حالة الطلب والشحن -->
  <div class="bg-white rounded-lg shadow p-6 flex flex-col h-full">
    <h3 class="text-lg font-semibold mb-4 text-gray-800">تحديث حالة الطلب </h3>
    <form action="{{ route('supermarket.orders.update', ['supermarket_id' => $supermarketId, 'orderId' => $order->id]) }}"
          method="POST"
          class="flex flex-col flex-grow">
      @csrf
      @method('PATCH')
      <select name="status"
              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-custom mb-4">
        <option value="pending"    {{ $order->status=='pending' ? 'selected' : '' }}>جديد</option>
        <option value="processing" {{ $order->status=='processing' ? 'selected' : '' }}>قيد المعالجة</option>
        <option value="completed"  {{ $order->status=='completed' ? 'selected' : '' }}>مكتمل</option>
        <option value="cancelled"  {{ $order->status=='cancelled' ? 'selected' : '' }}>ملغى</option>
      </select>
      
      <input type="text"
             name="tracking_code"
             placeholder="كود التتبع"
             value="{{ old('tracking_code', $order->tracking_code) }}"
             class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-custom mb-4">
      <button type="submit"
              class="mt-auto w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
        حفظ التغييرات
      </button>
    </form>
  </div>
</div>

</div>
@endsection
