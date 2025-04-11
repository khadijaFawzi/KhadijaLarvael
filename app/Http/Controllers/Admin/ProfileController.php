<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperMarket;

use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;
 

class ProfileController extends Controller
{
    // عرض صفحة البروفايل
    public function edit($id)
    {
    
            // تمرير بيانات السوبرماركت للعرض
            $user = Auth::user();
    
            // استرجاع بيانات السوبرماركت عبر العلاقة
            $superMarket = $user->supermarket;
            return view('admin.profile', compact('user', 'superMarket'));
    }

    // تحديث بيانات البروفايل الخاص بالسوبرماركت
   public function updateProfile(Request $request, $id)
{
    // التحقق من صحة المدخلات
    $validatedData = $request->validate([
        'SupermarketName' => 'required|string|max:255',
        'Location'        => 'required|string|max:255',
        'email'           => 'required|email|max:255',
        'ContactNumber'   => 'required|string|max:20',
        // إذا تم إدخال كلمة مرور جديدة يجب إدخال كلمة المرور الحالية
        'current_password' => 'nullable|required_with:new_password',
        'new_password'     => 'nullable|string|min:6|confirmed',
        'profile_image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $superMarket = SuperMarket::findOrFail($id);
    $user = auth()->user();

    // تحديث بيانات السوبرماركت
    $superMarket->SupermarketName = $validatedData['SupermarketName'];
    $superMarket->Location        = $validatedData['Location'];
    $superMarket->ContactNumber   = $validatedData['ContactNumber'];

    // تحديث البريد الإلكتروني
    $user->email = $validatedData['email'];

    // إذا تم إدخال كلمة مرور جديدة، تحقق من صحة كلمة المرور الحالية
    if (!empty($validatedData['new_password'])) {
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'كلمة المرور الحالية غير صحيحة'
            ]);
        }
        $user->password = Hash::make($validatedData['new_password']);
    }

    // معالجة رفع الصورة إن وُجد ملف
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $superMarket->profile_image = $filename;
            // إذا كنت تريد تحديث صورة المستخدم كذلك
            $user->profile_image = $filename;
        }
    }

    $superMarket->save();

    //لكي يعمل التححق من كلمة السر يجب اصلاح هذا الخطا
   // $user->save();

    return redirect()->back()->with('success', 'تم تحديث البيانات بنجاح');
}

}
