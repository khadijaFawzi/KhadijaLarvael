<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuperMarket;
use Illuminate\Http\Request;

class SupermarketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('CreateSupermarket');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // التحقق من صحة البيانات المدخلة
         $request->validate([
            'User_id' => 'required|integer',
            'SupermarketName' => 'required|string|max:255',
            'Location' => 'required|string|max:255',
            'ContactNumber' => 'required|string|max:15',
        ]);
    
        // إنشاء السوبرماركت الجديد
        $supermarket = Supermarket::create([
            'User_id' => $request->User_id,
            'SupermarketName' => $request->SupermarketName,
            'Location' => $request->Location,
            'ContactNumber' => $request->ContactNumber,
        ]);
    
        // إعادة التوجيه إلى لوحة تحكم السوبرماركت باستخدام المعرف
        return redirect()->route('Dashborad', ['id' => $supermarket->id])
                         ->with('success', 'تم تسجيل السوبرماركت بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    } public function dashboard($id)
    {
        // جلب السوبر ماركت والمنتجات الخاصة به
        $supermarket = Supermarket::with('products')->findOrFail($id);

        // تمرير البيانات إلى العرض
        return view('admin.Dashborad', compact('supermarket'));
    }
}
