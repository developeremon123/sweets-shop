<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerStoreRegister;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function resigterPage(){
        return view('frontend.layouts.pages.Auth.register');
    }

    public function register(CustomerStoreRegister $request){
         $validatedData = $request->validated();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('customer.dashboard');
        }
    }
}
