<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tohoney - @yield('frontend_title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('frontend.layouts.inc.style')
</head>

<body>
    <!-- search-form here -->
    @include('frontend.layouts.inc.search')
    <!-- search-form here -->

    <!-- header-area start -->
    @include('frontend.layouts.inc.header')
    <!-- header-area end -->

    @yield('content')

    <!-- start social-newsletter-section -->
    @include('frontend.layouts.inc.newsletter')
    <!-- end social-newsletter-section -->

    <!-- .footer-area start -->
    @include('frontend.layouts.inc.footer')
    <!-- .footer-area end -->

    <!-- Modal area start -->
    @include('frontend.layouts.inc.modal')
    <!-- Modal area start -->
    @include('frontend.layouts.inc.script')
</body>

</html>
