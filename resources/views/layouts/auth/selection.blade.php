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
    <body class="full-height">
        <div class="auth-area">

            <div id="jsIsIE" class="bg-tertiary incompatible-browser-alert js-isIE p-2 text-center w-auto" style="display: none;">
                <strong class="bg-transparent">Please note that this website is not compatible with Internet Explorer. Please use another web browser.</strong>
            </div>

            <div class="header-logo-wrapper text-center text-md-left py-3">
                <div class="container">
                    <a class="d-inline-block" href="">
                        <div class="fl-white-logo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.26 86">
                                <defs><style>.stars{fill:#fff;}.fl-el{fill:#fff;}</style></defs>

                                <g id="Layer_2" data-name="Layer 2">
                                    <g id="Logo">
                                        <path class="stars" d="M21.22,44.17,26.48,30.6l13.57,5.31-5.7,2.46-5-2-2.24,5.77,8.08,3.16-1.45,3.75Zm42.29-16-14,36.11L60,68.3l0,.08-5.17,2.23-11-4.21L60.08,24.46c-.38-.36-.77-.71-1.17-1.06L42.43,65.87l-.52,1.35,1.37.53,9.58,3.67-5.67,2.45L35.63,69.42,54.7,20.27A35.64,35.64,0,0,0,5,68.65L22.61,23.37,47,32.9l-5.1,2.2-16.3-6.38L8.34,73.29c.35.42.72.83,1.09,1.24l11.26-29,12.56,4.89-1.42,3.65L23.75,50.9,13.21,78.06a35.63,35.63,0,0,0,50.3-49.88"/><polyline class="fl-el" points="25.07 5.44 27.94 3.37 24.4 3.37 23.31 0 22.22 3.37 18.68 3.37 21.55 5.44 20.44 8.81 23.31 6.72 26.18 8.81 25.07 5.44"/><polyline class="fl-el" points="37.24 5.44 40.11 3.37 36.57 3.37 35.48 0 34.39 3.37 30.86 3.37 33.72 5.44 32.62 8.81 35.48 6.72 38.35 8.81 37.24 5.44"/>
                                        <polyline class="fl-el" points="49.42 5.44 52.28 3.37 48.74 3.37 47.65 0 46.56 3.37 43.03 3.37 45.89 5.44 44.79 8.81 47.65 6.72 50.52 8.81 49.42 5.44"/>
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
            <div class="auth-area-content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
        {{-- <div class="auth-area">
            <div class="auth-area-bg">
                <div class="lazyload area-hero-bg" style="background-image: url('{{ asset('assets/frontend/img/auth/bg-thumb.jpg')}}')" data-src="{{ asset('assets/frontend/img/auth/bg.jpg')}}" /></div>
                <div class="area-bg">
                    <img class="lazyload" src="{{ asset('assets/frontend/img/auth/bg-thumb.jpg')}}" data-src="{{ asset('assets/frontend/img/auth/bg.jpg')}}" alt="">
                </div>
            </div>
            <div class="auth-area-content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div> --}}

        @stack('modals')

        <script src="{{ asset('assets/frontend/js/app.js')}}"></script>
        <script src="{{ asset('themes/codebase/js/plugins/sweetalert2/sweetalert2.all.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("body").addClass("full-height");
            });
        </script>

        @stack('plugin-scripts')
        @routes
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

            }, 500);
        </script>
    </body>
</html>
