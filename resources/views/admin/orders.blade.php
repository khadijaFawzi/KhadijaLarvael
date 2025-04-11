@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


@extends('admin.layout.master')

@section('content')
<form class="needs-validation" novalidate action="{{ url('/add_products') }}" method="POST" enctype="multipart/form-data"  >
@csrf

<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4>قائمة الطلبات</h4>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <!-- عرض الطلبات هنا -->
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>أحمد علي</h5>
                                <p class="mb-0">منتج: هاتف ذكي</p>
                                <p class="mb-0">التاريخ: 2025-02-21</p>
                            </div>
                            <div>
                                <span class="badge bg-warning">قيد التنفيذ</span>
                                <button class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#statusModal" data-order-id="1" data-order-name="أحمد علي" data-product="هاتف ذكي">
                                    تغيير الحالة
                                </button>
                            </div>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>محمد سامي</h5>
                                <p class="mb-0">منتج: لابتوب</p>
                                <p class="mb-0">التاريخ: 2025-02-20</p>
                            </div>
                            <div>
                                <span class="badge bg-warning">قيد التنفيذ</span>
                                <button class="btn btn-success btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#statusModal" data-order-id="2" data-order-name="محمد سامي" data-product="لابتوب">
                                    تغيير الحالة
                                </button>
                            </div>
                        </div>
                        <!-- المزيد من الطلبات هنا -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal لتغيير الحالة -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">تغيير حالة الطلب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد أنك تريد تغيير حالة الطلب من "قيد التنفيذ" إلى "مكتمل"؟</p>
                <form action="{{ url('/update_order_status') }}" method="POST">
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <input type="hidden" id="order_name" name="order_name">
                    <input type="hidden" id="product_name" name="product_name">
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">مكتمل</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // جلب البيانات عند الضغط على زر "تغيير الحالة"
    var statusModal = document.getElementById('statusModal');
    statusModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var orderId = button.getAttribute('data-order-id');
        var orderName = button.getAttribute('data-order-name');
        var productName = button.getAttribute('data-product');

        var orderIdInput = statusModal.querySelector('#order_id');
        var orderNameInput = statusModal.querySelector('#order_name');
        var productNameInput = statusModal.querySelector('#product_name');

        orderIdInput.value = orderId;
        orderNameInput.value = orderName;
        productNameInput.value = productName;
    });
</script>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
@endsection