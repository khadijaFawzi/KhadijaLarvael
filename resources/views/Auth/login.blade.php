<!-- resources/views/login-modal.blade.php -->
<!-- Login Modal -->
<div id="login-modal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="modal-container bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">تسجيل الدخول</h3>
            <button class="close-modal text-gray-400 hover:text-gray-600 transition focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- تم تعديل النموذج ليرسل بياناته عبر POST إلى مسار login -->
        <form id="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="login-email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                <input type="email" id="login-email" name="email" class="form-input w-full" placeholder="أدخل بريدك الإلكتروني" required>
            </div>
            
            <div class="mb-6">
                <label for="login-password" class="block text-gray-700 font-medium mb-2">كلمة المرور</label>
                <input type="password" id="login-password" name="password" class="form-input w-full" placeholder="أدخل كلمة المرور" required>
                <div class="flex justify-between mt-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember-me" name="remember" class="ml-2">
                        <label for="remember-me" class="text-gray-600 text-sm">تذكرني</label>
                    </div>
                    <a href="#" class="text-blue-500 text-sm hover:text-blue-600 transition">نسيت كلمة المرور؟</a>
                </div>
            </div>
            
            <button type="submit" class="w-full py-3 btn-primary text-white rounded-lg font-bold">تسجيل الدخول</button>
            
            <div class="text-center mt-4">
                <p class="text-gray-600">ليس لديك حساب؟ <a href="#" id="switch-to-signup" class="text-blue-500 hover:text-blue-600 transition">إنشاء حساب</a></p>
            </div>
        </form>
    </div>
</div>
