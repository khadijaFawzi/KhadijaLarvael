@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-basket ml-2"></i> تعديل السلة الغذائية
            </h2>
        </div>
        <div class="overflow-x-auto">
            <form action="{{ route('supermarket.food_baskets.update', [$supermarket->id, $foodBasket->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- اسم السلة -->
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">اسم السلة <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            value="{{ old('name', $foodBasket->name) }}">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- السعر -->
<div>
    <label for="price" class="block text-gray-700 font-medium mb-2">السعر <span class="text-red-500">*</span></label>
    <input type="number" step="0.01" name="price" id="price"
        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
        value="{{ old('price', $foodBasket->price) }}">
    @error('price')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                    <!-- صورة السلة -->
                    <div>
                        <label for="image" class="block text-gray-700 font-medium mb-2">تغيير صورة السلة</label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        @if($foodBasket->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$foodBasket->image) }}" class="h-16 w-16 object-cover rounded shadow inline-block">
                                <span class="ml-2 text-gray-600 text-xs">الصورة الحالية</span>
                            </div>
                        @endif
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- وصف السلة -->
                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">وصف السلة</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description', $foodBasket->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- تاريخ البداية -->
                    <div>
                        <label for="start_date" class="block text-gray-700 font-medium mb-2">تاريخ البداية <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            value="{{ old('start_date', $foodBasket->start_date ? $foodBasket->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- تاريخ النهاية -->
                    <div>
                        <label for="end_date" class="block text-gray-700 font-medium mb-2">تاريخ النهاية <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            value="{{ old('end_date', $foodBasket->end_date ? $foodBasket->end_date->format('Y-m-d') : '') }}">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- زر الحفظ -->
                <div class="pt-4 flex justify-center md:justify-end">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                        <i class="bi bi-save mr-2"></i>
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
