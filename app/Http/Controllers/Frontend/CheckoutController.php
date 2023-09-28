<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Upazila;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function checkoutPage(){
        $carts = Cart::content();
        $total_price = Cart::subtotal();
        $districts = District::select('id','name','bn_name')->get();
        return view('frontend.layouts.pages.checkout',compact('carts','total_price','districts'));
    }

    public function loadUpazilaAjax($district_id){
        $upazilas = Upazila::where('district_id',$district_id)->select('id','name')->get();
        return response()->json($upazilas,200);
    }

    public function placeOrder(Request $request){
        dd($request->all());        
    }
}
