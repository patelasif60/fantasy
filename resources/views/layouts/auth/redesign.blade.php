<!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus">
    <!--<![endif]-->
    <head>
        @include('partials.auth.head')
    </head>
    <body class="fl-bg">
        <div class="header">
            @stack('header-content')
        </div>

        <div class="swap-content">
            @stack('swap-content')
        </div>

        <div class="body">
            <div class="container">
                @yield('content')
            </div>
        </div>

        @stack('footer-content')

        @stack('modals')

        <script src="{{ mix('assets/frontend/js/app.js')}}"></script>
        <script src="{{ mix('assets/frontend/js/core.js') }}"></script>
        <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
        @stack('plugin-scripts')
        <script src="{{ asset('js/manager/global.js')}}"></script>
        @routes
        @stack('page-scripts')
    </body>
</html>
