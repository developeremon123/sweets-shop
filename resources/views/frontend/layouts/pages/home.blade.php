@extends('frontend.layouts.master')

@section('frontend_title')
    Home Page
@endsection

@section('content')
    @include('frontend.layouts.pages.widgets.slider')
    @include('frontend.layouts.pages.widgets.featured')
    @include('frontend.layouts.pages.widgets.count_down')
    @include('frontend.layouts.pages.widgets.best-seller')
    @include('frontend.layouts.pages.widgets.latest-pro')
    @include('frontend.layouts.pages.widgets.terminal')
@endsection
