<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الإدارة العامة - نظام إدارة السوبر ماركت</title>
    <!-- Tailwind CSS v3 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3B82F6;
            --secondary-color: #10B981;
            --accent-color: #8B5CF6;
            --background-color: #F9FAFB;
            --sidebar-color: #fff;
        }
        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--background-color);
        }
        /* Modern Sidebar */
        .sidebar {
            background-color: var(--sidebar-color);
            background-image: none;
            border-left: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        .sidebar-item {
            color: #374151;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin-bottom: 0.25rem;
        }
        .sidebar-item.active {
            background-color: #f3f4f6;
            border-right: 3px solid var(--primary-color);
            color: var(--primary-color) !important;
        }
        .sidebar-item:hover:not(.active) {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }
        .sidebar-icon {
            color: #64748b;
            transition: transform 0.15s ease;
        }
        .sidebar-item.active .sidebar-icon,
        .sidebar-item:hover .sidebar-icon {
            color: var(--primary-color);
        }
        .sidebar-item span {
            color: inherit;
        }
        /* Modern Cards */
        .card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08), 0 6px 6px rgba(0, 0, 0, 0.12);
        }
        .card-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(249, 250, 251, 0.5);
        }
        .card-body {
            padding: 1.5rem;
        }
        /* Stat Cards */
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        /* Tables */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        thead {
            background-color: rgba(243, 244, 246, 0.7);
        }
        th {
            padding: 1rem;
            font-weight: 600;
            text-align: right;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #4B5563;
        }
        td {
            padding: 1rem;
            vertical-align: middle;
            color: #374151;
        }
        tbody tr {
            border-bottom: 1px solid rgba(243, 244, 246, 0.7);
            transition: background-color 0.2s ease;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        tbody tr:hover {
            background-color: rgba(243, 244, 246, 0.5);
        }
        /* Status Badges */
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        /* Media Queries */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .main-content {
                margin-right: 0 !important;
            }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a0a0a0;
        }
        /* Animated Items */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen flex flex-col">
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar fixed inset-y-0 right-0 z-20 w-64 transform transition-all duration-300 md:relative md:translate-x-0">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <h1 class="text-xl font-bold text-gray-700">نظام السوبر ماركت</h1>
                    <button id="closeSidebar" class="text-gray-400 hover:text-gray-700 md:hidden">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto px-4 py-5">
                    <div class="mb-6">
                        <div class="px-3 mb-3">
                            <h5 class="text-xs uppercase tracking-wider text-gray-400 font-semibold">لوحة التحكم</h5>
                        </div>
                        <nav>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('general_management.dashboard') }}" class="sidebar-item active flex items-center gap-3 text-gray-700 px-4 py-3">
                                        <i class="bi bi-speedometer2 sidebar-icon text-xl"></i>
                                        <span>لوحة القيادة</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('general_management.categories.index') }}" class="sidebar-item flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-3">
                                        <i class="bi bi-tags sidebar-icon text-xl"></i>
                                        <span>إدارة الفئات</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="mb-6">
                        <div class="px-3 mb-3">
                            <h5 class="text-xs uppercase tracking-wider text-gray-400 font-semibold">التقارير</h5>
                        </div>
                        <nav>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('general_management.reports.users') }}" class="sidebar-item flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-3">
                                        <i class="bi bi-people sidebar-icon text-xl"></i>
                                        <span>تقرير المستخدمين</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('general_management.reports.orders') }}" class="sidebar-item flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-3">
                                        <i class="bi bi-file-earmark-bar-graph sidebar-icon text-xl"></i>
                                        <span>تقرير الطلبات</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('general_management.reports.top_products') }}" class="sidebar-item flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-3">
                                        <i class="bi bi-trophy sidebar-icon text-xl"></i>
                                        <span>الأعلى مبيعًا</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('general_management.reports.top_rated_products') }}" class="sidebar-item flex items-center gap-3 text-gray-700 hover:text-blue-600 px-4 py-3">
                                        <i class="bi bi-star sidebar-icon text-xl"></i>
                                        <span>الأعلى تقييما</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-gray-200">
                    <a href="/logout" class="flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <i class="bi bi-box-arrow-right text-xl"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </div>
            </div>
        </aside>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="flex-1 flex flex-col main-content">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 focus:outline-none md:hidden">
                            <i class="bi bi-list text-2xl"></i>
                        </button>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">لوحة القيادة</h2>
                            <p class="text-sm text-gray-500">مرحباً بك، أهلاً بالإدارة</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="relative">
                            <button class="flex items-center text-gray-600 hover:text-gray-900">
                                <span class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="bi bi-person"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 overflow-y-auto">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="container mx-auto px-6 text-center text-gray-500 text-sm">
                    <p>&copy; 2023 - 2025 | نظام إدارة السوبر ماركت | جميع الحقوق محفوظة</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Toggle Sidebar on Mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebar = document.getElementById('closeSidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });

        // Initialize Active Menu Item
        function setActiveMenuItem() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-item');

            menuItems.forEach(item => {
                const link = item.getAttribute('href');
                if (link && currentPath.includes(link)) {
                    menuItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                }
            });
        }

        // Call on load
        document.addEventListener('DOMContentLoaded', setActiveMenuItem);
    </script>
</body>
</html>
