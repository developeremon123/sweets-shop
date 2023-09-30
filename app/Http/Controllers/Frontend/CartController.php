<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function cartPage(){
        $carts = Cart::content();
        $subtotal = Cart::subtotal();
        return view('frontend.layouts.pages.shopping-cart',compact('carts','subtotal'));
    }

    public function addToCart(Request $request){
        $product_slug = $request->product_slug;
        $order_qty = $request->order_qty;

        $product = Product::whereSlug($product_slug)->first();

        $product_cart = Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->product_price,
            'qty' => $order_qty,
            'options' => [
                'product_image' => $product->product_image
            ]
        ]);

        if ($product_cart) {
            Toastr::success('Product Added Cart');
            return back();
        }else {
            Toastr::error('Product Cannot Added Cart');
            return back();
        }
    }

    public function remove_cart($cart_id){
        Cart::remove($cart_id);
        Toastr::info('Product remove from cart!!');
        return back();
    }

    public function cuponApply(Request $request)
    {
        if (!Auth::check()) {
            Toastr::error('You must need to login first!!!');
            return redirect()->route('login.page');
        }

        $cuponName = $request->input('cuponName');

        $check = Cupon::where('cuponName', $cuponName)->first();

        if ($check == null) {
            Toastr::error('Invalid Action/Coupon! Check, Empty Cart');
            return redirect()->back();
        }

        if (Session::get('cupon')) {
            Toastr::error('Already applied coupon!!', 'Info');
            return redirect()->back();
        }

        // Check coupon validity
        $check_validity = $check->validity_till > Carbon::now()->format('Y-m-d');

        if (!$check_validity) {
            Toastr::error('Coupon Date Expired!!!', 'Info!!');
            return redirect()->back();
        }

        // Check if $check->discount_amount is numeric before using it in calculations
        $discountAmount = (float)$check->discount_amount;
        if (!is_numeric($discountAmount)) {
            Toastr::error('Invalid Coupon Discount Amount!', 'Info!!');
            return redirect()->back();
        }

        // Calculate discount and update session
        $cartSubtotal = Cart::subtotal(); 
        $cartSubtotal = str_replace(['$', ','], '', $cartSubtotal);
        $cartSubtotal = (float)$cartSubtotal;
        $discount = round(($cartSubtotal * $discountAmount) / 100);
        $balance = round($cartSubtotal - $discount);

        Session::put('cupon', [
            'cuponName' => $check->cuponName,
            'discount_amount' => $discount,
            'cart_total' => $cartSubtotal,
            'balance' => $balance
        ]);

        Toastr::success('Coupon Percentage Applied!!', 'Successfully!!');
        return redirect()->back();
    }

    public function removeCupon($coupon_name)
    {
        Session::forget('cupon');
        Toastr::success('Coupon Removed', 'Successfully!!');
        return redirect()->back();
    }

}
