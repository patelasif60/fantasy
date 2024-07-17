<!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus">
    <!--<![endif]-->
    <head>
        @include('partials.auth.head')
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    </head>
    <body class="fl-bg">

        @yield('content')

        @stack('footer-content')
        @include('partials.manager.footer')

        @stack('modals')

        <script src="{{ asset('assets/frontend/js/app.js')}}"></script>
        <script src="{{ asset('themes/codebase/core.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/es6-promise/es6-promise.auto.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.all.js')}}"></script>
        <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
        @stack('plugin-scripts')
        @routes
        <script src="{{ asset('js/manager/global.js')}}"></script>
        @stack('page-scripts')
        @include('partials.google_analytics')
        @include('partials.facebook_pixel')
        @include('partials.twitter_pixel')
    </body>
</html>
