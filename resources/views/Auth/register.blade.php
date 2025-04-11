<!DOCTYPE html>
<html lang="ar">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ربط ملف CSS الخاص بك -->
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    
    <!-- ربط ملف Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <title>إنشاء حساب</title>

    <style>
        body {
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 650px; /* جعل العرض أصغر */
            width: 100%;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>

    <!-- تضمين الهيدر -->
    @include('LandPage.header')

</head>
<body>

    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 70vh;">
        <form id="registerForm" class="bg-white p-4 rounded shadow form-container" action="{{ route('register') }}" method="POST">
            @csrf 
            <h2 class="text-center">إنشاء حساب</h2>

            <div class="form-group">
                <label for="username">الاسم الكامل</label>
                <input type="text" id="username" name="username" class="form-control" required value="{{ old('name') }}">
            </div>
            
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">إعادة كلمة المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary d-block mx-auto" style="width: 100%; background-color: orange; border-color: orange;">إنشاء حساب</button>

            <p class="error-message" id="error-message"></p>

            <div class="text-center mt-3">
                <small>لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-primary">تسجيل الدخول</a></small>
            </div>

            <!-- عرض أخطاء التحقق -->
            @if($errors->any())
                <ul class="mt-3 text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

        </form>
    </div>

    <!-- تضمين الفوتر -->
    @include('LandPage.footer')

    <!-- ربط ملفات الجافاسكربت -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('main.js') }}"></script>

</body>
</html>
