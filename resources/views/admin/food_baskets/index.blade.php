@extends('admin.layout.master')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
            <p class="font-bold">تم بنجاح!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="card bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="bi bi-basket ml-2"></i> السلات الغذائية لسوبرماركت {{ $supermarket->SupermarketName ?? '' }}
            </h2>
            <a href="{{ route('supermarket.food_baskets.create', $supermarket->id) }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center">
                <i class="bi bi-plus-circle ml-2"></i>
                إضافة سلة جديدة
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">اسم السلة</th>
                        <th class="px-4 py-2">السعر</th>
                        <th class="px-4 py-2">صورة</th>
                        <th class="px-4 py-2">الوصف</th>
                        <th class="px-4 py-2">فترة التوفر</th>
                        <th class="px-4 py-2">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($foodBaskets as $basket)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-bold">{{ $basket->name }}</td>
                        <td class="px-4 py-2 font-bold text-green-700">
    {{ number_format($basket->price, 2) }} ر.س
</td>
                        <td class="px-4 py-2">
                            @if($basket->image)
                                <img src="{{ asset('storage/'.$basket->image) }}" class="h-16 w-16 object-cover rounded shadow">
                            @else
                                <div class="h-16 w-16 flex items-center justify-center bg-gray-100 rounded">
                                    <i class="bi bi-image text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 max-w-xs text-gray-700 truncate">{{ $basket->description }}</td>
                        <td class="px-4 py-2 text-gray-800">
                            <div>
                                <span class="inline-block bg-green-100 text-green-800 rounded px-2 py-1 text-xs font-medium">
                                    من {{ $basket->start_date->format('Y-m-d') }}
                                </span>
                                <span class="inline-block bg-red-100 text-red-800 rounded px-2 py-1 text-xs font-medium ml-1">
                                    إلى {{ $basket->end_date->format('Y-m-d') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-2 space-x-2 flex flex-row-reverse">
                            <a href="{{ route('supermarket.food_baskets.edit', [$supermarket->id, $basket->id]) }}"
                                class="text-blue-600 hover:underline font-semibold">
                                <i class="bi bi-pencil-square"></i> تعديل
                            </a>
                            <form action="{{ route('supermarket.food_baskets.destroy', [$supermarket->id, $basket->id]) }}"
                                method="POST" class="inline"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذه السلة؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-semibold ml-2">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">
                            لا توجد سلات غذائية مضافة بعد.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $foodBaskets->links() }}
            </div>
        </div>
    </div>
@endsection
