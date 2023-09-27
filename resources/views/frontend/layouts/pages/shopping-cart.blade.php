@extends('frontend.layouts.master')

@section('frontend_title', 'Shopping-cart')

@section('content')
    @include('frontend.layouts.inc.breadcrump', ['pagename' => 'Shopping-Cart'])
    <!-- cart-area start -->
    <div class="cart-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td class="images"><img
                                            src="{{ asset('upload/product') }}/{{ $cart->options->product_image }}"
                                            alt=""></td>
                                    <td class="product"><a href="single-product.html">{{ $cart->name }}</a></td>
                                    <td class="ptice">ট {{ $cart->price }}</td>
                                    <td class="quantity cart-plus-minus">
                                        <input type="text" value="{{ $cart->qty }}" />
                                    </td>
                                    <td class="total">ট{{ $cart->price * $cart->qty }}</td>
                                    <td class="remove">
                                        <a href="{{ route('remove.cart', ['cart_id' => $cart->rowId]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    {{-- <li>
                                            <button>Update Cart</button>
                                        </li> --}}
                                    <li><a href="{{ route('shop.page') }}">Continue Shopping</a></li>
                                </ul>
                                <h3>Cupon</h3>
                                <p>Enter Your Cupon Code if You Have One</p>
                                <div class="cupon-wrap">
                                    <form action="{{ route('customer.cuponApply') }}" method="post">
                                        @csrf
                                        <input type="text" placeholder="Cupon Code" name="cuponName" class="form-control">
                                        <button type="submit">Apply Cupon</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                            <div class="cart-total text-right">
                                <h3>Cart Totals</h3>
                                <p>
                                    @if (Session::has('cupon'))
                                        <a href="{{ route('customer.removeCupon', 'cuponName') }}" class="p-1"><i
                                                class="fa fa-times"></i></a>
                                        <b>{{ Session::get('cupon')['cuponName'] }} is Applied</b>
                                    @endif
                                </p>
                                <ul>
                                    @if (Session::has('cupon'))
                                        <li><span class="pull-left">Discount
                                                :</span>ট {{ Session::get('cupon')['discount_amount'] }}</li>
                                        <li><span class="pull-left">Total :</span>ট{{ Session::get('cupon')['balance'] }}
                                            <del class="text-danger">ট {{ Session::get('cupon')['cart_total'] }}</del></li>
                                    @else
                                        <li><span class="pull-left">Discount :</span>ট{{ $subtotal }}</li>
                                        <li><span class="pull-left">Total :</span>ট{{ $subtotal }}</li>
                                    @endif
                                </ul>
                                <a href="checkout.html">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
