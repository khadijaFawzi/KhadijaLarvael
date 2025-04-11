@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


@extends('admin.layout.master')

@section('content')
<div class="card card-warning card-outline mb-4">
    <div class="card-header">
        <div class="card-title">إضافة منتج</div>
    </div>
    <form class="needs-validation" novalidate method="POST" action="{{ url('/products') }}">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="product_name" class="form-label">اسم المنتج</label>
                    <input type="text" name="product_name" class="form-control" id="product_name" required>
                    <div class="valid-feedback">Looks good!</div>
                </div>
                
                <div class="col-md-6">
                    <label for="price" class="form-label">السعر</label>
                    <input type="number" name="price" class="form-control" id="price" step="0.01" required>
                </div>

                <div class="col-md-6">
                    <label for="image" class="form-label">رابط الصورة</label>
                    <input type="text" name="image" class="form-control" id="image" required>
                </div>

                <div class="col-md-6">
                    <label for="category_id" class="form-label">الفئة</label>
                    <select name="category_id" class="form-control" id="category_id" required>
                        <option value="">اختر فئة</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-12">
                    <label for="description" class="form-label">وصف</label>
                    <textarea name="description" class="form-control" id="description"></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">إضافة منتج</button>
        </div>
    </form>
</div>
@endsection