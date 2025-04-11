<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\SuperMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth as FacadesAuth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $validated = $request->validate([
            'username' => 'required|string|max:225',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['Role_id'] = 2;
        $user = User::create([            
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // تشفير كلمة المرور
            'Role_id' => $validated['Role_id'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'تم التسجيل بنجاح',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(Request $request)
    {
        // التحقق من البيانات المدخلة
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // محاولة تسجيل الدخول باستخدام البيانات المدخلة
        
        // التأكد من وجود المستخدم بعد التحقق
        $user = User::where('email', $validated['email'])->first();
    
        // إذا لم يتم العثور على المستخدم
        if (!$user) {
            return response()->json([
                'message' => 'المستخدم غير موجود',
            ], 404);
        }
    
        // إنشاء التوكن
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // استرجاع سوبر ماركت (إذا كان موجودًا)
        $supermarket = SuperMarket::where('User_id', $user->id)->first();
        
        // العودة بالاستجابة
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'user' => $user,
            'supermarket_id' => $supermarket ? $supermarket->id : null,
            'token' => $token
        ], 200);
    }
    
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200);
    }
}
