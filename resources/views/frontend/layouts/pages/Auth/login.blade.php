@extends('frontend.layouts.master')

@section('frontend_title', 'Login')

@section('content')
    @include('frontend.layouts.inc.breadcrump', ['pagename' => 'Login '])

    <div class="account-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                    <form action="{{ route('login.store') }}" method="post">
                        @csrf
                        <div class="account-form form-style">
                            <div class="form-group">
                                <label for="email" class="form-label">User email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    name="email" placeholder="enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="enter password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit">Login</button>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('resigter.Page') }}">Or Create an Account</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
