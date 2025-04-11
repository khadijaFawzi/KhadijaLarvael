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
      height: auto;
      border-radius: 10px;
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
            @if($supermarket->image)
              <img src="{{ asset('storage/supermarkets/' . $supermarket->image) }}" class="card-img-top" alt="{{ $supermarket->name }}">
            @else
              <img src="{{ asset('images/default_supermarket.png') }}" class="card-img-top" alt="صورة السوبرماركت">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $supermarket->name }}</h5>
              <p class="card-text">
                {{ \Illuminate\Support\Str::limit($supermarket->description, 100) }}
              </p>
              <a href="{{ route('supermarkets.show', $supermarket->id) }}" class="btn btn-primary">عرض التفاصيل</a>
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
