@extends('general-management.layout')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">تقرير المستخدمين</h1>
    <p class="text-gray-600">استعراض ومتابعة حسابات المستخدمين في النظام</p>
</div>

<!-- بطاقات الإحصائيات -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card bg-white overflow-hidden">
        <div class="p-6 flex items-start">
            <div class="stat-icon bg-blue-100 text-blue-600">
                <i class="bi bi-people"></i>
            </div>
            <div class="mr-5">
                <p class="text-gray-500 text-sm mb-1">إجمالي العملاء</p>
                <div class="flex items-center">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalCustomers }}</h3>
                    <span class="mr-2 text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full">عميل</span>
                </div>
                <p class="text-gray-500 text-sm mt-2">
                    <i class="bi bi-arrow-up-right text-green-500"></i>
                    <span class="text-green-500 font-medium">+5.2%</span> مقارنة بالشهر السابق
                </p>
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 py-3 px-6">
            <a href="#" class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium">
                <span>عرض تفاصيل العملاء</span>
                <i class="bi bi-chevron-left mr-2"></i>
            </a>
        </div>
    </div>

    <div class="card bg-white overflow-hidden">
        <div class="p-6 flex items-start">
            <div class="stat-icon bg-green-100 text-green-600">
                <i class="bi bi-shop"></i>
            </div>
            <div class="mr-5">
                <p class="text-gray-500 text-sm mb-1">إجمالي السوبرماركت</p>
                <div class="flex items-center">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalSupermarkets }}</h3>
                    <span class="mr-2 text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full">متجر</span>
                </div>
                <p class="text-gray-500 text-sm mt-2">
                    <i class="bi bi-arrow-up-right text-green-500"></i>
                    <span class="text-green-500 font-medium">+2.8%</span> مقارنة بالشهر السابق
                </p>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-50 to-green-100 py-3 px-6">
            <a href="#" class="text-green-600 hover:text-green-800 flex items-center text-sm font-medium">
                <span>عرض تفاصيل السوبرماركت</span>
                <i class="bi bi-chevron-left mr-2"></i>
            </a>
        </div>
    </div>
</div>

<!-- قسم البحث والفلترة -->
<div class="card mb-8">
    <div class="card-body">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="sr-only">بحث</label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="bi bi-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search" class="block w-full p-2 pr-10 text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" placeholder="بحث عن مستخدم...">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div>
                    <select class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>نوع المستخدم</option>
                        <option value="1">مدير عام</option>
                        <option value="2">سوبرماركت</option>
                        <option value="3">عميل</option>
                    </select>
                </div>
                <div>
                    <select class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option selected>تاريخ التسجيل</option>
                        <option value="today">اليوم</option>
                        <option value="week">هذا الأسبوع</option>
                        <option value="month">هذا الشهر</option>
                    </select>
                </div>
                <button class="bg-blue-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-blue-700 transition-colors">تطبيق</button>
            </div>
        </div>
    </div>
</div>

<!-- جدول المستخدمين -->
<div class="card">
    <div class="card-header flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">جميع المستخدمين</h2>
            <p class="text-sm text-gray-500">إجمالي: {{ count($users) }} مستخدم</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-medium hover:bg-gray-50">
                <i class="bi bi-file-excel mr-1"></i> تصدير
            </button>
            <button class="bg-white text-gray-700 border border-gray-300 rounded-lg px-3 py-1.5 text-sm font-medium hover:bg-gray-50">
                <i class="bi bi-printer mr-1"></i> طباعة
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th scope="col" class="px-6 py-4">#</th>
                    <th scope="col" class="px-6 py-4">الاسم</th>
                    <th scope="col" class="px-6 py-4">البريد الإلكتروني</th>
                    <th scope="col" class="px-6 py-4">نوع المستخدم</th>
                    <th scope="col" class="px-6 py-4">تاريخ التسجيل</th>
                    <th scope="col" class="px-6 py-4">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                {{ substr($user->username, 0, 1) }}
                            </div>
                            <div class="mr-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->username }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->Role_id == 1)
                            <span class="badge bg-purple-100 text-purple-800">
                                <i class="bi bi-shield-check mr-1"></i> مدير عام
                            </span>
                        @elseif($user->Role_id == 2)
                            <span class="badge bg-green-100 text-green-800">
                                <i class="bi bi-shop mr-1"></i> سوبرماركت
                            </span>
                        @elseif($user->Role_id == 3)
                            <span class="badge bg-blue-100 text-blue-800">
                                <i class="bi bi-person mr-1"></i> عميل
                            </span>
                        @else
                            <span class="badge bg-gray-100 text-gray-800">
                                <i class="bi bi-question-circle mr-1"></i> غير محدد
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-calendar-event mr-1"></i>
                            {{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-left">
                        <div class="flex space-x-reverse space-x-2 text-sm">
                            <button class="text-blue-600 hover:text-blue-900">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-900">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-900">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                عرض <span class="font-medium">1</span> إلى <span class="font-medium">10</span> من أصل <span class="font-medium">{{ count($users) }}</span> مستخدم
            </div>
            <div class="flex space-x-reverse space-x-1">
                <button class="px-3 py-1 text-sm text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50 disabled:opacity-50" disabled>
                    السابق
                </button>
                <button class="px-3 py-1 text-sm text-white bg-blue-600 rounded-md border border-blue-600 hover:bg-blue-700">
                    1
                </button>
                <button class="px-3 py-1 text-sm text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
                    2
                </button>
                <button class="px-3 py-1 text-sm text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50">
                    التالي
                </button>
            </div>
        </div>
    </div>
</div>
@endsection