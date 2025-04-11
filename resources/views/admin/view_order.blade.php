@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


@extends('admin.layout.master')

@section('content')
<form class="needs-validation" novalidate action="{{ url('/add_products') }}" method="POST" enctype="multipart/form-data"  >
@csrf

    <div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>قائمة الطلبات</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>المنتج</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- طلب 1 -->
                    <tr>
                        <td>1</td>
                        <td>أحمد العلي</td>
                        <td>هاتف ذكي</td>
                        <td>
                            <span class="badge bg-warning">قيد التنفيذ</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <!-- زر تغيير الحالة إلى مكتمل -->
                                <button class="btn btn-success btn-sm">مكتمل</button>
                                <!-- زر تغيير الحالة إلى ملغى -->
                                <button class="btn btn-danger btn-sm">ملغى</button>
                            </div>
                        </td>
                    </tr>
                    <!-- طلب 2 -->
                    <tr>
                        <td>2</td>
                        <td>سارة محمد</td>
                        <td>جهاز لابتوب</td>
                        <td>
                            <span class="badge bg-warning">قيد التنفيذ</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <!-- زر تغيير الحالة إلى مكتمل -->
                                <button class="btn btn-success btn-sm">مكتمل</button>
                                <!-- زر تغيير الحالة إلى ملغى -->
                                <button class="btn btn-danger btn-sm">ملغى</button>
                            </div>
                        </td>
                    </tr>
                    <!-- طلب 3 -->
                    <tr>
                        <td>3</td>
                        <td>علي خالد</td>
                        <td>سماعات</td>
                        <td>
                            <span class="badge bg-success">مكتمل</span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <!-- زر تغيير الحالة إلى مكتمل (موقف لا يتغير) -->
                                <button class="btn btn-secondary btn-sm" disabled>مكتمل</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>
@endsection