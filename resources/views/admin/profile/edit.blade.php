<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم إدارة السوبر ماركت - الإعدادات العامة</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap');
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f7f9fc;
        }
        
        .sidebar {
            background-color: #1e293b;
            color: #fff;
            height: 100vh;
            position: fixed;
            right: 0;
            width: 280px;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-brand {
            padding: 20px;
            background-color: #0f172a;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            margin: 5px 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 5px;
            margin: 0 10px;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: #334155;
            color: #fff;
        }
        
        .sidebar-menu .submenu {
            padding-right: 15px;
            list-style: none;
            display: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu .menu-open .submenu {
            display: block;
        }
        
        .main-content {
            margin-right: 280px;
            padding: 30px;
            transition: all 0.3s;
        }
        
        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .card-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .form-control {
            display: block;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #1e293b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .btn {
            display: inline-block;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #3b82f6;
            border: 1px solid #3b82f6;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .avatar-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin-bottom: 1rem;
        }
        
        .avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }
        
        .avatar-upload {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: #3b82f6;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .avatar-upload:hover {
            background-color: #2563eb;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                overflow: hidden;
            }
            
            .sidebar .sidebar-brand h2 span,
            .sidebar .sidebar-menu a span,
            .sidebar .sidebar-menu a .nav-arrow {
                display: none;
            }
            
            .main-content {
                margin-right: 80px;
            }
            
            .sidebar-menu a {
                padding: 12px;
                margin: 0 5px;
                text-align: center;
            }
            
            .sidebar-menu .nav-icon {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-right: 0;
                padding: 20px;
            }
            
            .sidebar {
                right: -280px;
            }
            
            .sidebar.active {
                right: 0;
            }
            
            .toggle-menu {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h2 class="text-xl font-bold"><i class="bi bi-shop-window ml-2"></i> <span>سوبر ماركت</span></h2>
            </div>
            
            <nav class="mt-5">
                <ul class="sidebar-menu">
                    <li class="menu-open">
                        <a href="#" class="flex justify-between items-center">
                            <div>
                                <i class="nav-icon bi bi-speedometer2 ml-2"></i>
                                <span>معلومات النظام</span>
                            </div>
                            <i class="nav-arrow bi bi-chevron-left"></i>
                        </a>
                        <ul class="submenu mt-2">
                            <li>
                                <a href="#" class="active">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>الإعدادات العامة</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>الإحصائيات</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-open mt-2">
                        <a href="#" class="flex justify-between items-center">
                            <div>
                                <i class="nav-icon bi bi-box ml-2"></i>
                                <span>إدارة المنتجات</span>
                            </div>
                            <i class="nav-arrow bi bi-chevron-left"></i>
                        </a>
                        <ul class="submenu mt-2">
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>إضافة منتج</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>عرض المنتجات</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-open mt-2">
                        <a href="#" class="flex justify-between items-center">
                            <div>
                                <i class="nav-icon bi bi-tag ml-2"></i>
                                <span>إدارة العروض</span>
                            </div>
                            <i class="nav-arrow bi bi-chevron-left"></i>
                        </a>
                        <ul class="submenu mt-2">
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>إضافة عرض</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>إضافة عرض بواسطة صورة</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>عرض العروض</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-open mt-2">
                        <a href="#" class="flex justify-between items-center">
                            <div>
                                <i class="nav-icon bi bi-cart ml-2"></i>
                                <span>إدارة الطلبات</span>
                            </div>
                            <i class="nav-arrow bi bi-chevron-left"></i>
                        </a>
                        <ul class="submenu mt-2">
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>طلبات جديدة</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="nav-icon bi bi-circle ml-2"></i>
                                    <span>عرض الطلبات</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="py-4 px-2">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">لوحة التحكم</h1>
                
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill ml-2"></i> تم تحديث البيانات بنجاح
                </div>
                
                <div class="card">
                    <div class="card-header flex items-center">
                        <i class="bi bi-gear ml-2"></i>
                        الإعدادات العامة - بيانات السوبر ماركت
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <!-- القسم الأول: المعلومات الأساسية -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1">
                                    <div class="mb-4">
                                        <label for="supermarket_name" class="block text-gray-700 mb-2">اسم السوبر ماركت</label>
                                        <input type="text" name="supermarket_name" id="supermarket_name" class="form-control" value="سوبر ماركت الرياض" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="location" class="block text-gray-700 mb-2">الموقع</label>
                                        <input type="text" name="location" id="location" class="form-control" value="شارع العليا، الرياض، المملكة العربية السعودية" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="contact_number" class="block text-gray-700 mb-2">رقم التواصل</label>
                                        <input type="text" name="contact_number" id="contact_number" class="form-control" value="966555555555+" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                                        <input type="email" name="email" id="email" class="form-control" value="info@supermarket.com" required>
                                    </div>
                                </div>
                                
                                <div class="col-span-2 md:col-span-1 flex flex-col items-center justify-center">
                                    <div class="avatar-container">
                                        <img src="https://via.placeholder.com/150x150" alt="صورة السوبر ماركت" class="avatar">
                                        <label for="profile_image" class="avatar-upload">
                                            <i class="bi bi-pencil"></i>
                                        </label>
                                    </div>
                                    <input type="file" name="profile_image" id="profile_image" class="hidden">
                                    <p class="text-sm text-gray-500 mt-2">اضغط لتغيير الصورة الشخصية</p>
                                </div>
                            </div>
                            
                            <!-- القسم الثاني: معلومات إضافية -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold mb-4 border-b pb-2">معلومات إضافية</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="working_hours" class="block text-gray-700 mb-2">ساعات العمل</label>
                                        <input type="text" name="working_hours" id="working_hours" class="form-control" value="من 8 صباحًا إلى 12 مساءً" required>
                                    </div>
                                    
                                    <div>
                                        <label for="tax_number" class="block text-gray-700 mb-2">الرقم الضريبي</label>
                                        <input type="text" name="tax_number" id="tax_number" class="form-control" value="300000000000003" required>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label for="description" class="block text-gray-700 mb-2">وصف السوبر ماركت</label>
                                    <textarea name="description" id="description" rows="4" class="form-control">سوبر ماركت الرياض هو متجر متكامل يقدم مجموعة واسعة من المنتجات الغذائية والاستهلاكية بأسعار تنافسية وجودة عالية.</textarea>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="btn btn-primary">تحديث البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle submenu
        document.querySelectorAll('.sidebar-menu > li > a').forEach(item => {
            item.addEventListener('click', event => {
                event.preventDefault();
                const parent = item.parentElement;
                parent.classList.toggle('menu-open');
            });
        });
        
        // File upload preview
        const profileImage = document.getElementById('profile_image');
        const avatarImage = document.querySelector('.avatar');
        
        profileImage.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>