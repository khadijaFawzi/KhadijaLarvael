/**
 * dashboard.js - JavaScript functions for Laravel Supermarket Dashboard
 * تطوير بواسطة Genspark AI
 */

document.addEventListener('DOMContentLoaded', function() {
    // ============== إعدادات القائمة الجانبية ==============
    initSidebar();
    
    // ============== تهيئة عناصر البوتستراب ==============
    initBootstrapComponents();
    
    // ============== معالجة النماذج والتحقق منها ==============
    initFormValidation();
    
    // ============== معاينة الصور قبل الرفع ==============
    initImagePreview();
    
    // ============== إعدادات جداول البيانات ==============
    initDataTables();
    
    // ============== إعدادات التقويم والتاريخ ==============
    initDatePickers();
    
    // ============== إدارة الإشعارات ==============
    initNotifications();
    
    // ============== وظائف الرسوم البيانية ==============
    initCharts();
});

/**
 * تهيئة وظائف القائمة الجانبية
 */
function initSidebar() {
    // تبديل القائمة الجانبية
    const sidebarToggler = document.querySelector('.sidebar-toggler');
    if (sidebarToggler) {
        sidebarToggler.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed'));
        });
    }
    
    // استرجاع حالة القائمة من التخزين المحلي
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
        document.body.classList.add('sidebar-collapsed');
    }
    
    // تفعيل القوائم المنسدلة
    const dropdownItems = document.querySelectorAll('.sidebar-menu .nav-item.has-treeview');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // منع الانتشار للروابط الفرعية
            if (e.target.closest('.nav-treeview')) return;
            
            e.preventDefault();
            const navTreeview = this.querySelector('.nav-treeview');
            
            // إذا كانت القائمة مغلقة، نغلق الجميع أولاً
            if (!this.classList.contains('menu-open')) {
                document.querySelectorAll('.sidebar-menu .nav-item.has-treeview.menu-open').forEach(openItem => {
                    if (openItem !== this) {
                        openItem.classList.remove('menu-open');
                        const treeview = openItem.querySelector('.nav-treeview');
                        if (treeview) {
                            treeview.style.display = 'none';
                        }
                    }
                });
            }
            
            // تبديل حالة القائمة الحالية
            this.classList.toggle('menu-open');
            if (navTreeview) {
                navTreeview.style.display = this.classList.contains('menu-open') ? 'block' : 'none';
            }
        });
    });
    
    // تعليم القائمة النشطة
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-menu .nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath || 
            (link.getAttribute('href') !== '#' && currentPath.includes(link.getAttribute('href')))) {
            link.classList.add('active');
            
            // تفعيل القائمة الأب
            const parentItem = link.closest('.nav-item.has-treeview');
            if (parentItem) {
                parentItem.classList.add('menu-open');
                const treeview = parentItem.querySelector('.nav-treeview');
                if (treeview) {
                    treeview.style.display = 'block';
                }
            }
        }
    });
}

/**
 * تهيئة مكونات Bootstrap
 */
function initBootstrapComponents() {
    // تفعيل التلميحات
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
    
    // تفعيل البوبوفر
    const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
    popovers.forEach(popover => {
        new bootstrap.Popover(popover);
    });
    
    // تفعيل المودالات
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal._modal = new bootstrap.Modal(modal);
        
        // إضافة مستمعي الأحداث للأزرار التي تفتح المودال
        const modalTriggers = document.querySelectorAll(`[data-bs-target="#${modal.id}"]`);
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                modal._modal.show();
            });
        });
    });
}

/**
 * التحقق من صحة النماذج
 */
function initFormValidation() {
    // معالجة جميع النماذج التي تحتاج إلى تحقق
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
        
        // التحقق من حقول الرقم والسعر
        const numberInputs = form.querySelectorAll('input[type="number"]');
        numberInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });
        
        // التحقق من حقول البريد الإلكتروني
        const emailInputs = form.querySelectorAll('input[type="email"]');
        emailInputs.forEach(input => {
            input.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.setCustomValidity('يرجى إدخال بريد إلكتروني صحيح');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
        
        // التحقق من حقول الهاتف
        const phoneInputs = form.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('blur', function() {
                const phoneRegex = /^[0-9+\-\s()]{8,15}$/;
                if (this.value && !phoneRegex.test(this.value)) {
                    this.setCustomValidity('يرجى إدخال رقم هاتف صحيح');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    });
}

/**
 * معاينة الصور قبل الرفع
 */
function initImagePreview() {
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    imageInputs.forEach(input => {
        // إنشاء عنصر معاينة إذا لم يكن موجودًا
        let previewContainer = document.querySelector(`#preview-${input.id}`);
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.id = `preview-${input.id}`;
            previewContainer.className = 'image-preview mt-2';
            input.insertAdjacentElement('afterend', previewContainer);
        }
        
        input.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxHeight = '200px';
                    previewContainer.appendChild(img);
                    
                    // إضافة زر لإزالة الصورة
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.addEventListener('click', function() {
                        input.value = '';
                        previewContainer.innerHTML = '';
                    });
                    
                    previewContainer.style.position = 'relative';
                    previewContainer.appendChild(removeBtn);
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
}

/**
 * تهيئة جداول البيانات
 */
function initDataTables() {
    // التحقق من وجود مكتبة DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').each(function() {
            $(this).DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
                },
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "dom": '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex"f>>t<"d-flex justify-content-between align-items-center mt-3"<"d-flex align-items-center"i><"d-flex align-items-center"p>>'
            });
        });
    }
}

