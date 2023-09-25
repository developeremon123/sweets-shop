<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    public function loginPage(){
        return view('frontend.layouts.pages.Auth.login');
    }
    
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|max:4',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credentials not found!'
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.Page');


    }
}
