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

    public function cuponApply(Request $request){
        if (!Auth::check()) {
            Toastr::error('You must need to login first!');
            return redirect()->route('login.Page');
        }

        $check = Cupon::where('cuponName', $request->cuponName)->first();

        if (Session::get('cupon')) {
            Toastr::info('Already applied cupon!');
            return redirect()->back();
        }

        if ($check !=null) {
            $check_validity = $check->validity_till > Carbon::now()->format('d M Y');

            if ($check_validity) {
                Session::put('cupon',[
                    'CuponName' => $check->cuponName,
                    'cart_total' => Cart::subtotal(),
                    'discount_amount' => (Cart::subtotal() * $check->discount_amount)/100,
                    'balance' => Cart::subtotal()-(Cart::subtotal() * $check->discount_amount)/100,
                ]);
                Toastr::success('Cupon applied!!','Successfully!!');
                return back();
            }else{
                Toastr::error('Cupon date expire!!','Info!!');
                return back();
            }
        }else{
            Toastr::error('Invalid Cupon! Check, Empty Cart');
            return back();
        }
    }

    public function removeCupon($cupon_name){
        Session::forget();
        Toastr::success('Cupon removed','Successfully!!');
        return back();
    }
}
