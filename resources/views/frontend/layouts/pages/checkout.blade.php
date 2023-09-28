@extends('frontend.layouts.master')

@push('front_style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('frontend_title', 'Checkout Page')

@section('content')
    @include('frontend.layouts.inc.breadcrump', ['pagename' => 'Checkout'])

    <!-- checkout-area start -->
    <div class="checkout-area ptb-100">
        <div class="container">
            <form action="{{ route('customer.placeOrder') }}" method="post">
                <div class="row">
                    @csrf
                    <div class="col-lg-8">
                        <div class="checkout-form form-style">
                            <h3>Billing Details</h3>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="name" class="form-label">First Name *</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter your name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="email" class="form-group">Email Address *</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your email address">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="phone" class="form-group">Phone No *</label>
                                    <input type="tel" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Enter your phone no">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="distict-id" class="form-label">District *</label>
                                    <select name="distict_id"
                                        class="form-select js-example-basic-single @error('district_id') is-invalid @enderror"
                                        id="district_id">
                                        <option value="" selected>Select your distict</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('distict_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="upazila-id" class="form-label">Town/Upzila *</label>
                                    <select name="upazila_id"
                                        class="form-select js-example-basic-single @error('upazila_id') is-invalid @enderror"
                                        id="upazila_id">
                                        <option value="" selected>Select your city</option>
                                    </select>
                                    @error('upazila_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="order-note" class="form-label">Order Notes </label>
                                    <textarea name="order_note" placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <label for="address" class="form-label">Your Address * </label>
                                    <textarea name="address" placeholder="Enter your address" class="form-control @error('address') is-invalid @enderror"></textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="order-area">
                            <h3>Your Order</h3>
                            <ul class="total-cost">
                                @foreach ($carts as $cart)
                                    <li>{{ $cart->name }} <span class="pull-right">ট {{ $cart->price * $cart->qty }}</span>
                                    </li>
                                @endforeach
                                @if (Session::has('cupon'))
                                    <li>Discount <span class="pull-right">ট
                                            {{ Session::get('cupon')['discount_amount'] }}</span></li>
                                    <li>Total<span class="pull-right">ট {{ Session::get('cupon')['balance'] }} <del
                                                class="text-danger">{{ Session::get('cupon')['cart_total'] }}</del></span>
                                    </li>
                                @else
                                    <li>Subtotal <span class="pull-right"><strong>ট {{ $total_price }}</strong></span>
                                    </li>
                                    <li>Total <span class="pull-right"><strong>ট {{ $total_price }}</strong></span></li>
                                @endif


                            </ul>
                            <ul class="payment-method">
                                <li>
                                    <div class="form-group">
                                        <input id="delivery" type="checkbox">
                                        <label for="delivery" class="form-label">Cash on Delivery</label>
                                    </div>
                                </li>
                            </ul>
                            <button>Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- checkout-area end -->
@endsection
@push('front_script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            $('#district_id').on('change', function() {
                let district_id = $(this).val();
                if (district_id) {
                    // Clear previous upazilas
                    $("#upazila_id").empty();

                    $.ajax({
                        url: "{{ url('/upazila/ajax') }}/" + district_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $("#upazila_id").append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        },
                    });
                } else {
                    // Clear options if no district is selected
                    $("#upazila_id").empty();
                }
            });
        });
    </script>
@endpush
