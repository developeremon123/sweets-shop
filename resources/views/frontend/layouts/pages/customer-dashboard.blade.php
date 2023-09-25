@extends('frontend.layouts.master')

@section('frontend_title','Customer Dashboard')

@section('content')
    @include('frontend.layouts.inc.breadcrump',['pagename'=>'Customer'])
    <div class="col-lg-12 col-md-12 m-auto">
        <div class="card">
            <div class="card-header text-white bg-teal">
                <h4 class="card-title text-dark">Customer Name :{{ $user->name }}</h4>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection