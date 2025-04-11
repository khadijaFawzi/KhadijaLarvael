@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


@extends('admin.layout.master')

@section('content')
<form class="needs-validation" novalidate action="{{ route('update_offers_confirm', ['supermarket_id' => $currentSupermarket->id, 'id' => $offer->id]) }}" method="POST" enctype="multipart/form-data"  >
@csrf
<div class="card card-warning card-outline mb-4">
    <div class="card-header">
        <div class="card-title">إضافة عرض</div>
    </div>
   
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="Product_id" class="form-label">رقم المنتج</label>
                
                    <select name="Product_id" class="form-control" id="Product_id" required  value="{{$offer->Product_id}}">
                    
                    <option value="{{$offer->Product_id}}" selected="">{{$offer->Product_id}}</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
                </div>
                
                
                <div class="col-md-6">
                    <label for="start_date" class="form-label"> تاريخ بدءالعرض</label>
                    <input type="date"  name="start_date" class="form-control" id="start_date" required value="{{$offer->start_date}}">
                </div>
                

                <div class="col-md-6">
    <label for="end_date" class="form-label"> تاريخ انتهاءالعرض</label>
    <input type="date" name="end_date" class="form-control" id="end_date" required value="{{$offer->end_date}}">
</div>

<div class="col-md-12">
    <label for="discount_percentage" class="form-label">نسبة التخفيض (%)</label>
    <div class="input-group">
        <input type="number" name="discount_percentage" class="form-control" id="discount_percentage" step="0.01" min="0" required value="{{$offer->discount_percentage}}">
        <span class="input-group-text">%</span>
    </div>
    
</div>

               
                
                <div class="col-md-12">
                    <label for="Description" class="form-label">وصف</label>
                    <input type="text" name="Description" class="form-control" id="Description" step="0.01" required value="{{$offer->Description}}">
                </div>
                <div class="card-footer">
            <button type="submit" class="btn btn-warning">إضافة عرض</button>
        </div>
            </div>
        </div>
       
    </form>
</div>
@endsection