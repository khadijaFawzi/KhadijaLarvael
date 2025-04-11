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
           
        </div>
        
        <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">اضافة عرض بالصورة</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
                            <div>
                                <label for="SupermarketName" class="block text-gray-700 font-medium mb-2">
                                اضافة عرض بالصورة<span class="text-red-500">*</span>
                                </label>
                                <input  type="file" name="Image"  id="Image" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 input-field">
                                 
                            </div>
    
                           
                        </div>
        </div>



                   <button type="submit" class="bg-custom hover:bg-indigo-700 font-bold py-2 px-6 rounded-lg transition duration-300">
                   رفع وتحليل
                </button>
    
  
@endsection
