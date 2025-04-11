<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>السوبرماركتات المسجلة - Vibe Cart</title>
  <!-- CSS الأساسي -->
  <link rel="stylesheet" href="{{ asset('/styles.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f4f4;
    }
    .supermarket-card {
      margin-bottom: 30px;
    }
    .supermarket-card img {
      width: 100%;
      height: 200px; /* لتوحيد ارتفاع الصور */
      object-fit: cover;
      border-radius: 10px;
    }
    .card-title {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <!-- الهيدر -->
  @include('LandPage.header')

  <!-- محتوى الصفحة -->
  <div class="container py-5">
    <h2 class="mb-4 text-center">السوبرماركتات المسجلة</h2>
    <div class="row">
      @forelse ($supermarkets as $supermarket)
        <div class="col-md-4 supermarket-card">
          <div class="card">
            @if($supermarket->profile_image)
              <img src="{{ asset('uploads/' . $supermarket->profile_image) }}" class="card-img-top" alt="{{ $supermarket->SupermarketName }}">
            @else
              <img src="{{ asset('images/default-profile.png') }}" class="card-img-top" alt="صورة السوبرماركت">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $supermarket->SupermarketName }}</h5>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p class="text-center">لا توجد سوبرماركتات مسجلة في الموقع.</p>
        </div>
      @endforelse
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
