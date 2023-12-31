<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        return view('frontend.layouts.pages.customer-dashboard',compact('user'));
    }
}
