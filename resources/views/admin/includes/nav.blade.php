@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="container mx-auto px-4 py-8">
    <!-- بطاقة إدارة المنتجات -->
    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-box-seam ml-2"></i> إدارة العروض
            </h2>
            <a action="{{ route('add_offers', ['supermarket_id' => $supermarket->id]) }}"  class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg flex items-center transition duration-300">
                <i class="bi bi-plus-circle ml-1"></i> إضافة عرض جديد
            </a>
        </div>
        
        <div class="card-header">
    <h2 class="text-center" style="font-style: italic; color:darkslategray">اضافة عرض بالصورة</h2>
    <br/>
    <table class="table table-striped table-bordered">
    <thead class="thead-dark">





    <div class="col-md-6">
                    <label for="Image" class="form-label">رابط الصورة</label>
                    <input type="file" name="Image" class="form-control" id="Image" required>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">رفع وتحليل</button>
                </div>
    
  
@endsection
