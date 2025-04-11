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
  <div class="container py-5">
    <div class="form-container bg-white p-4 rounded shadow">
     
        <h2 class="mb-4">تواصل معنا</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="name">الاسم:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">البريد الإلكتروني:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group mb-3">
            <label for="subject">الموضوع:</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <div class="form-group mb-3">
            <label for="message">الرسالة:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">إرسال</button>
    </form>
</div>

  <!-- الفوتر -->
  @include('LandPage.footer')

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="{{ asset('/main.js') }}"></script>
</body>
</html>
