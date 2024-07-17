<!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus">
    <!--<![endif]-->
    <head>
        <link rel="stylesheet" href="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.min.css') }}">
        @include('partials.auth.head')
    </head>
    <body class="fl-bg">
        <div class="header">
            @stack('header-content')
        </div>

        <div class="swap-content">
            @stack('swap-content')
        </div>
        @auth
        @include('partials.manager.sidebar-menu')
        @endauth

        <div class="body">
            <div class="container">
                <div class="alert alert-danger alert-important p-2 js-isIE mb-2 text-center w-auto" style="display: none;">
                    <strong><i class="fa fa-exclamation-triangle fa-fw"></i> Please note that this website is not compatible with Internet Explorer. Please use another web browser.</strong>
                </div>
                    @if ($errors->any())
                        <div class="alert alert-danger alert-important">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @include('flash::custom-message')
                @yield('content')
            </div>
        </div>

        @stack('footer-content')
        @auth
            @include('partials.manager.footer')
        @endauth

        @stack('modals')
        <script type="text/javascript">
            window.FantasyLeague = @json(array_merge(
                FantasyLeague::getJavascriptVariables(), []
            ));
        </script>
        <script src="{{ asset('assets/frontend/js/app.js')}}"></script>
        <script src="{{ asset('themes/codebase/core.js') }}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/es6-promise/es6-promise.auto.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
        <script src="{{ mix('assets/frontend/js/owl-carousel.js')}}"></script>
        @stack('plugin-scripts')
        @routes
        <script src="{{ asset('js/manager/realtime.js') }}"></script>
        <script src="{{ asset('js/manager/global.js')}}"></script>
        @stack('page-scripts')
        @include('partials.google_analytics')
        @include('partials.facebook_pixel')
        @include('partials.twitter_pixel')
	@stack('page-analytics')

        <script type="text/javascript">
            $('div.js-isIE').hide();
            
            setTimeout(function(){

                var ua = window.navigator.userAgent;
                // var isIE = /MSIE|Trident|Edge/.test(ua);
                var isIE = /MSIE|Trident/.test(ua);

                if ( isIE ) {
                    //IE specific code goes here
                    $('div.js-isIE').show();
                }

            }, 1500);
        </script>

    </body>
</html>