/**
 * تهيئة أدوات اختيار التاريخ
 */
function initDatePickers() {
    // التحقق من وجود مكتبة flatpickr
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.date-picker', {
            dateFormat: 'Y-m-d',
            locale: 'ar',
            disableMobile: true
        });
        
        // إعداد نطاق التاريخ للعروض
        const startDateInputs = document.querySelectorAll('.start-date-picker');
        startDateInputs.forEach(input => {
            const endDateInput = document.querySelector(`#${input.id.replace('start', 'end')}`);
            
            if (endDateInput) {
                const startPicker = flatpickr(input, {
                    dateFormat: 'Y-m-d',
                    locale: 'ar',
                    disableMobile: true,
                    onChange: function(selectedDates, dateStr) {
                        endPicker.set('minDate', dateStr);
                    }
                });
                
                const endPicker = flatpickr(endDateInput, {
                    dateFormat: 'Y-m-d',
                    locale: 'ar',
                    disableMobile: true,
                    onChange: function(selectedDates, dateStr) {
                        startPicker.set('maxDate', dateStr);
                    }
                });
            }
        });
    } else {
        // Fallback للمتصفحات التي لا تدعم flatpickr
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                // التحقق من تواريخ العروض
                if (this.className.includes('start-date') || this.className.includes('end-date')) {
                    const relatedInputId = this.className.includes('start-date') 
                        ? this.id.replace('start', 'end')
                        : this.id.replace('end', 'start');
                    
                    const relatedInput = document.getElementById(relatedInputId);
                    
                    if (relatedInput) {
                        if (this.className.includes('start-date')) {
                            relatedInput.min = this.value;
                        } else {
                            relatedInput.max = this.value;
                        }
                    }
                }
            });
        });
    }
}

/**
 * تهيئة نظام الإشعارات
 */
