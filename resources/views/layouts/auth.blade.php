<!doctype html>
<!--[if lte IE 9]>     <html lang="en" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

        <title>{{ config('app.name', 'Fantasy League') }}</title>

        <meta name="description" content="{{ config('app.description') }}">
        <meta name="author" content="aecor">

        {{-- Open Graph Meta --}}
        <meta property="og:title" content="{{ config('app.title', 'Fantasy League') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Fantasy League') }}">
        <meta property="og:description" content="{{ config('app.description') }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        {{-- Icons --}}
        {{-- The following icons can be replaced with your own, they are used by desktop and mobile browsers --}}
        <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
        {{-- END Icons --}}

        {{-- Stylesheets --}}
        <link rel="stylesheet" href="{{ asset('css/circular-std.css') }}">
        @stack('plugin-styles')
        <link rel="stylesheet" id="css-main" href="{{ asset('css/admin/main.css') }}">
        @stack('page-styles')
        {{-- END Stylesheets --}}
    </head>
    <body>

        <div id="page-container" class="main-content-boxed">
            <!-- For Javascript variable -->
            @include('partials.auth.header')

            {{-- Main Container --}}
            <main id="main-container">
                {{-- Page Content --}}
                <div class="bg-image" style="background-image: url('/img/auth-bg.jpeg');">
                    <div class="row mx-0 bg-white-op-90">
                        <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                            <div class="p-30 invisible" data-toggle="appear">
                                <a class="link-effect font-w700" href="{{ route('landing') }}">
                                    <span class="font-size-xl text-primary-dark">fantasy</span><span class="font-size-xl">league</span>
                                </a>
                                <p class="font-size-h3 font-w600 text-primary">
                                    The game that started it all.
                                </p>
                                <p class="font-italic text-gray-dark">
                                    Copyright &copy; <span class="js-year-copy">{{ date('Y') }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible" data-toggle="appear" data-class="animated fadeInRight">
                            <div class="content content-full">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END Page Content --}}
            </main>
            {{-- END Main Container --}}
        </div>
        {{-- END Page Container --}}

        @stack('modals')

        <script src="{{ asset('themes/codebase/core.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/pages/op_auth_signin.js') }}"></script>
        @stack('plugin-scripts')
        @routes
        <script src="{{ asset('js/auth/global.js') }}"></script>
        @stack('page-scripts')
        @include('partials.google_analytics')
        @include('partials.facebook_pixel')
        @include('partials.twitter_pixel')
    </body>
</html>
