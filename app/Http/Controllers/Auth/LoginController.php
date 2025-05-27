<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuperMarket; 
class LoginController extends Controller
{
    //
   
    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // عملية تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // محاولة تسجيل الدخول باستخدام البريد الإلكتروني وكلمة المرور
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // جلب المستخدم المسجل
            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect()->route('general_management.dashboard');
            }
            // التحقق مما إذا كان المستخدم مرتبطًا بسوبرماركت
            $supermarket = SuperMarket::where('User_id', $user->id)->first();

            if ($supermarket) {
                // إذا كان المستخدم لديه سوبرماركت مرتبط، قم بتوجيهه إلى لوحة القيادة الخاصة به
                return redirect()->route('dashboard', ['id' => $supermarket->id]);
            }

            // إذا لم يكن لديه سوبرماركت، يمكن توجيهه إلى صفحة أخرى مثل صفحة اختيار نوع المستخدم
            return redirect()->route('select_type_of_user');
        }

        // إذا فشل تسجيل الدخول
        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ]);
    }

    // عملية تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}