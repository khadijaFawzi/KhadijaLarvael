@extends('admin.layout.master')
@section('content')


@csrf
    
<div class="container">
        <h1>مرحبا بك في لوحة تحكم السوبر ماركت</h1>
        <h2>{{ $supermarket->SupermarketName }}</h2>
        <!-- يمكنك إضافة المزيد من المعلومات مثل المنتجات أو العروض -->
    </div>

@endsection