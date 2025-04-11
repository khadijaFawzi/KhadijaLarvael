<!-- resources/views/partials/header.blade.php -->
<link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
<nav>
  <div class="nav__header">
    <div class="nav__logo">
      <a href="#">Vibe<span>Cart</span>.</a>
    </div>
    <div class="nav__menu__btn" id="menu-btn">
      <span><i class="ri-menu-line"></i></span>
    </div>
  </div>
  <ul class="nav__links" id="nav-links">
       <li><a href="{{ route('home') }}">الرئيسية</a></li>
       <li><a href="{{ route('members') }}">الاعضاءالمسجلين</a></li>
          <li><a href="{{ route('Terms') }}">شروط المنصة</a></li>
          <li><a href="{{ route('about_us') }}">من نحن</a></li>
         
        </ul>
        <div class="nav__btns">
          <a href="{{ route('register') }}" class="btn sign__up">Sign Up</a>
          <a href="{{ route('login') }}" class="btn sign__in">Sign In</a>
        </div>
      </nav>
