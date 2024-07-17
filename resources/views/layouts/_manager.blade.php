<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>{{ config('app.name', 'Fantasy League') }}</title>
        <meta name="author" content="aecor">
        <meta name="robots" content="noindex, nofollow">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @stack('sharing-meta')

        {{-- Fonts --}}
        <link rel="stylesheet" href="{{ asset('css/circular-std.css') }}">

        {{-- Icons --}}
        {{-- The following icons can be replaced with your own, they are used by desktop and mobile browsers --}}
        <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
        {{-- END Icons --}}

        {{-- Stylesheets --}}
        <link rel="stylesheet" href="{{ asset('css/circular-std.css') }}">
        @stack('plugin-styles')
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/admin/main.css') }}">
        @stack('page-styles')
        {{-- END Stylesheets --}}
    </head>
    <body>
        <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed">

            @include('partials.manager.sidebar')

            @include('partials.manager.header')

            {{-- Main Container --}}
            <main id="main-container">
                {{-- Header --}}
                <div class="bg-primary-dark">
                    <div class="content content-top">
                        <div class="row push">
                            <div class="col-md py-10 d-md-flex align-items-md-center text-center">
                                <h1 class="text-white mb-0">
                                    <span class="font-w300">@yield('page-title')</span>
                                    <span class="font-w400 font-size-lg text-white-op d-none d-md-inline-block">@yield('page-subtitle')</span>
                                </h1>
                            </div>
                            <div class="col-md py-10 d-md-flex align-items-md-center justify-content-md-end text-center">
                                <a href="{{route('manage.division.package.selection')}}" class="btn btn-alt-primary mr-2">
                                    <i class="fal fa-plus mr-5"></i> New League
                                </a>
                                {{-- <a href="{{route('manage.division.join.new.league')}}" class="btn btn-alt-primary">
                                    <i class="fal fa-plus mr-5"></i> Join League
                                </a> --}}
                            </div>

                        </div>
                    </div>
                </div>
                {{-- END Header --}}

                {{-- Page Content --}}
                <div class="bg-white">
                    {{ Breadcrumbs::view('partials.manager.breadcrumbs') }}
                    <div class="content">
                        @yield('content')
                    </div>
                </div>
                {{-- END Page Content --}}
            </main>
            {{-- END Main Container --}}
            @include('partials.manager.footer')
        </div>
        {{-- END Page Container --}}

        @stack('modals')

        <script src="{{ asset('themes/codebase/core.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.all.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/select2/js/select2.full.min.js') }}"></script>
        @stack('plugin-scripts')
        <script src="{{ asset('js/manager/global.js') }}"></script>
        @routes
        @stack('page-scripts')
        @include('partials.google_analytics')
        @include('partials.facebook_pixel')
        @include('partials.twitter_pixel')
    </body>
</html>
