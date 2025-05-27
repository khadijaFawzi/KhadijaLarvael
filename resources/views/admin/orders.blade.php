@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success text-center font-bold text-lg mb-6 animate__animated animate__fadeIn">{{ session('success') }}</div>
@endif

<style>
    body { background: linear-gradient(135deg, #5c8076 0%, #83a798 100%) !important; }
    .card-orders {
        background: #ffffffc7;
        border-radius: 1.2rem;
        box-shadow: 0 8px 32px 0 rgba(60,80,70,0.18);
        border: 1px solid #e8ecea;
        overflow: hidden;
    }
    .card-header.bg-primary {
        background: linear-gradient(90deg,#5c8076,#7e9e8e) !important;
        color: #fff;
        border-bottom: 0;
        padding: 2rem 2.5rem;
    }
    .list-group-item {
        background: #f5faf8;
        border: none;
        border-bottom: 1px solid #ebf1ef;
        border-radius: 0.8rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 5px rgba(60,128,118,0.04);
        padding: 1.3rem 1.5rem;
    }
    .list-group-item:last-child { margin-bottom: 0; border-bottom: none; }
    .list-group-item h5 { color: #5c8076; font-weight: 900; }
    .badge.bg-warning { background: linear-gradient(90deg, #ffbf69 0%, #fff8e1 80%); color: #7a5e00; font-size: 1rem; }
    .btn-success { background: #5c8076; border: none; font-weight: 700; }
    .btn-success:hover { background: #446c63; }
    .modal-content { border-radius: 1rem; border: 0;}
    .modal-header { border-bottom: 0; }
    .btn-close { background: none; }
    .modal-title { color: #5c8076; font-weight: bold; }
    .btn-secondary { background: #d3e7e2; color: #5c8076; border: none; }
    .btn-secondary:hover { background: #c2dad4; color: #314b45; }
    .alert-success { border-radius: 1rem; box-shadow: 0 2px 8px #5c807638;}
</style>

<div class="container" style="margin-top:40px; margin-bottom:40px; direction: rtl;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-11">
            <div class="card card-orders">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center shadow">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-list-check me-2"></i>قائمة الطلبات</h4>
                    <span class="badge rounded-pill bg-light text-dark px-3 py-2" style="font-size:1rem;">{{ $orders->count() ?? 2 }} طلب</span>
                </div>
                <div class="card-body px-4 py-5">
                    <div class="list-group">
                        <!-- مثال لعرض الطلبات -->
                        @foreach($orders as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center animate__animated animate__fadeInUp">
                            <div>
                                <h5 class="mb-1">{{ $order->customer_name ?? 'اسم العميل' }}</h5>
                                <div class="small mt-2 text-gray-700">منتج: <span class="fw-bold">{{ $order->product_name ?? 'اسم المنتج' }}</span></div>
                                <div class="small text-muted">التاريخ: {{ $order->order_date ?? now()->format('Y-m-d') }}</div>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning mb-2">{{ $order->status ?? 'قيد التنفيذ' }}</span>
                                <br>
                                <button class="btn btn-success btn-sm px-4 shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#statusModal"
                                    data-order-id="{{ $order->id }}"
                                    data-order-name="{{ $order->customer_name }}"
                                    data-product="{{ $order->product_name }}">
                                    <i class="bi bi-pencil-square"></i> تغيير الحالة
                                </button>
                            </div>
                        </div>
                        @endforeach

                        <!-- إذا لم يوجد طلبات -->
                        @if($orders->isEmpty())
                            <div class="text-center py-5 text-gray-500">لا يوجد طلبات حالياً.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal لتغيير الحالة -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-header pb-0">
                <h5 class="modal-title" id="statusModalLabel"><i class="bi bi-check2-circle me-2"></i>تغيير حالة الطلب</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-2 pb-4">
                <form action="{{ url('/update_order_status') }}" method="POST">
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <input type="hidden" id="order_name" name="order_name">
                    <input type="hidden" id="product_name" name="product_name">
                    <div class="mb-3">
                        <p class="fs-5 text-dark mb-0">هل تريد تحويل الطلب من <b class="text-warning">قيد التنفيذ</b> إلى <b class="text-success">مكتمل؟</b></p>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-success px-4">مكتمل</button>
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // تعبئة بيانات الطلب في المودال عند الضغط على تغيير الحالة
    var statusModal = document.getElementById('statusModal');
    statusModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var orderId = button.getAttribute('data-order-id');
        var orderName = button.getAttribute('data-order-name');
        var productName = button.getAttribute('data-product');
        statusModal.querySelector('#order_id').value = orderId;
        statusModal.querySelector('#order_name').value = orderName;
        statusModal.querySelector('#product_name').value = productName;
    });
</script>
@endsection
