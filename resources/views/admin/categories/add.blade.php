


@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    

<div class="card card-warning card-outline mb-4">
    <!--begin::Header-->
    <div class="card-header">
        <h3 class="card-title">إضافة فئة</h3>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form 
        action="{{ route('admin.categories.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        <!--begin::Body-->
        <div class="card-body">
            <div class="row mb-3">
                <label for="categoryName" class="col-sm-2 col-form-label">اسم الفئة</label>
                <div class="col-sm-10">
                    <input 
                        type="text" 
                        name="CategoryName" 
                        class="form-control @error('CategoryName') is-invalid @enderror" 
                        id="categoryName" 
                        value="{{ old('CategoryName') }}"
                    >
                    @error('CategoryName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <label for="icon" class="col-sm-2 col-form-label">أيقونة الفئة</label>
                <div class="col-sm-10">
                    <input 
                        type="file" 
                        name="icon" 
                        class="form-control @error('icon') is-invalid @enderror" 
                        id="icon" 
                        accept="image/*"
                    >
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <!--end::Body-->
        
        <!--begin::Footer-->
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">إضافة فئة</button>
        </div>
        <!--end::Footer-->
    </form>
    <!--end::Form-->
</div>



@endsection