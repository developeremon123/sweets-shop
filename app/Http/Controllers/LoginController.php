<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage(){
        return view('backend.pages.auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['bail','required','email'],
            'password' => 'bail|required|string|min:4'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // login attempt and return error message
        if (Auth::attempt($credentials,$request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }else {
            return back()->withErrors([
                'email' => 'credentials not found'
            ])->onlyInput('email');
        }

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();

        
        return redirect()->route('admin.login');

    }
}
