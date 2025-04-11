<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupermarketController extends Controller
{
    /**
     * عرض قائمة بكل السوبرماركتات.
     */
    public function index()
    {
        $supermarkets = SuperMarket::all();
        return response()->json(['supermarkets' => $supermarkets]);
    }

    /**
     * تخزين سوبرماركت جديد.
     */
    public function store(Request $request)
    {
        // تعريف قواعد التحقق والرسائل المخصصة
        $rules = [
            'User_id'         => 'required|integer',
            'SupermarketName' => 'required|string|max:255',
            'Location'        => 'required|string|max:255',
            'ContactNumber'   => 'required|string|max:15',
        ];

        $messages = [
            'User_id.required'         => 'يرجى إدخال معرف المستخدم.',
            'SupermarketName.required' => 'يرجى إدخال اسم السوبرماركت.',
            'Location.required'        => 'يرجى إدخال الموقع.',
            'ContactNumber.required'   => 'يرجى إدخال رقم الاتصال.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supermarket = SuperMarket::create([
            'User_id'         => $request->User_id,
            'SupermarketName' => $request->SupermarketName,
            'Location'        => $request->Location,
            'ContactNumber'   => $request->ContactNumber,
        ]);

        return response()->json([
            'message' => 'تم تسجيل السوبرماركت بنجاح!',
            'supermarket' => $supermarket
        ], 201);
    }

    /**
     * عرض تفاصيل سوبرماركت مع منتجاته.
     */
    public function show($id)
    {
        $supermarket = SuperMarket::with('products')->find($id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        return response()->json(['supermarket' => $supermarket]);
    }

    /**
     * تحديث بيانات سوبرماركت.
     */
    public function update(Request $request, $id)
    {
        $supermarket = SuperMarket::find($id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }

        $rules = [
            'User_id'         => 'required|integer',
            'SupermarketName' => 'required|string|max:255',
            'Location'        => 'required|string|max:255',
            'ContactNumber'   => 'required|string|max:15',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $supermarket->update($request->all());
        return response()->json([
            'message' => 'تم تعديل السوبرماركت بنجاح!',
            'supermarket' => $supermarket
        ]);
    }

    /**
     * حذف سوبرماركت.
     */
    public function destroy($id)
    {
        $supermarket = SuperMarket::find($id);
        if (!$supermarket) {
            return response()->json(['message' => 'السوبرماركت غير موجود'], 404);
        }
        $supermarket->delete();
        return response()->json(['message' => 'تم حذف السوبرماركت بنجاح']);
    }
}