function initNotifications() {
    // التحقق من وجود رسائل نجاح أو خطأ من الجلسة
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // إضافة زر إغلاق إذا لم يكن موجودًا
        if (!alert.querySelector('.btn-close')) {
            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'btn-close';
            closeButton.setAttribute('data-bs-dismiss', 'alert');
            closeButton.setAttribute('aria-label', 'إغلاق');
            
            alert.classList.add('alert-dismissible', 'fade', 'show');
            alert.appendChild(closeButton);
        }
        
        // إخفاء التنبيه تلقائيًا بعد 5 ثوانٍ
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // إنشاء وظيفة لإظهار الإشعارات
    window.showNotification = function(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        `;
        
        // إضافة الإشعار إلى حاوية الإشعارات أو إلى الصفحة
        const notificationContainer = document.querySelector('.notification-container') || document.body;
        notificationContainer.appendChild(alertDiv);
        
        // إخفاء الإشعار تلقائيًا بعد 5 ثوانٍ
        setTimeout(() => {
            alertDiv.classList.remove('show');
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        }, 5000);
    };
}

/**
 * تهيئة الرسوم البيانية للإحصائيات
 */
function initCharts() {
    // التحقق من وجود مكتبة Chart.js
    if (typeof Chart !== 'undefined') {
        // الألوان الموحدة للرسوم البيانية
        const chartColors = {
            primary: '#3490dc',
            success: '#38c172',
            info: '#6cb2eb',
            warning: '#ffed4a',
            danger: '#e3342f',
            secondary: '#6c757d',
            light: '#f8f9fa',
            dark: '#343a40'
        };
        
        // رسم بياني للمبيعات الشهرية
        const salesChartElement = document.getElementById('salesChart');
        if (salesChartElement) {
            new Chart(salesChartElement, {
                type: 'line',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
                    datasets: [{
                        label: 'المبيعات',
                        data: [65, 59, 80, 81, 56, 55, 40, 30, 45, 55, 60, 70],
                        borderColor: chartColors.primary,
                        backgroundColor: 'rgba(52, 144, 220, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'المبيعات الشهرية'
                        }
                    }
                }
            });
        }
        
        // رسم بياني للمنتجات الأكثر مبيعاً
        const topProductsElement = document.getElementById('topProductsChart');
        if (topProductsElement) {
            new Chart(topProductsElement, {
                type: 'bar',
                data: {
                    labels: ['منتج 1', 'منتج 2', 'منتج 3', 'منتج 4', 'منتج 5'],
                    datasets: [{
                        label: 'المبيعات',
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: Object.values(chartColors).slice(0, 5),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'المنتجات الأكثر مبيعاً'
                        }
                    }
                }
            });
        }
        
        // رسم بياني دائري لفئات المنتجات
        const categoriesChartElement = document.getElementById('categoriesChart');
        if (categoriesChartElement) {
            new Chart(categoriesChartElement, {
                type: 'doughnut',
                data: {
                    labels: ['فئة 1', 'فئة 2', 'فئة 3', 'فئة 4', 'فئة 5'],
                    datasets: [{
                        data: [30, 50, 20, 10, 5],
                        backgroundColor: Object.values(chartColors).slice(0, 5),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'توزيع فئات المنتجات'
                        }
                    }
                }
            });
        }
    }
}

/**
 * وظيفة لحساب سعر المنتج بعد الخصم
 * @param {number} price - السعر الأصلي
 * @param {number} discount - نسبة الخصم
 * @returns {number} - السعر بعد الخصم
 */
function calculateDiscountedPrice(price, discount) {
    return price - (price * (discount / 100));
}

/**
 * تأكيد الحذف
 * @param {string} message - رسالة التأكيد
 * @returns {boolean} - نتيجة التأكيد
 */
function confirmDelete(message = 'هل أنت متأكد من رغبتك في الحذف؟') {
    return confirm(message);
}

/**
 * تحميل بيانات المنتج للعرض
 * @param {number} productId - معرف المنتج
 * @param {string} route - الرابط للحصول على بيانات المنتج
 */
function loadProductDetails(productId, route) {
    if (productId) {
        fetch(`${route}?product_id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.product) {
                    const priceField = document.getElementById('original_price');
                    if (priceField) {
                        priceField.value = data.product.Price;
                    }
                    
                    // عرض صورة المنتج إذا كانت متاحة
                    const productImageContainer = document.getElementById('product_image_container');
                    if (productImageContainer && data.product.Image) {
                        productImageContainer.innerHTML = `
                            <img src="${data.product.Image}" class="img-thumbnail" style="max-height: 150px;" alt="${data.product.product_name}">
                        `;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading product details:', error);
            });
    }
}

/**
 * حساب السعر بعد الخصم لنموذج العروض
 */
function initDiscountCalculator() {
    const productSelect = document.getElementById('product_id');
    const discountInput = document.getElementById('discount_percentage');
    const originalPriceElement = document.getElementById('original_price');
    const discountedPriceElement = document.getElementById('discounted_price');
    
    if (productSelect && discountInput && originalPriceElement && discountedPriceElement) {
        const calculateDiscount = () => {
            const originalPrice = parseFloat(originalPriceElement.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            
            const discountedPrice = calculateDiscountedPrice(originalPrice, discount);
            discountedPriceElement.value = discountedPrice.toFixed(2);
        };
        
        // حساب السعر المخفض عند تغيير المنتج أو نسبة الخصم
        productSelect.addEventListener('change', calculateDiscount);
        discountInput.addEventListener('input', calculateDiscount);
        
        // حساب السعر المخفض عند تحميل الصفحة
        calculateDiscount();
    }
}

// تنفيذ حساب الخصم عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    initDiscountCalculator();
});

/**
 * طباعة العناصر
 * @param {string} elementId - معرف العنصر المراد طباعته
 */
function printElement(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html dir="rtl">
        <head>
            <title>طباعة</title>
            <style>
                @media print {
                    body {
                        font-family: Arial, sans-serif;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: right;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                }
            </style>
        </head>
        <body>
            ${element.innerHTML}
            <script>
                window.onload = function() {
                    window.print();
                    window.setTimeout(function() {
                        window.close();
                    }, 500);
                }
            </script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// إضافة أداة مساعدة لتنسيق الأرقام بالعملة
window.formatCurrency = function(amount, currency = 'ر.س') {
    return parseFloat(amount).toFixed(2) + ' ' + currency;
};