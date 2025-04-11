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
    public function showRegister(){
        return view('auth.register');
    }
    public function showLogin(){
        return view('auth.login');
    }
    public function Register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:225',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $validated['password'] = Hash::make($validated['password']); // تشفير كلمة المرور
        $validated['Role_id'] = 2;
    
        $user = User::create($validated);
        FacadesAuth::login($user);
    
        return view('select_type_of_user');
    }
    
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
        
        
            return redirect()->route('Dashborad', ['id' => $supermarket->id]);

        

        
    }

    throw ValidationException::withMessages([
        'credentials' => 'عذرًا، بيانات تسجيل الدخول غير صحيحة',
    ]);
}


    public function logout(Request $request){
        FacadesAuth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }




    public function select_type_of_user(){
      
        return view('select_type_of_user');
    }
}
