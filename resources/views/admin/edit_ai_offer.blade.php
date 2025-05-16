@extends('admin.layout.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mx-auto px-4 py-8">
    <div class="card bg-white p-6 mb-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-pencil-square ml-2"></i> تحرير العرض المحلل
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- صورة العرض -->
            <div class="md:col-span-1">
                <div class="card bg-white shadow rounded-lg overflow-hidden mb-6">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-700">صورة العرض</h3>
                    </div>
                    <div class="p-4 flex justify-center">
                        <img src="{{ asset('offers/' . $offer->image) }}" alt="صورة العرض" class="max-w-full h-auto rounded-lg shadow-sm">
                    </div>
                </div>
                
                <div class="card bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-700">النص المستخرج</h3>
                    </div>
                    <div class="p-4">
                        <div class="bg-gray-100 p-3 rounded-lg text-gray-700 font-mono text-sm overflow-auto max-h-60">
                            {{ $offer->extracted_text ?? 'لم يتم استخراج أي نص' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- نموذج تعديل المعلومات -->
            <div class="md:col-span-2">
                <div class="card bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-700">معلومات العرض</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('update_ai_offer', ['supermarket_id' => $supermarket->id, 'id' => $offer->id]) }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="product_id" class="block text-gray-700 font-medium mb-2">
                                        المنتج <span class="text-red-500">*</span>
                                    </label>
                                    <select name="product_id" id="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                        <option value="">اختر المنتج</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="discount_percentage" class="block text-gray-700 font-medium mb-2">
                                        نسبة الخصم (%) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="discount_percentage" id="discount_percentage" 
                                        min="0" max="100" step="0.01"
                                        value="{{ old('discount_percentage', $offer->discount_percentage) }}" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                </div>
                                
                                <div>
                                    <label for="start_date" class="block text-gray-700 font-medium mb-2">
                                        تاريخ بدء العرض <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="start_date" id="start_date" 
                                        value="{{ old('start_date', $offer->start_date) }}" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                </div>
                                
                                <div>
                                    <label for="end_date" class="block text-gray-700 font-medium mb-2">
                                        تاريخ انتهاء العرض <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="end_date" id="end_date" 
                                        value="{{ old('end_date', $offer->end_date) }}" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="Description" class="block text-gray-700 font-medium mb-2">
                                    وصف العرض
                                </label>
                                <textarea name="Description" id="Description" rows="4" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('Description', $offer->Description) }}</textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <a href="{{ route('show_offers', ['supermarket_id' => $supermarket->id]) }}" class="btn bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-300 ml-2">
                                    إلغاء
                                </a>
                                <button type="submit" class="bg-custom hover:bg-custom_hover text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                                    حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- بطاقة المساعدة والنصائح -->
                <div class="card bg-white shadow rounded-lg overflow-hidden mt-6">
                    <div class="p-4 bg-blue-50 border-b border-blue-100">
                        <h3 class="font-semibold text-blue-700">
                            <i class="bi bi-info-circle ml-2"></i>
                            نصائح للتحقق من المعلومات
                        </h3>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex">
                                <i class="bi bi-check-circle text-green-500 ml-2 mt-1"></i>
                                <span>تأكد من اختيار المنتج الصحيح المرتبط بالعرض</span>
                            </li>
                            <li class="flex">
                                <i class="bi bi-check-circle text-green-500 ml-2 mt-1"></i>
                                <span>تحقق من دقة نسبة الخصم المستخرجة من الصورة</span>
                            </li>
                            <li class="flex">
                                <i class="bi bi-check-circle text-green-500 ml-2 mt-1"></i>
                                <span>تأكد من صحة تواريخ بدء وانتهاء العرض</span>
                            </li>
                            <li class="flex">
                                <i class="bi bi-check-circle text-green-500 ml-2 mt-1"></i>
                                <span>أضف وصفاً واضحاً للعرض يساعد المستخدمين على فهمه</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- بطاقة مقارنة -->
                <div class="card bg-white shadow rounded-lg overflow-hidden mt-6">
                    <div class="p-4 bg-yellow-50 border-b border-yellow-100">
                        <h3 class="font-semibold text-yellow-700">
                            <i class="bi bi-lightning-charge ml-2"></i>
                            ملخص التحليل الآلي
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">المنتج المقترح:</p>
                                    <p class="font-medium">
                                        @if($offer->Product_id && $offer->product)
                                            {{ $offer->product->product_name }}
                                        @else
                                            <span class="text-gray-400">لم يتم التعرف على المنتج</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">نسبة الخصم المقترحة:</p>
                                    <p class="font-medium">
                                        @if($offer->discount_percentage)
                                            {{ $offer->discount_percentage }}%
                                        @else
                                            <span class="text-gray-400">لم يتم التعرف على نسبة الخصم</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">تاريخ البدء المقترح:</p>
                                    <p class="font-medium">
                                        @if($offer->start_date)
                                            {{ \Carbon\Carbon::parse($offer->start_date)->format('Y/m/d') }}
                                        @else
                                            <span class="text-gray-400">لم يتم التعرف على تاريخ البدء</span>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-sm text-gray-500 mb-1">تاريخ الانتهاء المقترح:</p>
                                    <p class="font-medium">
                                        @if($offer->end_date)
                                            {{ \Carbon\Carbon::parse($offer->end_date)->format('Y/m/d') }}
                                        @else
                                            <span class="text-gray-400">لم يتم التعرف على تاريخ الانتهاء</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 p-3 rounded-lg">
                                <p class="text-sm text-green-700 mb-2 font-medium">
                                    <i class="bi bi-stars ml-1"></i>
                                    ملاحظة: يمكنك تعديل أي من المعلومات المستخرجة إذا لم تكن دقيقة.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// تنسيق التاريخ لعرضه بالشكل المناسب
document.addEventListener('DOMContentLoaded', function() {
    // عند تغيير المنتج، إظهار تأكيد
    const productSelect = document.getElementById('product_id');
    productSelect.addEventListener('change', function() {
        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const productName = selectedOption.textContent.trim();
            
            // إضافة تأثير بصري لتأكيد الاختيار
            this.classList.add('border-green-500');
            setTimeout(() => {
                this.classList.remove('border-green-500');
            }, 1000);
        }
    });
    
    // تأكد من أن التواريخ منطقية
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    endDateInput.addEventListener('change', function() {
        if (startDateInput.value && this.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(this.value);
            
            if (endDate < startDate) {
                this.setCustomValidity('يجب أن يكون تاريخ الانتهاء بعد تاريخ البدء');
                this.reportValidity();
            } else {
                this.setCustomValidity('');
            }
        }
    });
    
    startDateInput.addEventListener('change', function() {
        if (endDateInput.value && this.value) {
            const startDate = new Date(this.value);
            const endDate = new Date(endDateInput.value);
            
            if (endDate < startDate) {
                endDateInput.setCustomValidity('يجب أن يكون تاريخ الانتهاء بعد تاريخ البدء');
                endDateInput.reportValidity();
            } else {
                endDateInput.setCustomValidity('');
            }
        }
    });
});
</script>
@endsection