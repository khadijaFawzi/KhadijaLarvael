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
        .bg-custom {
            background-color: #d7c3b0;
        }
        .bg-custom_hover{
           background-color:AE(255,139,90,43)
        }
      
        .font {
            forced-color-adjust: #e6c19a;
        }
        
        .sidebar-item.active {
            background-color: #f8fafc;
            border-right: 4px solid #3b82f6;
        }
        
        .sidebar-item:hover {
            background-color: #f1f5f9;
        }
        
        .sidebar-menu .nav-arrow {
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar-menu .menu-open .nav-arrow {
            transform: rotate(90deg);
        }
        
        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }
        
        .sidebar-menu .menu-open .sidebar-submenu {
            max-height: 1000px;
        }
        
        .alert {
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        
        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
        }
        
        .form-control {
            display: block;
            width: 100%;
            padding: 0.5rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #4b5563;
            background-color: white;
            background-clip: padding-box;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out;
        }
        
        .form-control:focus {
            border-color: #93c5fd;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        
        .btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.375rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
            cursor: pointer;
        }
        
        .btn-primary {
            color: white;
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-danger {
            color: white;
            background-color: #ef4444;
            border-color: #ef4444;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            border-color: #dc2626;
        }
        
        .btn-success {
            color: white;
            background-color: #10b981;
            border-color: #10b981;
        }
        
        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }
        
        .btn-warning {
            color: #1f2937;
            background-color: #fbbf24;
            border-color: #fbbf24;
        }
        
        .btn-warning:hover {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        
        table th, table td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }
        
        table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e5e7eb;
            background-color: #f9fafb;
            color: #4b5563;
            font-weight: 600;
        }
        
        table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(249, 250, 251, 0.5);
        }
        
        .table-bordered {
            border: 1px solid #e5e7eb;
        }
        
        .table-bordered th, .table-bordered td {
            border: 1px solid #e5e7eb;
        }
        
        /* Dashboard Styles */
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        /* Timeline for recent activities */
        .timeline {
            position: relative;
            padding-right: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: 10px;
            width: 2px;
            background-color: #e5e7eb;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .timeline-marker {
            position: absolute;
            top: 0;
            right: -2rem;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #3b82f6;
            background-color: white;
            z-index: 10;
        }
        
        .timeline-content {
            padding-right: 0.5rem;
        }
        
        /* Product Card */
        .product-card {
            transition: all 0.3s ease-in-out;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .product-img {
            height: 150px;
            width: 100%;
            object-fit: cover;
            border-top-right-radius: 0.5rem;
            border-top-left-radius: 0.5rem;
        }
        
        /* Animation for alerts */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        /* Responsive tweaks */
        @media (max-width: 768px) {
            .stat-cards {
                grid-template-columns: 1fr;
            }
            
            .order-history, .product-list {
                grid-template-columns: 1fr;
            }
        }
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
                <div class="bg-custom px-4 py-6 border-b border-gray-200 bg-gradient-to-l from-text-white">
                   
                        <h1 class="text-xl  font-bold">لوحة تحكم السوبر ماركت</h1>
                    
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
                            
                            <!-- Orders Management -->
                            <li class="sidebar-item menu-open mt-2">
                                <a href="#" class="flex items-center justify-between px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-md">
                                    <div class="flex items-center">
                                        <i class="bi bi-cart3 ml-3 text-xl"></i>
                                        <span>ادارة الطلبات</span>
                                    </div>
                                    <i class="nav-arrow bi bi-chevron-left transition-transform"></i>
                                </a>
                                <ul class="sidebar-submenu pr-8 mt-1 space-y-1">
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>طلبات جديدة</span>
                                            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 mr-2">15</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>طلبات قيد التنفيذ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-circle ml-3 text-xs"></i>
                                            <span>عرض الطلبات</span>
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
