<!doctype html>
<!--[if lte IE 9]>
<html lang="en" class="no-focus lt-ie10 lt-ie10-msg">
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="en" class="no-focus">
    <!--<![endif]-->
    <head>
        @include('public-website.partials.head')
    </head>
    <body>

        <div id="jsIsIE" class="bg-secondary incompatible-browser-alert js-isIE p-2 text-center w-auto">
            <strong>Please note that this website is not compatible with Internet Explorer. Please use another web browser.</strong>
        </div>

        @include('public-website.partials.header')

        @yield('content')

        @include('public-website.partials.footer')

        @stack('modals')

        <script async src="{{ mix('/frontend/js/app.js')}}"></script>
        @stack('plugin-scripts')

        @stack('page-scripts')

        <script type="text/javascript">
            let element = document.getElementById('jsIsIE');
            element.setAttribute("class", "bg-secondary js-isIE p-2 text-center w-auto d-none");
            
            setTimeout(function(){

                var ua = window.navigator.userAgent;
                // var isIE = /MSIE|Trident|Edge/.test(ua);
                var isIE = /MSIE|Trident/.test(ua);

                if ( isIE ) {
                    //IE specific code goes here
                    let element = document.getElementById('jsIsIE');
                    element.setAttribute("class", "bg-secondary incompatible-browser-alert js-isIE p-2 text-center w-auto");
                }

            }, 500);
        </script>
    </body>
</html>
