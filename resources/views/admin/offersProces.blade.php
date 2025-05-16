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
                <i class="bi bi-image ml-2"></i> إضافة عرض بواسطة صورة
            </h2>
        </div>
        
        <div class="mb-6">
            <p class="text-gray-600 mb-4">
                قم برفع صورة العرض وسيقوم النظام تلقائياً بتحليلها واستخراج معلومات العرض منها.
                بعد التحليل، يمكنك مراجعة المعلومات المستخرجة وتعديلها إذا لزم الأمر.
            </p>
            
            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg mb-6">
                <div class="flex">
                    <i class="bi bi-info-circle text-xl ml-3"></i>
                    <div>
                        <h4 class="font-bold mb-1">تلميحات للحصول على أفضل النتائج:</h4>
                        <ul class="list-disc list-inside">
                            <li>تأكد من أن الصورة واضحة وبجودة عالية</li>
                            <li>يجب أن تحتوي الصورة على النص الواضح للعرض بما في ذلك نسبة الخصم والتواريخ</li>
                            <li>تجنب الصور ذات الإضاءة الضعيفة أو الضبابية</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <form action="{{ route('process_offer_image', ['supermarket_id' => $supermarket->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="mb-6">
                
                    <label for="image" class="block text-gray-700 font-medium mb-2">
                        صورة العرض <span class="text-red-500">*</span>
                    </label>
                    <div>
                        <label for="product_id" class="block text-gray-700 font-medium mb-2">المنتج</label>
                        <div class="relative">
                            <select name="product_id" id="product_id" class="custom-input block w-full px-4 py-3 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none" >
                                <option value="" selected disabled>اختر المنتج</option>
                                @foreach($product as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-700">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:bg-gray-50 transition-colors" id="drop-area">
                        <input type="file" name="image" id="image" 
                            class="hidden" accept="image/*" onchange="updateFileInfo(this)">
                        
                        <label for="image" class="cursor-pointer">
                            <div id="preview-container" class="hidden mb-4 flex justify-center">
                                <img id="preview-image" src="#" alt="معاينة الصورة" class="max-h-48">
                            </div>
                            
                            <div id="upload-prompt">
                                <i class="bi bi-cloud-arrow-up text-4xl text-gray-400 mb-2"></i>
                                <p class="mb-1 font-medium">اسحب الصورة هنا أو اضغط للرفع</p>
                                <p class="text-gray-500 text-sm">PNG, JPG, GIF حتى 2MB</p>
                            </div>
                            
                            <div id="file-info" class="hidden mt-3 text-sm text-gray-600">
                                <span id="file-name"></span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('show_offers', ['supermarket_id' => $supermarket->id]) }}" class="btn px-6 py-2 border border-gray-300 rounded-lg text-gray-700 ml-2 hover:bg-gray-50 transition-colors">
                    إلغاء
                </a>
                <button type="submit" class="bg-custom hover:bg-custom_hover text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                    رفع وتحليل
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileInfo(input) {
        const fileInfo = document.getElementById('file-info');
        const fileName = document.getElementById('file-name');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const uploadPrompt = document.getElementById('upload-prompt');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // عرض اسم الملف
            fileName.textContent = file.name;
            fileInfo.classList.remove('hidden');
            
            // عرض معاينة الصورة
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            fileInfo.classList.add('hidden');
            previewContainer.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
        }
    }
    
    // إضافة دعم السحب والإفلات
    const dropArea = document.getElementById('drop-area');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropArea.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight() {
        dropArea.classList.remove('border-blue-500', 'bg-blue-50');
    }
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const fileInput = document.getElementById('image');
        
        fileInput.files = files;
        updateFileInfo(fileInput);
    }
</script>
@endsection