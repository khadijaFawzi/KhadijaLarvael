<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>من نحن - Vibe Cart</title>

  <!-- CSS الأساسي -->
  <link rel="stylesheet" href="{{ asset('/styles.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- إضافة Font Awesome للأيقونات -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <style>
    body {
      background-color: #f4f4f4;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .about-container {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .section-header {
      margin-bottom: 30px;
    }
    .about-content {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #333;
      text-align: justify;
    }
    .about-content p {
      margin-bottom: 20px;
    }
    .social-links {
      text-align: center;
      margin-top: 30px;
    }
    .social-links a {
      margin: 0 10px;
      font-size: 1.5rem;
      color: #333;
      transition: color 0.3s;
    }
    .social-links a:hover {
      color: #007bff;
    }
  </style>
</head>
<body>

  <!-- الهيدر (nav) -->
  @include('LandPage.header')

  <!-- محتوى الصفحة -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="about-container">
          <div class="section-header text-center">
            <h2>من نحن</h2>
          </div>
          <div class="about-content">
            <p>
              مرحبًا بكم في منصة 
              <span class="nav__logo">
                <a href="#">Vibe<span>Cart</span>.</a>
              </span>
              ، حيث نجمع بين التقنية والابتكار لتقديم تجربة تسوق مميزة. تتيح منصتنا للسوبر ماركتات إمكانية إضافة منتجاتها وعروضها بسهولة ويسر، مما يسهم في تعزيز التواصل مع العملاء وتوفير معلومات دقيقة ومحدثة عن أحدث العروض والتشكيلات المتنوعة.
            </p>
            <p>
              نؤمن بأن الشفافية والتجديد هما مفتاح النجاح في عالم التجارة الإلكترونية، ولذلك نعمل على توفير بيئة رقمية متكاملة تضمن للمستخدمين سهولة الوصول للمنتجات والعروض مع دعم تقني متواصل لضمان تجربة استخدام سلسة وآمنة.
            </p>

            <!-- قسم حسابات التواصل الاجتماعي -->
<div class="social-links">
  <div class="d-inline-block text-center mx-2">
    <a href="https://www.facebook.com" target="_blank" title="Facebook">
      <i class="fab fa-facebook-f"></i>
    </a>
    <div class="social-text mt-1">VibCart</div>
  </div>
  <div class="d-inline-block text-center mx-2">
    <a href="https://www.twitter.com" target="_blank" title="Twitter">
      <i class="fab fa-twitter"></i>
    </a>
    <div class="social-text mt-1">@VibCart</div>
  </div>
  <div class="d-inline-block text-center mx-2">
    <a href="https://www.instagram.com" target="_blank" title="Instagram">
      <i class="fab fa-instagram"></i>
    </a>
    <div class="social-text mt-1">_VibCart</div>
  </div>
 
</div>
<!-- نهاية قسم حسابات التواصل الاجتماعي -->

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- الفوتر -->
  @include('LandPage.footer')

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="{{ asset('/main.js') }}"></script>
</body>
</html>
