<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام إدارة السوبر ماركت</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- Custom Styles -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');
    body {
        font-family: 'Cairo', sans-serif;
        background-color: #f5f8fa;
    }
    /* اللون الأساسي للوحة التحكم */
    .bg-custom {
        background-color: #5c8076 !important; /* fromARGB(255, 92,128,118) */
    }
    /* هوفر أو تدرجات */
    .bg-custom_hover, .hover\:bg-custom_hover:hover {
        background-color: #45665c !important; /* لون أغمق قليلاً للهوفر */
    }
    /* أزرار رئيسية */
    .btn-primary, .btn-primary:focus {
        color: #fff;
        background-color: #5c8076;
        border-color: #5c8076;
    }
    .btn-primary:hover {
        background-color: #45665c;
        border-color: #45665c;
    }
    /* لون الخط الرئيسي في الـ font */
    .font, .font-semibold {
        color: #5c8076 !important;
    }
    /* خلفية الأيقونة أو العناصر المميزة */
    .stat-icon {
        background-color: #5c8076 !important;
        color: #fff !important;
    }
    /* العناصر الجانبية عند التفعيل */
    .sidebar-item.active {
        background-color: #e8f2ef !important;
        border-right: 4px solid #5c8076 !important;
    }
    /* هوفر الشريط الجانبي */
    .sidebar-item:hover {
        background-color: #e8f2ef !important;
    }
    /* القائمة المنسدلة (الساب مينيو) */
    .sidebar-submenu li a:hover {
        background-color: #e8f2ef !important;
        color: #5c8076 !important;
    }
    /* الفوتر */
    footer.bg-custom {
        background-color: #5c8076 !important;
        color: #fff !important;
    }
    /* أي عنصر تحتاجه بنفس اللون أضف له الكلاس bg-custom */
</style>


    {{-- يمكن إضافة مزيد من الأنماط الخاصة بالصفحات الفرعية --}}
    @yield('styles')
</head>
<body>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-white w-64 fixed inset-y-0 z-10 shadow-md transition-all duration-300 transform translate-x-0 md:relative md:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
             <div class="px-4 py-6 border-b border-gray-200" style="background-color: #5c8076;">
    <h1 class="text-xl font-bold text-white">لوحة تحكم السوبر ماركت</h1>
</div>


                
                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto">
                    <nav class="mt-4">
                        <ul class="sidebar-menu px-2">
                            <!-- Dashboard -->
                            <li class="sidebar-item active bg-blue-50">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-blue-600 rounded-md font-medium">
                                    <div class="flex items-center">
                                        <i class="bi bi-speedometer2 ml-3 text-xl"></i>
                                        <span>لوحة القيادة</span>
                                    </div>
                                </a>
                            </li>
                            
                            <!-- System Information -->
                            <li class="sidebar-item menu-open mt-2">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-gear ml-3 text-xl"></i>
                                        <span>معلومات النظام</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                                <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
                                    <li>
                                        <a href="{{ route('admin.supermarket.edit', ['id' => $supermarket->id]) }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span> الملف الشخصي</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </li>
                            
                            <!-- Products Management -->
                            <li class="sidebar-item menu-open mt-2">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-box-seam ml-3 text-xl"></i>
                                        <span>ادارة المنتجات</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                                <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
                                    <li>
                                        <a href="{{ route('view_product', ['supermarket_id' => $supermarket->id]) }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>اضافة منتج</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('show_product', ['supermarket_id' => $supermarket->id]) }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>عرض المنتجات</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>التصنيفات</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <!-- Offers Management -->
                            <li class="sidebar-item menu-open mt-2">
                                <a class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-tag ml-3 text-xl"></i>
                                        <span>ادارة العروض</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                                <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
                                    <li>
                                        <a href="{{ route('view_offers', ['supermarket_id' => $supermarket->id]) }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>اضافة عرض</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('offers_process', ['supermarket_id' => $supermarket->id]) }}" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>اضافة عرض بواسطة صورة</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('show_offers', ['supermarket_id' => $supermarket->id]) }}">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>عرض العروض</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('Show_offersProces', ['supermarket_id' => $supermarket->id]) }}">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>عرض صورالعروض</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Food Baskets Management -->
@php
    // تأكد من توفر معرف السوبرماركت
    $supermarketId = $supermarket->id ?? (request()->get('supermarket_id') ?? request()->route('supermarket_id'));
@endphp

