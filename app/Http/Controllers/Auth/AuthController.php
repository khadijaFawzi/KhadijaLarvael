<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SuperMarket;
use Google\Rpc\Context\AttributeContext\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\confirm;

class AuthController extends Controller
{
    // عرض صفحة التسجيل
    public function showRegister(){
        return view('auth.register');
    }

    // عرض صفحة تسجيل الدخول
    public function showLogin(){
        return view('auth.login');
    }

    // عملية التسجيل
    public function Register(Request $request)
    {
        // التحقق من صحة البيانات مع إضافة الحقول الخاصة ببيانات السوبرماركت
        $validated = $request->validate([
            'username'         => 'required|string|max:225',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|string|min:8|confirmed',
            'SupermarketName'  => 'required|string|max:255',
            'Location'         => 'required|string|max:255',
            'ContactNumber'    => 'required|string|max:20',
        ]);

        // تشفير كلمة المرور وتعيين دور المستخدم (مثلاً: 2 للدور الخاص بمدير السوبرماركت)
        $validated['password'] = Hash::make($validated['password']);
        $validated['Role_id'] = 2;  // تعيين دور المستخدم إلى تاجر

        // إنشاء سجل المستخدم
        $user = User::create([
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'Role_id'  => $validated['Role_id'],
        ]);

        // إنشاء سجل السوبرماركت وربطه بالمستخدم عبر مفتاح user_id
        $supermarket = SuperMarket::create([
            'User_id' => $user->id,  // ربط السوبرماركت بالمستخدم باستخدام user_id
            'SupermarketName' => $validated['SupermarketName'],
            'Location' => $validated['Location'],
            'ContactNumber' => $validated['ContactNumber'],
        ]);

        // تسجيل دخول المستخدم بعد الإنشاء
        FacadesAuth::login($user);

        // إعادة التوجيه إلى لوحة التحكم الخاصة بالسوبرماركت
        return redirect()->route('Dashborad', ['id' => $supermarket->id]);
    }

    // عملية تسجيل الدخول
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (FacadesAuth::attempt($validated)) {
            $request->session()->regenerate();
            
            $user = FacadesAuth::user(); // جلب المستخدم المسجل

            // التحقق مما إذا كان المستخدم هو سوبرماركت
            $supermarket = SuperMarket::where('User_id', $user->id)->first();
            
            if ($supermarket) {
                return redirect()->route('Dashborad', ['id' => $supermarket->id]);
            }

            // في حال عدم وجود سوبرماركت مرتبط بالحساب
            return redirect()->route('home'); // أو أي صفحة أخرى إذا لم يكن المستخدم تاجر
        }

        throw ValidationException::withMessages([
            'credentials' => 'عذرًا، بيانات تسجيل الدخول غير صحيحة',
        ]);
    }

    // عملية تسجيل الخروج
    public function logout(Request $request)
    {
        FacadesAuth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // عرض اختيار نوع المستخدم
    public function select_type_of_user(){
        return view('select_type_of_user');
    }
}


















