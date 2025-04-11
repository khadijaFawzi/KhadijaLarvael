<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة السوبر ماركت | الصفحة الرئيسية</title>
    <!-- استيراد Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- استيراد Font Awesome للأيقونات -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" rel="stylesheet">
    <!-- استيراد الخط العربي -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/tajawal@4.5.9/index.min.css">
    
    <style>
        /* 
        في Laravel، يمكن وضع هذا القسم في ملف CSS منفصل في 
        public/css/styles.css
        ثم استيراده في Blade templates باستخدام:
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        */
        
        /* تعريف الخطوط والألوان الأساسية */
        :root {
            --primary-color: #b38867; /* تغيير من اللون الأخضر إلى البني الفاتح */
            --secondary-color: #e6c19a; /* تغيير اللون الثانوي */
            --dark-color: #5d4037; /* بني داكن للنصوص */
            --light-color: #f0e9e2; /* لون فاتح للخلفيات */
            --success-color: #8d6e63; /* بني أخف للنجاح */
            --danger-color: #c62828;
            --color:white /* أحمر غامق للتنبيهات */
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            scroll-behavior: smooth;
            background-color: var(--light-color);
        }
        
        /* تخصيص الأقسام */
        .page-section {
            min-height: 100vh;
            padding: 5rem 1rem;
        }
        
        /* تنسيق للرسوم المتحركة */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        /* تنسيق للبطاقات */
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(133, 100, 69, 0.1);
        }
        
        /* تنسيق لشريط التنقل العلوي */
        .nav-link {
            position: relative;
            margin: 0 1rem;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: 100%;
        }
        
        /* تنسيق لأزرار الدعوة للعمل */
        .cta-button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .cta-button:hover {
            background-color: #9c7356; /* بني أغمق قليلاً للتأثير */
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(133, 100, 69, 0.2);
        }
        
        /* تنسيق جدول الأسعار */
        .pricing-table {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
        }
        
        .pricing-table:hover {
            transform: scale(1.03);
            box-shadow: 0 20px 40px rgba(133, 100, 69, 0.15);
        }
        
        .popular-plan {
            border: 2px solid var(--secondary-color);
            position: relative;
        }
        
        .popular-badge {
            position: absolute;
            top: 0;
            right: 2rem;
            background-color: var(--secondary-color);
            color: var(--dark-color);
            padding: 0.5rem 1.5rem;
            border-radius: 0 0 10px 10px;
            font-weight: bold;
        }
        
        /* تصميم نموذج تسجيل الدخول وإنشاء الحساب */
        .auth-form {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(133, 100, 69, 0.1);
        }
        
        .form-input {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2d8d0;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }
        
        /* دعم الانتقال بين الصفحات دون إعادة تحميل */
        .page-content {
            display: none;
        }
        
        .page-content.active {
            display: block;
        }

        /* ألوان Tailwind CSS المخصصة للبني */
        .bg-brown-50 { background-color: #f8f5f2; }
        .bg-brown-100 { background-color: #f0e9e2; }
        .bg-brown-200 { background-color: #e6d9cc; }
        .bg-brown-300 { background-color: #d7c3b0; }
        .bg-brown-400 { background-color: #c5aa93; }
        .bg-brown-500 { background-color: #b38867; }
        .bg-brown-600 { background-color: #9c7356; }
        .bg-brown-700 { background-color: #7d5a44; }
        .bg-brown-800 { background-color: #5d4037; }
        .bg-brown-900 { background-color: #3e2723; }

        .text-brown-50 { color: #f8f5f2; }
        .text-brown-100 { color: #f0e9e2; }
        .text-brown-200 { color: #e6d9cc; }
        .text-brown-300 { color: #d7c3b0; }
        .text-brown-400 { color: #c5aa93; }
        .text-brown-500 { color: #b38867; }
        .text-brown-600 { color: #9c7356; }
        .text-brown-700 { color: #7d5a44; }
        .text-brown-800 { color: #5d4037; }
        .text-brown-900 { color: #3e2723; }

        .border-brown-500 { border-color: #b38867; }
        .border-brown-600 { border-color: #9c7356; }
        
        .hover\:bg-brown-50:hover { background-color: #f8f5f2; }
        .hover\:bg-brown-100:hover { background-color: #f0e9e2; }
        .hover\:bg-brown-600:hover { background-color: #9c7356; }
        .hover\:bg-brown-700:hover { background-color: #7d5a44; }
        
        .hover\:text-brown-600:hover { color: #9c7356; }
        .hover\:text-brown-700:hover { color: #7d5a44; }
        
        .hover\:border-brown-500:hover { border-color: #b38867; }
    </style>
</head>
<body class="bg-brown-50">
    <!-- شريط التنقل -->
    <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- الشعار -->
                <a href="#home" class="text-2xl font-bold text-primary-600" onclick="changePage('home')">
                    <span class="text-brown-700">سوبر</span><span class="text-brown-500">ماركت</span>
                </a>
                
                <!-- روابط التنقل - للشاشات المتوسطة والكبيرة -->
                <div class="hidden md:flex items-center">
                    <a href="#home" class="nav-link" onclick="changePage('home')">الرئيسية</a>
                    <a href="#features" class="nav-link" onclick="changePage('features')">المميزات</a>
                    <a href="#how-it-works" class="nav-link" onclick="changePage('how-it-works')">كيف تعمل</a>
                    <a href="#pricing" class="nav-link" onclick="changePage('pricing')">الأسعار</a>
                    <a href="#testimonials" class="nav-link" onclick="changePage('testimonials')">آراء العملاء</a>
                    <a href="#about" class="nav-link" onclick="changePage('about')">من نحن</a>
                </div>
                
                <!-- أزرار تسجيل الدخول والتسجيل -->
                <div class="hidden md:flex items-center">
                    <a href="#login" class="nav-link mr-4" onclick="changePage('login')">تسجيل الدخول</a>
                    <a href="#register" class="cta-button" onclick="changePage('register')">إنشاء حساب</a>
                </div>
                
                <!-- زر القائمة للجوال -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-brown-700">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- قائمة الجوال -->
            <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2">
                <a href="#home" class="block py-2 text-center" onclick="changePage('home')">الرئيسية</a>
                <a href="#features" class="block py-2 text-center" onclick="changePage('features')">المميزات</a>
                <a href="#how-it-works" class="block py-2 text-center" onclick="changePage('how-it-works')">كيف تعمل</a>
                <a href="#pricing" class="block py-2 text-center" onclick="changePage('pricing')">الأسعار</a>
                <a href="#testimonials" class="block py-2 text-center" onclick="changePage('testimonials')">آراء العملاء</a>
                <a href="#about" class="block py-2 text-center" onclick="changePage('about')">من نحن</a>
                <a href="#login" class="block py-2 text-center" onclick="changePage('login')">تسجيل الدخول</a>
                <a href="#register" class="block py-2 bg-brown-600 text-white rounded-lg mx-4 text-center" onclick="changePage('register')">إنشاء حساب</a>
            </div>
        </div>
    </nav>
    
    <!-- محتوى الصفحات -->
    <div class="main-container pt-20">
        <!-- الصفحة الرئيسية -->
        <section id="home" class="page-content active">
            <div class="page-section bg-brown-50">
                <div class="container mx-auto px-4">
                    <!-- قسم العرض الرئيسي -->
                    <div class="flex flex-col-reverse md:flex-row items-center">
                        <div class="md:w-1/2 text-center md:text-right">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                                انضم لأكبر منصة تسويق <span class="text-brown-600">للسوبر ماركت</span>
                            </h1>
                            <p class="text-xl mb-8 text-gray-600">
                                نساعد أصحاب السوبر ماركت على عرض منتجاتهم وزيادة مبيعاتهم عبر منصة رقمية متكاملة تصل لآلاف العملاء
                            </p>
                            <div class="flex flex-col sm:flex-row justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-4 sm:space-x-reverse">
                                <a href="#register" class="cta-button" onclick="changePage('register')">
                                    ابدأ الآن مجاناً
                                </a>
                                <a href="#how-it-works" class="border border-brown-600 text-brown-600 hover:bg-brown-50 px-6 py-3 rounded-full font-bold transition duration-300" onclick="changePage('how-it-works')">
                                    شاهد كيف تعمل
                                </a>
                            </div>
                        </div>
                        <div class="md:w-1/2 mb-8 md:mb-0">
                            <div class="bg-white p-4 rounded-lg shadow-lg animate-float">
                                <img src="{{ asset('admin/assets/shopping2.jpg') }}" alt="منصة السوبر ماركت" class="max-w-full h-auto">
                            </div>
                        </div>
                    </div>
                    
                    <!-- إحصائيات -->
                    <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-brown-600 text-4xl font-bold mb-2">+1000</div>
                            <div class="text-gray-700 text-lg">سوبر ماركت مسجل</div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-brown-600 text-4xl font-bold mb-2">+50,000</div>
                            <div class="text-gray-700 text-lg">منتج معروض</div>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-brown-600 text-4xl font-bold mb-2">+100,000</div>
                            <div class="text-gray-700 text-lg">عميل نشط</div>
                        </div>
                    </div>
                    
                    <!-- المميزات المصغرة -->
                    <div class="mt-20">
                        <h2 class="text-2xl font-bold text-center mb-10">المميزات الرئيسية</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="feature-card bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="bg-brown-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center text-brown-600 mb-4">
                                    <i class="fas fa-store text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-lg mb-2">إدارة المنتجات</h3>
                                <p class="text-gray-600">إضافة وإدارة منتجاتك بسهولة مع التحكم الكامل في الأسعار والمخزون</p>
                            </div>
                            <div class="feature-card bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="bg-brown-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center text-brown-600 mb-4">
                                    <i class="fas fa-chart-line text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-lg mb-2">تقارير المبيعات</h3>
                                <p class="text-gray-600">تحليلات ورسوم بيانية متكاملة لمتابعة أداء مبيعاتك بشكل لحظي</p>
                            </div>
                            <div class="feature-card bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="bg-brown-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center text-brown-600 mb-4">
                                    <i class="fas fa-tags text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-lg mb-2">إدارة العروض</h3>
                                <p class="text-gray-600">إنشاء وجدولة العروض والخصومات الخاصة بمتجرك بسهولة</p>
                            </div>
                            <div class="feature-card bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="bg-brown-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center text-brown-600 mb-4">
                                    <i class="fas fa-mobile-alt text-2xl"></i>
                                </div>
                                <h3 class="font-bold text-lg mb-2">تطبيق جوال</h3>
                                <p class="text-gray-600">تطبيق جوال خاص يسمح لعملائك بالطلب والدفع بسهولة</p>
                            </div>
                        </div>
                        <div class="text-center mt-10">
                            <a href="#features" class="inline-block text-brown-600 hover:text-brown-700 font-bold" onclick="changePage('features')">
                                اكتشف المزيد من المميزات <i class="fas fa-arrow-left ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- صفحة المميزات -->
        <section id="features" class="page-content">
            <div class="page-section bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">مميزات المنصة</h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            تقدم منصتنا مجموعة واسعة من المميزات المصممة خصيصًا لدعم أصحاب السوبر ماركت وزيادة مبيعاتهم وتحسين تجربة عملائهم
                        </p>
                    </div>
                    
                    <!-- المميزات المتقدمة -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-store text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">إدارة المتجر الإلكتروني</h3>
                            </div>
                            <p class="text-gray-600 mb-4">لوحة تحكم متكاملة لإدارة المتجر وإضافة المنتجات وتنظيمها في فئات وتحديث الأسعار والمخزون بشكل مباشر.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>إضافة صور متعددة وأوصاف مفصلة للمنتجات</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تنظيم المنتجات في أقسام وفئات</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تتبع المخزون وإشعارات انخفاض الكمية</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-tags text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">إدارة العروض والخصومات</h3>
                            </div>
                            <p class="text-gray-600 mb-4">نظام متكامل لإنشاء وإدارة العروض الخاصة والخصومات الموسمية لجذب العملاء وزيادة المبيعات.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>إنشاء عروض بأنواع مختلفة (خصم نسبة، خصم مبلغ، اشتر واحد واحصل على واحد)</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>جدولة العروض لفترات زمنية محددة</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>إنشاء كوبونات خصم للعملاء</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-chart-line text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">التقارير والتحليلات</h3>
                            </div>
                            <p class="text-gray-600 mb-4">تقارير ورسوم بيانية شاملة تساعدك على فهم سلوك العملاء وتحسين استراتيجية المبيعات.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تحليل المبيعات حسب الفترة والمنتج والفئة</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تقارير المنتجات الأكثر مبيعًا</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تتبع سلوك العملاء والطلبات</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-mobile-alt text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">تطبيق الجوال</h3>
                            </div>
                            <p class="text-gray-600 mb-4">تطبيق خاص بمتجرك لنظامي iOS و Android يتيح لعملائك تصفح والطلب بكل سهولة.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تصميم مخصص بشعار وألوان متجرك</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>إشعارات فورية للعروض والخصومات</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>نظام ولاء ونقاط للعملاء</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-truck text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">إدارة التوصيل والشحن</h3>
                            </div>
                            <p class="text-gray-600 mb-4">نظام متكامل لإدارة طلبات التوصيل ومتابعة حالة الشحن وإشعار العملاء.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>تحديد مناطق التوصيل وأسعار مختلفة</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>متابعة حالة الطلبات في الوقت الفعلي</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>التكامل مع شركات التوصيل الخارجية</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="feature-card bg-white border border-gray-200 p-6 rounded-lg hover:border-brown-500">
                            <div class="flex items-center mb-4">
                                <div class="bg-brown-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-credit-card text-brown-600 text-xl"></i>
                                </div>
                                <h3 class="font-bold text-xl">طرق الدفع المتعددة</h3>
                            </div>
                            <p class="text-gray-600 mb-4">دعم لمختلف طرق الدفع لتوفير تجربة سلسة للعملاء وزيادة نسبة إتمام عمليات الشراء.</p>
                            <ul class="text-gray-600">
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>بطاقات الائتمان ومدى</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>المحافظ الإلكترونية (Apple Pay, STC Pay)</span>
                                </li>
                                <li class="mb-2 flex items-start">
                                    <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                    <span>الدفع عند الاستلام</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- صفحة كيف تعمل -->
        <section id="how-it-works" class="page-content">
            <div class="page-section bg-brown-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">كيف تعمل المنصة</h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            خطوات بسيطة تفصلك عن إطلاق متجرك الإلكتروني والبدء في استقبال الطلبات من العملاء
                        </p>
                    </div>
                    
                    <!-- الخطوات -->
                    <div class="max-w-4xl mx-auto">
                        <div class="relative">
                            <!-- خط زمني -->
                            <div class="absolute h-full w-1 bg-brown-200 left-1/2 transform -translate-x-1/2"></div>
                            
                            <!-- الخطوة 1 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h3 class="text-2xl font-bold mb-3 text-brown-600">01. التسجيل وإنشاء الحساب</h3>
                                            <p class="text-gray-600">
                                                أنشئ حسابك الخاص في دقائق معدودة. قم بإدخال بيانات متجرك الأساسية واختر خطة الاشتراك المناسبة لاحتياجاتك.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">1</div>
                                </div>
                            </div>
                            
                            <!-- الخطوة 2 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row-reverse">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-right text-center pl-0 md:pl-8 md:mr-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h3 class="text-2xl font-bold mb-3 text-brown-600">02. إعداد المتجر وإضافة المنتجات</h3>
                                            <p class="text-gray-600">
                                                قم بتخصيص متجرك باستخدام لوحة التحكم السهلة. أضف شعارك، وصف متجرك، وقم بإنشاء الفئات وإضافة المنتجات مع صورها وأسعارها.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">2</div>
                                </div>
                            </div>
                            
                            <!-- الخطوة 3 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h3 class="text-2xl font-bold mb-3 text-brown-600">03. تفعيل طرق الدفع والتوصيل</h3>
                                            <p class="text-gray-600">
                                                حدد طرق الدفع التي تناسب عملائك، وقم بتعيين مناطق التوصيل وأسعارها، بالإضافة إلى خيارات الاستلام من المتجر.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">3</div>
                                </div>
                            </div>
                            
                            <!-- الخطوة 4 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row-reverse">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-right text-center pl-0 md:pl-8 md:mr-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h3 class="text-2xl font-bold mb-3 text-brown-600">04. إطلاق المتجر والترويج له</h3>
                                            <p class="text-gray-600">
                                                بعد إكمال الإعدادات، أطلق متجرك واستفد من أدوات التسويق التي نوفرها للترويج لمتجرك على وسائل التواصل الاجتماعي وجذب العملاء.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">4</div>
                                </div>
                            </div>
                            
                            <!-- الخطوة 5 -->
                            <div class="relative z-10">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h3 class="text-2xl font-bold mb-3 text-brown-600">05. إدارة الطلبات ونمو المبيعات</h3>
                                            <p class="text-gray-600">
                                                استقبل الطلبات وقم بإدارتها بكفاءة، وتابع المبيعات من خلال التقارير المفصلة، واستمر في تطوير متجرك وزيادة مبيعاتك.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">5</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- الدعوة للعمل -->
                    <div class="text-center mt-16">
                        <a href="#register" class="cta-button inline-block" onclick="changePage('register')">
                            ابدأ رحلتك الآن
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- صفحة الأسعار -->
        <section id="pricing" class="page-content">
            <div class="page-section bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">خطط الأسعار</h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            اختر الخطة المناسبة لحجم متجرك واحتياجاتك، مع إمكانية الترقية في أي وقت
                        </p>
                        <div class="mt-8 inline-flex p-1 bg-gray-100 rounded-full">
                            <button id="monthly-btn" class="py-2 px-6 rounded-full bg-brown-600 text-white font-bold focus:outline-none">شهري</button>
                            <button id="yearly-btn" class="py-2 px-6 rounded-full font-bold focus:outline-none">سنوي (خصم 20%)</button>
                        </div>
                    </div>
                    
                    <!-- جداول الأسعار -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        <!-- الخطة الأساسية -->
                        <div class="pricing-table bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-brown-50 p-6 text-center">
                                <h3 class="text-2xl font-bold">الأساسية</h3>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold">٢٩٩</span>
                                    <span class="text-gray-600 font-medium"> ر.س/شهرياً</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">تدفع مقدماً</div>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>إضافة حتى 100 منتج</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>الموقع الإلكتروني الأساسي</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>تقارير أساسية</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>2% عمولة على المبيعات</span>
                                    </li>
                                    <li class="flex items-start text-gray-400">
                                        <i class="fas fa-times text-red-500 mt-1 ml-2"></i>
                                        <span>تطبيق جوال</span>
                                    </li>
                                    <li class="flex items-start text-gray-400">
                                        <i class="fas fa-times text-red-500 mt-1 ml-2"></i>
                                        <span>دعم فني على مدار الساعة</span>
                                    </li>
                                </ul>
                                <div class="mt-8">
                                    <a href="#register" class="block text-center py-3 px-6 border-2 border-brown-600 text-brown-600 font-bold rounded-lg hover:bg-brown-50 transition duration-300" onclick="changePage('register')">
                                        ابدأ الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- الخطة الاحترافية -->
                        <div class="pricing-table bg-white rounded-lg shadow-lg overflow-hidden popular-plan">
                            <div class="popular-badge">الأكثر شعبية</div>
                            <div class="bg-brown-50 p-6 text-center">
                                <h3 class="text-2xl font-bold">الاحترافية</h3>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold">٥٩٩</span>
                                    <span class="text-gray-600 font-medium"> ر.س/شهرياً</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">تدفع مقدماً</div>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>إضافة حتى 500 منتج</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>موقع إلكتروني متقدم</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>تقارير متقدمة وتحليلات</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>1% عمولة على المبيعات</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>تطبيق جوال أساسي</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>دعم فني خلال ساعات العمل</span>
                                    </li>
                                </ul>
                                <div class="mt-8">
                                    <a href="#register" class="block text-center py-3 px-6 bg-brown-600 text-white font-bold rounded-lg hover:bg-brown-700 transition duration-300" onclick="changePage('register')">
                                        ابدأ الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- الخطة المتقدمة -->
                        <div class="pricing-table bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-brown-50 p-6 text-center">
                                <h3 class="text-2xl font-bold">المتقدمة</h3>
                                <div class="mt-4">
                                    <span class="text-4xl font-bold">٩٩٩</span>
                                    <span class="text-gray-600 font-medium"> ر.س/شهرياً</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">تدفع مقدماً</div>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>منتجات غير محدودة</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>موقع إلكتروني مخصص بالكامل</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>تقارير متقدمة وتحليلات ذكية</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>0.5% عمولة على المبيعات</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>تطبيق جوال مخصص</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-brown-500 mt-1 ml-2"></i>
                                        <span>دعم فني على مدار الساعة</span>
                                    </li>
                                </ul>
                                <div class="mt-8">
                                    <a href="#register" class="block text-center py-3 px-6 border-2 border-brown-600 text-brown-600 font-bold rounded-lg hover:bg-brown-50 transition duration-300" onclick="changePage('register')">
                                        ابدأ الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ميزات إضافية -->
                    <div class="mt-20">
                        <h3 class="text-2xl font-bold text-center mb-10">مميزات إضافية لجميع الخطط</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div class="bg-white rounded-lg p-6 shadow-md">
                                <div class="text-brown-600 text-2xl mb-3"><i class="fas fa-lock"></i></div>
                                <h4 class="font-bold text-lg mb-2">أمان وحماية</h4>
                                <p class="text-gray-600">حماية SSL مجانية وحماية ضد هجمات DDoS لجميع المتاجر</p>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow-md">
                                <div class="text-brown-600 text-2xl mb-3"><i class="fas fa-headset"></i></div>
                                <h4 class="font-bold text-lg mb-2">دعم فني</h4>
                                <p class="text-gray-600">فريق دعم متخصص لمساعدتك في حل أي مشكلة تواجهك</p>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow-md">
                                <div class="text-brown-600 text-2xl mb-3"><i class="fas fa-code"></i></div>
                                <h4 class="font-bold text-lg mb-2">تحديثات دورية</h4>
                                <p class="text-gray-600">تحديثات مستمرة للنظام وإضافة ميزات جديدة بشكل دوري</p>
                            </div>
                            <div class="bg-white rounded-lg p-6 shadow-md">
                                <div class="text-brown-600 text-2xl mb-3"><i class="fas fa-graduation-cap"></i></div>
                                <h4 class="font-bold text-lg mb-2">تدريب وتوجيه</h4>
                                <p class="text-gray-600">مواد تعليمية وأدلة إرشادية للمساعدة في تشغيل متجرك</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- الأسئلة الشائعة -->
                    <div class="mt-20">
                        <h3 class="text-2xl font-bold text-center mb-10">الأسئلة الشائعة عن الأسعار</h3>
                        <div class="max-w-3xl mx-auto divide-y">
                            <div class="py-4">
                                <h4 class="font-bold text-lg mb-2">هل يمكنني تغيير خطتي في أي وقت؟</h4>
                                <p class="text-gray-600">نعم، يمكنك الترقية إلى خطة أعلى في أي وقت. في حالة الترقية، سيتم احتساب الفرق بين الخطتين للفترة المتبقية من اشتراكك.</p>
                            </div>
                            <div class="py-4">
                                <h4 class="font-bold text-lg mb-2">هل هناك فترة تجريبية مجانية؟</h4>
                                <p class="text-gray-600">نعم، نقدم فترة تجريبية مجانية لمدة 14 يومًا لجميع الخطط بدون الحاجة إلى بطاقة ائتمان.</p>
                            </div>
                            <div class="py-4">
                                <h4 class="font-bold text-lg mb-2">كيف يتم حساب العمولة على المبيعات؟</h4>
                                <p class="text-gray-600">يتم حساب العمولة على إجمالي قيمة الطلب بدون تكلفة التوصيل. يتم خصمها تلقائيًا وتحويل المبلغ المتبقي إلى حسابك البنكي.</p>
                            </div>
                            <div class="py-4">
                                <h4 class="font-bold text-lg mb-2">هل هناك تكاليف إضافية أخرى؟</h4>
                                <p class="text-gray-600">لا توجد تكاليف خفية. الأسعار المعلنة تشمل جميع الميزات المذكورة في كل خطة، بالإضافة إلى نسبة العمولة على المبيعات.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- صفحة آراء العملاء -->
        <section id="testimonials" class="page-content">
            <div class="page-section bg-brown-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">آراء أصحاب السوبر ماركت</h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            استمع إلى تجارب حقيقية من أصحاب السوبر ماركت الذين نجحوا في تنمية أعمالهم من خلال منصتنا
                        </p>
                    </div>
                    
                    <!-- شرائح آراء العملاء -->
                    <div class="testimonial-slider">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- رأي 1 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="text-gray-600">5.0</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "منذ انضمامنا للمنصة، شهدنا زيادة بنسبة 40% في المبيعات الشهرية. النظام سهل الاستخدام والدعم الفني ممتاز. أفضل استثمار قمنا به لمتجرنا."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">م</div>
                                    <div>
                                        <h4 class="font-bold">محمد السعيد</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت الأمانة - الرياض</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- رأي 2 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="text-gray-600">4.5</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "تطبيق الجوال أحدث فرقًا كبيرًا في تجربة عملائنا. الآن يمكنهم الطلب بسهولة ومتابعة العروض الخاصة. التقارير التحليلية ساعدتنا في فهم سلوك المستهلك بشكل أفضل."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">ف</div>
                                    <div>
                                        <h4 class="font-bold">فاطمة العلي</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت الوادي - جدة</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- رأي 3 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="text-gray-600">5.0</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "كنت قلقًا من تعقيد التحول الرقمي، لكن فريق الدعم كان رائعًا في مساعدتنا خلال العملية. الآن أصبح لدينا قاعدة عملاء أكبر ومبيعات أفضل."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">خ</div>
                                    <div>
                                        <h4 class="font-bold">خالد الشمري</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت الشمال - الدمام</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- المزيد من آراء العملاء -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8 hidden" id="more-testimonials">
                            <!-- رأي 4 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <div class="text-gray-600">4.0</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "نظام إدارة المخزون ساعدنا في تقليل الهدر بشكل كبير. التنبيهات التلقائية عند انخفاض المخزون تجعل إدارة المنتجات أكثر كفاءة."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">ع</div>
                                    <div>
                                        <h4 class="font-bold">عبد الله القحطاني</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت الراية - أبها</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- رأي 5 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="text-gray-600">5.0</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "حل متكامل وممتاز. الميزة التي أحببتها أكثر هي إمكانية إنشاء العروض الخاصة وتحديد مواعيدها. أصبح العملاء ينتظرون عروضنا الأسبوعية."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">ن</div>
                                    <div>
                                        <h4 class="font-bold">نورة الدوسري</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت النخيل - المدينة المنورة</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- رأي 6 -->
                            <div class="bg-white rounded-lg shadow-md p-6 testimonial-card">
                                <div class="flex items-center mb-4">
                                    <div class="text-yellow-400 mr-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="text-gray-600">4.5</div>
                                </div>
                                <p class="text-gray-600 mb-6 italic">
                                    "بعد استخدام المنصة لأكثر من سنة، أستطيع القول إنها نقلت متجرنا إلى مستوى جديد. خاصية التوصيل وتتبع الطلبات تعمل بشكل رائع."
                                </p>
                                <div class="flex items-center">
                                    <div class="bg-brown-100 w-12 h-12 rounded-full flex items-center justify-center font-bold text-brown-600 text-xl mr-4">س</div>
                                    <div>
                                        <h4 class="font-bold">سعد المالكي</h4>
                                        <p class="text-gray-600 text-sm">سوبر ماركت المستقبل - مكة المكرمة</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- زر عرض المزيد -->
                    <div class="text-center mt-10">
                        <button id="show-more-testimonials" class="py-2 px-6 border-2 border-brown-600 text-brown-600 rounded-lg hover:bg-brown-50 transition duration-300 font-bold">
                            عرض المزيد من الآراء
                        </button>
                    </div>
                    
                    <!-- إحصائيات الرضا -->
                    <div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-3xl font-bold text-brown-600 mb-2">96%</div>
                            <p class="text-gray-600">نسبة رضا العملاء</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-3xl font-bold text-brown-600 mb-2">4.8/5</div>
                            <p class="text-gray-600">متوسط التقييم</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-3xl font-bold text-brown-600 mb-2">+35%</div>
                            <p class="text-gray-600">زيادة المبيعات للعملاء</p>
                        </div>
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="text-3xl font-bold text-brown-600 mb-2">92%</div>
                            <p class="text-gray-600">نسبة التجديد</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- صفحة من نحن -->
        <section id="about" class="page-content">
            <div class="page-section bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-bold mb-4">من نحن</h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            تعرف على قصتنا ورؤيتنا وفريقنا الذي يعمل بجد لمساعدة أصحاب السوبر ماركت على النجاح في العالم الرقمي
                        </p>
                    </div>
                    
                    <!-- قصتنا -->
                    <div class="flex flex-col md:flex-row items-center mb-20">
                        <div class="md:w-1/2 mb-10 md:mb-0">
                            <img src="https://cdn.jsdelivr.net/gh/Genspark-inc/static-images@main/placeholder/team_meeting.svg" alt="قصتنا" class="max-w-full h-auto rounded-lg shadow-lg">
                        </div>
                        <div class="md:w-1/2 md:pr-12">
                            <h3 class="text-2xl font-bold mb-4">قصتنا</h3>
                            <p class="text-gray-600 mb-4">
                                بدأت قصتنا في عام 2018 عندما لاحظنا الصعوبات التي يواجهها أصحاب السوبر ماركت في التحول الرقمي. كان هدفنا بسيطًا: تطوير منصة سهلة الاستخدام تساعد المتاجر الصغيرة والمتوسطة على المنافسة رقميًا مع المتاجر الكبيرة.
                            </p>
                            <p class="text-gray-600 mb-4">
                                بعد أشهر من البحث والتطوير والاختبار مع عدد من المتاجر، أطلقنا النسخة الأولى من منصتنا. ومنذ ذلك الحين، نمت المنصة لتضم آلاف المتاجر وتوفر حلولًا متكاملة تلبي احتياجات قطاع التجزئة.
                            </p>
                            <p class="text-gray-600">
                                نحن فخورون بالتأثير الإيجابي الذي أحدثناه في قطاع تجارة التجزئة، ونستمر في التطوير والابتكار لمواكبة احتياجات السوق المتغيرة.
                            </p>
                        </div>
                    </div>
                    
                    <!-- رؤيتنا ومهمتنا -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
                        <div class="bg-brown-50 p-8 rounded-lg shadow-md">
                            <h3 class="text-2xl font-bold mb-4">رؤيتنا</h3>
                            <p class="text-gray-600">
                                نسعى لأن نكون المنصة الرقمية الرائدة التي تمكّن كل سوبر ماركت في المنطقة العربية من التحول الرقمي وتحقيق النمو المستدام في عصر الاقتصاد الرقمي.
                            </p>
                        </div>
                        <div class="bg-brown-50 p-8 rounded-lg shadow-md">
                            <h3 class="text-2xl font-bold mb-4">مهمتنا</h3>
                            <p class="text-gray-600">
                                تمكين أصحاب السوبر ماركت من خلال توفير حلول تقنية سهلة الاستخدام وفعالة من حيث التكلفة لمساعدتهم على النمو وزيادة المبيعات وتحسين تجربة عملائهم في العالم الرقمي.
                            </p>
                        </div>
                    </div>
                    
                    <!-- فريقنا -->
                    <div class="mb-20">
                        <h3 class="text-2xl font-bold text-center mb-10">فريق العمل</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div class="text-center">
                                <div class="bg-brown-200 w-48 h-48 mx-auto rounded-full mb-4 overflow-hidden">
                                    <!-- استخدام أيقونة كبديل للصورة -->
                                    <div class="w-full h-full flex items-center justify-center text-brown-600">
                                        <i class="fas fa-user-tie text-6xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-bold text-lg">أحمد الخالدي</h4>
                                <p class="text-gray-600">المؤسس والرئيس التنفيذي</p>
                            </div>
                            <div class="text-center">
                                <div class="bg-brown-200 w-48 h-48 mx-auto rounded-full mb-4 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-brown-600">
                                        <i class="fas fa-user-tie text-6xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-bold text-lg">سارة الزهراني</h4>
                                <p class="text-gray-600">مديرة المنتجات</p>
                            </div>
                            <div class="text-center">
                                <div class="bg-brown-200 w-48 h-48 mx-auto rounded-full mb-4 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-brown-600">
                                        <i class="fas fa-user-tie text-6xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-bold text-lg">عمر العتيبي</h4>
                                <p class="text-gray-600">رئيس قسم التطوير</p>
                            </div>
                            <div class="text-center">
                                <div class="bg-brown-200 w-48 h-48 mx-auto rounded-full mb-4 overflow-hidden">
                                    <div class="w-full h-full flex items-center justify-center text-brown-600">
                                        <i class="fas fa-user-tie text-6xl"></i>
                                    </div>
                                </div>
                                <h4 class="font-bold text-lg">لينا الحربي</h4>
                                <p class="text-gray-600">مديرة خدمة العملاء</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إنجازاتنا -->
                    <div class="mb-20">
                        <h3 class="text-2xl font-bold text-center mb-10">إنجازاتنا</h3>
                        <div class="relative">
                            <!-- خط زمني -->
                            <div class="absolute h-full w-1 bg-brown-200 left-1/2 transform -translate-x-1/2"></div>
                            
                            <!-- 2018 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h4 class="font-bold text-lg mb-2">2018</h4>
                                            <p class="text-gray-600">تأسيس الشركة وإطلاق النسخة التجريبية من المنصة مع 10 متاجر.</p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">2018</div>
                                </div>
                            </div>
                            
                            <!-- 2019 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row-reverse">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-right text-center pl-0 md:pl-8 md:mr-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h4 class="font-bold text-lg mb-2">2019</h4>
                                            <p class="text-gray-600">توسيع الفريق وإطلاق النسخة الرسمية الأولى. بلغ عدد المتاجر 100 متجر.</p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">2019</div>
                                </div>
                            </div>
                            
                            <!-- 2020 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h4 class="font-bold text-lg mb-2">2020</h4>
                                            <p class="text-gray-600">إطلاق تطبيق الجوال وتجاوز 500 متجر. ساعدنا المتاجر على التكيف خلال فترة جائحة كورونا.</p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">2020</div>
                                </div>
                            </div>
                            
                            <!-- 2021 -->
                            <div class="relative z-10 mb-12">
                                <div class="flex items-center flex-col md:flex-row-reverse">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-right text-center pl-0 md:pl-8 md:mr-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h4 class="font-bold text-lg mb-2">2021</h4>
                                            <p class="text-gray-600">حصلنا على جولة تمويل ناجحة، وأطلقنا ميزات جديدة مثل نظام الولاء ونقاط المكافآت.</p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">2021</div>
                                </div>
                            </div>
                            
                            <!-- 2022 -->
                            <div class="relative z-10">
                                <div class="flex items-center flex-col md:flex-row">
                                    <div class="md:w-1/2 mb-8 md:mb-0 md:text-left text-center order-last md:order-first pr-0 md:pr-8 md:ml-8">
                                        <div class="bg-white rounded-lg shadow-md p-6">
                                            <h4 class="font-bold text-lg mb-2">2022 - حتى الآن</h4>
                                            <p class="text-gray-600">توسعنا لنشمل أسواقًا جديدة وتجاوزنا حاجز 1000 متجر. إطلاق حلول متكاملة للمتاجر الكبيرة.</p>
                                        </div>
                                    </div>
                                    <div class="bg-brown-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">2022+</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- اتصل بنا -->
                    <div class="bg-brown-50 p-8 rounded-lg shadow-md text-center">
                        <h3 class="text-2xl font-bold mb-4">اتصل بنا</h3>
                        <p class="text-gray-600 mb-6">
                            نحن هنا للإجابة على جميع استفساراتك ومساعدتك في اختيار الحل المناسب لمتجرك
                        </p>
                        <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8 md:space-x-reverse">
                            <div>
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-envelope text-brown-600 ml-2"></i>
                                    <span class="text-gray-600">البريد الإلكتروني:</span>
                                </div>
                                <a href="mailto:info@supermarket-platform.com" class="text-brown-600 hover:underline">info@supermarket-platform.com</a>
                            </div>
                            <div>
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-phone-alt text-brown-600 ml-2"></i>
                                    <span class="text-gray-600">رقم الهاتف:</span>
                                </div>
                                <a href="tel:+966123456789" class="text-brown-600 hover:underline">+966 12 345 6789</a>
                            </div>
                            <div>
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-map-marker-alt text-brown-600 ml-2"></i>
                                    <span class="text-gray-600">العنوان:</span>
                                </div>
                                <span class="text-gray-600">برج المملكة، طريق الملك فهد، الرياض</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       <!-- صفحة تسجيل الدخول -->
<section id="login" class="page-content">
    <div class="page-section bg-brown-50 flex items-center justify-center">
        <div class="container mx-auto px-4">
            <div class="auth-form bg-white rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-center mb-6">تسجيل الدخول</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="أدخل بريدك الإلكتروني" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-medium mb-2">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-input" placeholder="أدخل كلمة المرور" required>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember-me" class="ml-2">
                            <label for="remember-me" class="text-gray-700">تذكرني</label>
                        </div>
                        <a href="#" class="text-brown-600 hover:text-brown-700">نسيت كلمة المرور؟</a>
                    </div>
                    <button type="submit" class="w-full bg-brown-600 text-white py-3 rounded-lg font-bold hover:bg-brown-700 transition duration-300">
                        تسجيل الدخول
                    </button>
                </form>
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        ليس لديك حساب؟ 
                        <a href="{{ route('register') }}" class="text-brown-600 hover:text-brown-700 font-bold">
                            إنشاء حساب جديد
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


        <!-- صفحة إنشاء حساب -->
        <section id="register" class="page-content">
            <div class="page-section bg-brown-50 flex items-center justify-center">
                <div class="container mx-auto px-4">
                    <div class="auth-form bg-white rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold text-center mb-6">إنشاء حساب جديد</h2>
                        <form id="register-form">
                            <div class="mb-4">
                                <label for="store-name" class="block text-gray-700 font-medium mb-2">اسم المتجر</label>
                                <input type="text" id="store-name" class="form-input" placeholder="أدخل اسم متجرك" required>
                            </div>
                            <div class="mb-4">
                                <label for="owner-name" class="block text-gray-700 font-medium mb-2">اسم المالك</label>
                                <input type="text" id="owner-name" class="form-input" placeholder="أدخل اسمك الكامل" required>
                            </div>
                            <div class="mb-4">
                                <label for="register-email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                                <input type="email" id="register-email" class="form-input" placeholder="أدخل بريدك الإلكتروني" required>
                            </div>
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 font-medium mb-2">رقم الجوال</label>
                                <input type="tel" id="phone" class="form-input" placeholder="05xxxxxxxx" required>
                            </div>
                            <div class="mb-4">
                                <label for="register-password" class="block text-gray-700 font-medium mb-2">كلمة المرور</label>
                                <input type="password" id="register-password" class="form-input" placeholder="أدخل كلمة المرور" required>
                            </div>
                            <div class="mb-6">
                                <label for="confirm-password" class="block text-gray-700 font-medium mb-2">تأكيد كلمة المرور</label>
                                <input type="password" id="confirm-password" class="form-input" placeholder="أعد إدخال كلمة المرور" required>
                            </div>
                            <div class="mb-6">
                                <label for="plan" class="block text-gray-700 font-medium mb-2">اختر الخطة</label>
                                <select id="plan" class="form-input">
                                    <option value="basic">الخطة الأساسية - ٢٩٩ ر.س/شهرياً</option>
                                    <option value="pro" selected>الخطة الاحترافية - ٥٩٩ ر.س/شهرياً</option>
                                    <option value="advanced">الخطة المتقدمة - ٩٩٩ ر.س/شهرياً</option>
                                </select>
                            </div>
                            <div class="mb-6 flex items-start">
                                <input type="checkbox" id="terms" class="mt-1 ml-2" required>
                                <label for="terms" class="text-gray-700">
                                    أوافق على <a href="#" class="text-brown-600 hover:underline">الشروط والأحكام</a> و <a href="#" class="text-brown-600 hover:underline">سياسة الخصوصية</a>
                                </label>
                            </div>
                            <button type="submit" class="w-full bg-brown-600 text-white py-3 rounded-lg font-bold hover:bg-brown-700 transition duration-300">
                                إنشاء الحساب
                            </button>
                        </form>
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                لديك حساب بالفعل؟ 
                                <a href="#login" class="text-brown-600 hover:text-brown-700 font-bold" onclick="changePage('login')">
                                    تسجيل الدخول
                                </a>
                            </p>
                        </div>
                        
                        <!-- تعليقات Laravel -->
                        <div class="mt-8 border-t pt-6 text-gray-500 text-sm">
                            <!-- 
                            في Laravel، يمكن استخدام:
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                ...
                            </form>
                            
                            للتحقق من صحة البيانات في الخلفية:
                            $request->validate([
                                'store_name' => 'required|string|max:255',
                                'email' => 'required|string|email|max:255|unique:users',
                                'password' => 'required|string|min:8|confirmed',
                            ]);
                            -->
                            <p>* هذا النموذج سيتم ربطه بـ Laravel بواسطة إضافة CSRF protection ومعالجة التسجيل في RegisterController</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Footer -->
    <footer class="bg-brown-900 text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">منصة السوبر ماركت</h3>
                    <p class="text-bg-brown-50 hover:text-gray-400 ">
                        المنصة الرائدة في مجال التجارة الإلكترونية للسوبر ماركت في المنطقة العربية، نساعد المتاجر على النمو رقميًا.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-bg-brown-50 hover:text-gray-400 "><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-bg-brown-50 hover:text-gray-400 "><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-bg-brown-50 hover:text-gray-400 "><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-bg-brown-50 hover:text-gray-400 "><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-bg-brown-50 hover:text-gray-400 " onclick="changePage('features')">المميزات</a></li>
                        <li><a href="#how-it-works" class="text-bg-brown-50 hover:text-gray-400 " onclick="changePage('how-it-works')">كيف تعمل</a></li>
                        <li><a href="#pricing" class="text-bg-brown-50 hover:text-gray-400 " onclick="changePage('pricing')">الأسعار</a></li>
                        <li><a href="#testimonials" class="text-bg-brown-50 hover:text-gray-400 " onclick="changePage('testimonials')">آراء العملاء</a></li>
                        <li><a href="#about" class="text-bg-brown-50 hover:text-gray-400 " onclick="changePage('about')">من نحن</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">المساعدة والدعم</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-bg-brown-50 hover:text-gray-400 ">مركز المساعدة</a></li>
                        <li><a href="#" class="text-bg-brown-50 hover:text-gray-400 ">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="text-bg-brown-50 hover:text-gray-400 ">التواصل مع الدعم</a></li>
                        <li><a href="#" class="text-bg-brown-50 hover:text-gray-400 ">الشروط والأحكام</a></li>
                        <li><a href="#" class="text-bg-brown-50 hover:text-gray-400 ">سياسة الخصوصية</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">اتصل بنا</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="text-bg-brown-50 hover:text-gray-400 "></i>
                            <span class="text-bg-brown-50 hover:text-gray-400 ">     حضرموت,المكلا</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 ml-2 text-gray-400"></i>
                            <a href="tel:+966123456789" class="text-bg-brown-50 hover:text-gray-400 ">+967 733 972 484</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 ml-2 text-gray-400"></i>
                            <a href="mailto:info@supermarket-platform.com" class="text-bg-brown-50 hover:text-gray-400 ">VibCart@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-brown-700 my-8">
            <div class="text-center text-gray-400">
                <p>&copy; 2023 منصة السوبر ماركت. جميع الحقوق محفوظة.</p>
            </div>
            
            <!-- Laravel Comments -->
            <div class="mt-4 text-xs text-gray-600 text-center">
                <!-- 
                في Laravel، يمكن استخدام:
                <footer>
                    &copy; {{ date('Y') }} منصة السوبر ماركت
                </footer>
                -->
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script>
       
        
        // التبديل بين الصفحات
        function changePage(pageId) {
            // إخفاء جميع الصفحات
            document.querySelectorAll('.page-content').forEach(page => {
                page.classList.remove('active');
            });
            
            // إظهار الصفحة المحددة
            document.getElementById(pageId).classList.add('active');
            
            // تحديث التنقل
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + pageId) {
                    link.classList.add('active');
                }
            });
            
            // تمرير الصفحة إلى الأعلى
            window.scrollTo(0, 0);
            
            // إغلاق قائمة الجوال إذا كانت مفتوحة
            document.getElementById('mobile-menu').classList.add('hidden');
            
            // Laravel Comments
            /*
             * في Laravel، يمكن استخدام الروابط بهذا الشكل:
             * <a href="{{ route('features') }}">المميزات</a>
             *
             * ثم تعريف الروتات في routes/web.php:
             * Route::get('/features', 'PageController@features')->name('features');
             * Route::get('/how-it-works', 'PageController@howItWorks')->name('how-it-works');
             * وهكذا...
             */
        }
        
        // تبديل زر القائمة للجوال
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // تبديل بين الأسعار الشهرية والسنوية
        document.getElementById('monthly-btn').addEventListener('click', function() {
            this.classList.add('bg-brown-600', 'text-white');
            document.getElementById('yearly-btn').classList.remove('bg-brown-600', 'text-white');
            // هنا يمكن تغيير الأسعار المعروضة
        });
        
        document.getElementById('yearly-btn').addEventListener('click', function() {
            this.classList.add('bg-brown-600', 'text-white');
            document.getElementById('monthly-btn').classList.remove('bg-brown-600', 'text-white');
            // هنا يمكن تغيير الأسعار المعروضة
        });
        
        // عرض المزيد من آراء العملاء
        document.getElementById('show-more-testimonials').addEventListener('click', function() {
            const moreTestimonials = document.getElementById('more-testimonials');
            moreTestimonials.classList.toggle('hidden');
            
            if (moreTestimonials.classList.contains('hidden')) {
                this.textContent = 'عرض المزيد من الآراء';
            } else {
                this.textContent = 'عرض عدد أقل';
            }
        });
        
        // التحقق من صحة نموذج تسجيل الدخول
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            // هنا يمكن إضافة كود التحقق من صحة البيانات
            alert('تم تسجيل الدخول بنجاح!');
        });
        
        // التحقق من صحة نموذج إنشاء الحساب
        document.getElementById('register-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('كلمة المرور غير متطابقة. يرجى المحاولة مرة أخرى.');
                return;
            }
            
            // هنا يمكن إضافة المزيد من التحققات
            
            alert('تم إنشاء الحساب بنجاح!');
        });
        
        // حل المشكلة عند استخدام الهاش في الرابط
        window.addEventListener('load', function() {
            const hash = window.location.hash.replace('#', '');
            if (hash && document.getElementById(hash)) {
                changePage(hash);
            }
        });
        
       
    </script>
</body>
</html>