<!DOCTYPE html>
<html lang="en" data-footer="true"
    data-override='{"attributes": {"placement": "vertical", "layout": "boxed" }, "storagePrefix": "ecommerce-platform"}'>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Sweets Shop | @yield('title')</title>
    <meta name="description" content="Ecommerce Dashboard" />

    @include('backend.layouts.inc.style')
</head>

<body>
    <div id="root">
      <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex">
            <!-- Logo Start -->
            @include('backend.layouts.inc.logo')
            <!-- Logo End -->

            <!-- User Menu Start -->
            @include('backend.layouts.inc.user_menu')
            <!-- User Menu End -->

            <!-- Icons Menu Start -->
            @include('backend.layouts.inc.icon')
            <!-- Icons Menu End -->

            <!-- Menu Start -->
            @include('backend.layouts.inc.menubar')
            <!-- Menu End -->

            <!-- Mobile Buttons Start -->
            @include('backend.layouts.inc.mobile-btn')
            <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
      </div>

      <main>
        <div class="container">
          @yield('content')
        </div>
      </main>
      <!-- Layout Footer Start -->
      @include('backend.layouts.inc.footer')
      <!-- Layout Footer End -->
    </div>

    @include('backend.layouts.inc.script')
</body>

</html>
