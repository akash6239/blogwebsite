<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegisterMail;
use Mail;
use Str;

class AdminController extends Controller
{
    public function signup()
    {
        return view("admin.auth.signup");
    }
    public function signupuser(Request $request)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'remember_token' => ['nullable'],
    ]);

    // Check for validation errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create the new user
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password); 
    $user->remember_token = Str::random(40); 
    $user->save();

    Mail::to($user->email)->send(new RegisterMail($user));

    return redirect()->route('admin.login')->with('success','created successfully');
}
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }else{
            return view('admin.auth.login');
        }
    }
    public function index()
    {
        return view('admin.pages.index');
    }

    public function loginuser(Request $request)
    {
        // return $request->all();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authentication logic here
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->withInput()->with('error','Either email or password is incorrect');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    
}
