<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Billing;
use App\Models\Product;
use App\Models\Upazila;
use App\Models\District;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Mail\PurchaseConfirm;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\OrderStoreRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\OrderPlaceStoreRequest;

class CheckoutController extends Controller
{
    public function checkoutPage()
    {
        $carts = Cart::content();
        $total_price = (float)Cart::subtotal();
        $districts = District::select(['id', 'name', 'bn_name'])->get();
        return view('frontend.layouts.pages.checkout', compact('carts', 'total_price', 'districts'));
    }

    public function loadUpazilaAjax($district_id)
    {
        $upazilas = Upazila::where('district_id', $district_id)
            ->select(['id', 'name','bn_name'])
            ->get();
        return response()->json($upazilas, 200);
    }

    public function PlaceOrder(OrderPlaceStoreRequest $request)
    {
        $billing = Billing::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
            'order_note' => $request->order_note,
            'address' => $request->address,
        ]);

        $cartSubtotal = Cart::subtotal(); 
        $cartSubtotal = str_replace(['$', ','], '', $cartSubtotal);
        $cartSubtotal = (float)$cartSubtotal;
        $order = Order::create([
            'user_id' => Auth::id(),
            'billing_id' => $billing->id,
            'sub_total' => Session::get('cupon')['cart_total'] ?? $cartSubtotal,
            'discount_amount' => Session::get('cupon')['discount_amount'] ?? 0,
            'cuponName' => Session::get('cupon')['cuponName'] ?? '',
            'total' => Session::get('cupon')['balance'] ?? (float)$cartSubtotal,
        ]);

        
        foreach (Cart::content() as $value) {
            OrderDetails::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'product_id' => $value->id,
                'product_qty' => $value->qty,
                'product_price' => $value->price,
            ]);
            Product::findOrFail($value->id)->decrement('product_stock',$value->qty);
        }

        Cart::destroy();
        Session::forget('cupon');

        $order = Order::whereId($order->id)->with(['billing','orderdetails'])->get();

        Mail::to($request->email)->send(new PurchaseConfirm($order));

        Toastr::success('Your ordered place successfully!!','Success');
        return redirect()->route('cart.page');
    }
}
