<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FoodBasket;
use App\Models\SuperMarket;

class FoodBasketController extends Controller
{
    
    // عرض كل السلات لسوبرماركت محدد
    public function index($supermarket_id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        $foodBaskets = $supermarket->foodBaskets()->latest()->paginate(10);
        return view('Admin.food_baskets.index', compact('foodBaskets', 'supermarket'));
    }

    // عرض صفحة إنشاء سلة جديدة
    public function create($supermarket_id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        return view('Admin.food_baskets.create', compact('supermarket'));
    }

    // حفظ السلة الجديدة
    public function store(Request $request, $supermarket_id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        // رفع الصورة إن وجدت
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('food_baskets', 'public');
        }

         $data['supermarket_id'] = $supermarket->id;

        FoodBasket::create($data);

        return redirect()->route('supermarket.food_baskets.index', $supermarket->id)
                         ->with('success', 'تم إضافة السلة الغذائية بنجاح');
    }

    // عرض تفاصيل سلة واحدة
    public function show($supermarket_id, $id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        $foodBasket = $supermarket->foodBaskets()->findOrFail($id);
        return view('Admin.food_baskets.show', compact('foodBasket', 'supermarket'));
    }

    // عرض صفحة التعديل
    public function edit($supermarket_id, $id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        $foodBasket = $supermarket->foodBaskets()->findOrFail($id);
        return view('Admin.food_baskets.edit', compact('foodBasket', 'supermarket'));
    }

    // حفظ التعديل
    public function update(Request $request, $supermarket_id, $id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        $foodBasket = $supermarket->foodBaskets()->findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',  
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        // رفع صورة جديدة إن وجدت
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('food_baskets', 'public');
        }

        $foodBasket->update($data);

        return redirect()->route('supermarket.food_baskets.index', $supermarket->id)
                         ->with('success', 'تم تحديث بيانات السلة الغذائية بنجاح');
    }

    // حذف السلة
    public function destroy($supermarket_id, $id)
    {
        $supermarket = SuperMarket::findOrFail($supermarket_id);
        $foodBasket = $supermarket->foodBaskets()->findOrFail($id);
        $foodBasket->delete();

        return redirect()->route('supermarket.food_baskets.index', $supermarket->id)
                         ->with('success', 'تم حذف السلة الغذائية بنجاح');
    }
}