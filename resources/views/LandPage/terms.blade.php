<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>الشروط والأحكام - Vibe Cart</title>

  <!-- CSS الأساسي -->
  <link rel="stylesheet" href="{{ asset('/styles.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f4f4f4;
      /* لا نضع هنا direction بحيث يبقى تنسيق الهيدر كما هو */
    }
    .form-container {
      max-width: 650px;
      margin: auto;
    }
    .error-message {
      color: red;
      text-align: center;
    }
    /* تطبيق اتجاه النص من اليمين لليسار على محتوى الشروط فقط */
    .terms-content {
      direction: rtl;
      text-align: right;
    }
  </style>
</head>
<body>
  <!-- الهيدر (nav) - لن يتأثر -->
  @include('LandPage.header')

  <!-- محتوى الصفحة -->
  <div class="container py-5">
    <div class="form-container bg-white p-4 rounded shadow terms-content">
      <form id="loginForm" action="{{ route('login') }}" method="POST">
        @csrf
        <h2 class="text-center mb-4">الشروط والأحكام</h2>

        <h4>1. مقدمة</h4>
        <p>
          تقدم منصة <span class="nav__logo">
                <a href="#">Vibe<span>Cart</span>.</a>
              </span>  خدماتها للمستخدمين والسوبرماركتات بهدف توفير بيئة تسوق إلكترونية متكاملة.
          باستخدام هذه المنصة، فإنكم تقرون بأنكم قد قرأتم وفهمتم هذه الشروط وتوافقون على الالتزام بها.
        </p>
        
        <h4>2. استخدام المنصة</h4>
        <ul>
          <li>يجب على المستخدمين تقديم معلومات صحيحة عند التسجيل واستخدام المنصة.</li>
          <li>لا يُسمح باستخدام المنصة لأي نشاط غير قانوني أو غير أخلاقي.</li>
          <li>تحتفظ المنصة بالحق في تعليق أو إنهاء حساب أي مستخدم ينتهك هذه الشروط.</li>
        </ul>
        
        <h4>3. حقوق الملكية الفكرية</h4>
        <p>
          جميع المحتويات، بما في ذلك النصوص والصور والرسومات والشعارات، هي ملك لمنصة Vibe Cart أو للجهات المصرح لها.
          لا يجوز إعادة إنتاج أو توزيع أو نشر أي جزء من هذه المحتويات دون الحصول على إذن خطي مسبق.
        </p>
        
        <h4>4. الخصوصية وحماية البيانات</h4>
        <p>
          تلتزم منصة Vibe Cart بحماية خصوصية المستخدمين وبياناتهم الشخصية.
          يرجى مراجعة سياسة الخصوصية لمعرفة كيفية جمع واستخدام البيانات.
        </p>
        
        <h4>5. التغييرات على الشروط</h4>
        <p>
          تحتفظ منصة Vibe Cart بالحق في تعديل هذه الشروط في أي وقت.
          سيتم إشعار المستخدمين بالتغييرات الجوهرية، ويُعتبر استمرار استخدام المنصة بعد هذه التعديلات بمثابة موافقة صريحة عليها.
        </p>
        
        <h4>6. القانون المعمول به</h4>
        <p>
          تُفسر هذه الشروط وتُطبق وفقاً للقوانين المعمول بها في [بلدك].
          وفي حالة حدوث أي نزاع، تكون المحاكم في [المدينة/البلد] هي المختصة.
        </p>
        
        <h4>7. التواصل والدعم</h4>
        <p>
          إذا كانت لديكم أي استفسارات أو تحتاجون إلى دعم، يُرجى التواصل معنا عبر البريد الإلكتروني أو من خلال قنوات الاتصال المتوفرة على المنصة.
        </p>
        
        <p class="text-center mt-4">
          باستخدامكم للمنصة، فإنكم تقرون بأنكم قد قرأتم وفهمتم وتوافقون على الالتزام بهذه الشروط والأحكام.
        </p>
      </form>
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