<li class="sidebar-item menu-open mt-2">
    <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-800 hover:bg-gray-100 rounded-xl transition">
        <div class="flex items-center gap-3">
            <i class="bi bi-basket text-xl text-green-600"></i>
            <span class="font-semibold text-base">السلات الغذائية</span>
        </div>
        <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
    </a>
    <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
        <li>
            <a href="{{ route('supermarket.food_baskets.create', ['supermarket' => $supermarketId]) }}"
               class="flex items-center px-4 py-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md">
                <i class="bi bi-circle ml-3 text-xs"></i>
                <span>إضافة سلة جديدة</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supermarket.food_baskets.index', ['supermarket' => $supermarketId]) }}"
               class="flex items-center px-4 py-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md">
                <i class="bi bi-circle ml-3 text-xs"></i>
                <span>عرض كل السلات</span>
            </a>
        </li>
    </ul>
</li>
<!-- Orders Management -->
<li class="sidebar-item menu-open mt-2">
    <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-800 hover:bg-gray-100 rounded-xl transition">
        <div class="flex items-center gap-3">
            <i class="bi bi-cart3 text-xl text-blue-600"></i>
            <span class="font-semibold text-base">إدارة الطلبات</span>
        </div>
        <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
    </a>

    <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
        <li>
            <a href="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId]) }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-md transition">
                <i class="bi bi-list-ul text-xs text-blue-500 ml-3"></i>
                <span>كل الطلبات</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId, 'status' => 'pending']) }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-md transition">
                <i class="bi bi-hourglass-split text-xs text-blue-500 ml-3"></i>
                <span>طلبات جديدة</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId, 'status' => 'processing']) }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-md transition">
                <i class="bi bi-arrow-repeat text-xs text-blue-500 ml-3"></i>
                <span>قيد المعالجة</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId, 'status' => 'completed']) }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-md transition">
                <i class="bi bi-check2-circle text-xs text-blue-500 ml-3"></i>
                <span>مكتملة</span>
            </a>
        </li>
        <li>
            <a href="{{ route('supermarket.orders.index', ['supermarket_id' => $supermarketId, 'status' => 'cancelled']) }}"
               class="flex items-center px-4 py-2 text-gray-700 hover:text-blue-700 hover:bg-blue-50 rounded-md transition">
                <i class="bi bi-x-circle text-xs text-blue-500 ml-3"></i>
                <span>ملغية</span>
            </a>
        </li>
    </ul>
</li>





                            
                            <!-- Customers Management -->
                            <li class="sidebar-item mt-2">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-people ml-3 text-xl"></i>
                                        <span>ادارة العملاء</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                            </li>
                            
                            <!-- Reports -->
                            <li class="sidebar-item mt-2">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-file-earmark-bar-graph ml-3 text-xl"></i>
                                        <span>التقارير</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <!-- Sidebar Footer -->
                <div class="px-4 py-4 border-t border-gray-200">
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-red-100 hover:text-red-600 rounded-md">
                        <i class="bi bi-box-arrow-right ml-2"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="text-gray-600 focus:outline-none md:hidden">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                        <div class="mr-4 hidden md:block">
                            <h2 class="text-lg font-semibold font">لوحة القيادة</h2>
                            <p class="font">مرحباً بك، أهلاً بعودتك</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <!-- Notifications -->
                        <div class="relative ml-4">
                            <button class="text-gray-600 hover:text-gray-800 focus:outline-none">
                                <i class="bi bi-bell text-xl"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                        </div>
                        <!-- User Menu -->
                        <div class="relative mr-4">
                            <button type="button" class="flex items-center focus:outline-none" id="userMenuBtn">
                                <div class="hidden md:flex md:flex-col md:items-end md:ml-3">
                                    <span class="font text-sm font-semibold">
                                        {{ $supermarket->SupermarketName }}
                                    </span>
                                    <span class="font">مدير النظام</span>
                                </div>
                                <div class="h-9 w-9  flex items-center justify-center overflow-hidden text-white">
    <img class="w-full h-full object-cover" src="{{ asset('uploads/'.$supermarket->profile_image) }}" alt="Profile Image">
</div>

                            </button>
                            <div id="userMenu" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="bi bi-person ml-2"></i>
                                        الملف الشخصي
                                    </a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="bi bi-gear ml-2"></i>
                                        الإعدادات
                                    </a>
                                    <hr class="my-1">
                                    <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        تسجيل الخروج
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Injection Point -->
             
          
            <main class="flex-1 p-6 container mx-auto px-4 py-8 max-h-screen overflow-y-auto">
                @yield('content')
            </main>
                <!-- Footer -->

        </div>
       
    </div>
    
  


    <footer class="bg-custom text-black py-10">
       
       <div class="text-center text-black">
           <p>&copy; 2023 منصة السوبر ماركت. جميع الحقوق محفوظة.</p>
       </div>
     
</footer>
</body>


</html>
