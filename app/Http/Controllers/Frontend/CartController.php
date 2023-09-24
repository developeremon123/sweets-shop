<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
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
}
