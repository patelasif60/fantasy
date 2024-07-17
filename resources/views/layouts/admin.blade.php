<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>{{ config('app.name', 'Fantasy League') }}</title>
        <meta name="author" content="aecor">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('css/circular-std.css') }}">

        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        @include('public-website.partials.favicons')
        <!-- END Icons -->

        @stack('plugin-styles')
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
{{--        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/select2-bootstrap.min.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/admin/main.css') }}">
        @stack('page-styles')

    </head>
    <body>
        <div id="page-loader" class="bg-gd-sea show"></div>
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">

            @include('partials.admin.sidebar')

            @include('partials.admin.header')

            <main id="main-container">
                <div class="content">
                    {{ Breadcrumbs::view('partials.admin.breadcrumbs') }}
                    @include('flash::message')
                    @yield('content')
                </div>
            </main>

            @include('partials.admin.footer')

        </div>

        @stack('modals')

        <script src="{{ asset('themes/codebase/core.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/es6-promise/es6-promise.auto.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.all.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
        @stack('plugin-scripts')
        @routes
        <script src="{{ asset('js/admin/global.js') }}"></script>
        @stack('page-scripts')
    </body>
</html>
