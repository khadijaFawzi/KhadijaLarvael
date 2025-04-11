<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>تسجيل الدخول - Vibe Cart</title>

  <!-- CSS الأساسي -->
  <link rel="stylesheet" href="{{ asset('/styles.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f4f4f4;
    }
    .form-container {
      max-width: 650px;
      margin: auto;
    }
    .error-message {
      color: red;
      text-align: center;
    }
  </style>
</head>

<body>

  <!-- الهيدر (nav) -->
  @include('LandPage.header')

  <!-- محتوى الصفحة -->
  <!-- محتوى الصفحة -->
<div class="container main-content d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center w-100 text-center">
        <h2 class="mb-4 w-100">اختر نوع الحساب الذي تريد إنشاؤه</h2>
        
        <!-- بطاقة السوبر ماركت -->
        <div class="col-md-4 mb-3 d-flex justify-content-center">
            <div class="card shadow-sm" style="width: 22rem;">
                <img src="product/Supermarket.jpg" class="card-img-top" alt="سوبرماركت">
                <div class="card-body">
                    <h5 class="card-title">تسجيل كـ سوبرماركت</h5>
                    <p class="card-text">قم بإدارة منتجاتك وعروضك بسهولة.</p>
                    <a href="/CreateSupermarket" class="btn btn-primary">تسجيل</a>

                </div>
            </div>
        </div>
        
        <!-- بطاقة العميل -->
        <div class="col-md-4 mb-3 d-flex justify-content-center">
            <div class="card shadow-sm" style="width: 22rem;">
                <img src="product/customer.jpg" class="card-img-top" alt="عميل">
                <div class="card-body">
                    <h5 class="card-title">تسجيل كـ عميل</h5>
                    <p class="card-text">اكتشف العروض واحصل على أفضل الأسعار.</p>
                    <a href="#" class="btn btn-success">تسجيل</a>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- ذيل الصفحة -->
    <footer>
       
        <div>
            <!-- إضافة أيقونات وسائل التواصل الاجتماعي -->
            <a href="https://www.facebook.com" target="_blank">
                <i class="fab fa-facebook-square"></i>
                <label>VibeCart</label>
            </a>
            <a href="https://twitter.com" target="_blank">
                <i class="fab fa-twitter-square"></i>
                <label>T_VibeCart</label>
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <i class="fab fa-instagram-square"></i>
                <label>Vibe_Cart</label>
            </a>
            
        </div>
    <!-- الفوتر -->
  @include('LandPage.footer')

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('/main.js') }}"></script>
</body>
</html>
