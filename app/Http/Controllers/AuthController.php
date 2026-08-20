<?php
namespace App\Http\Controllers;
use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth; use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
 public function showLogin(){return view('auth.login');}
 public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required']);$remember=$r->boolean('remember');if(!Auth::attempt($data,$remember)){return back()->withErrors(['email'=>'Invalid email or password.'])->withInput();}$r->session()->regenerate();return redirect()->intended(route('home'));}
 public function showRegister(){return view('auth.register');}
 public function register(Request $r){$data=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:190|unique:users,email','country_code'=>'required|string|max:8','phone'=>'required|string|max:30','address'=>'nullable|string|max:500','city'=>'required|string|max:100','country'=>'required|string|max:100','zip_code'=>'required|string|max:20','password'=>['required','confirmed',Password::min(8)]]);$data['role']='user';$u=User::create($data);Auth::login($u);$r->session()->regenerate();return redirect()->route('home')->with('success','Account created successfully.');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect()->route('home');}
}
