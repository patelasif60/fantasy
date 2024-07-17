<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
{{-- <title>{{ config('app.name', 'Fantasy League') }}</title> --}}
<title>{{ config('app.meta_title', 'Fantasy League') }}</title>
@include('public-website.partials.favicons')
@include('public-website.partials.meta')

<!-- END Icons -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Stylesheets -->
@stack('plugin-styles')
<link rel="stylesheet" href="{{ mix('/frontend/css/stylesheet.css') }}">
<!--[if lt IE 8]><!-->
<link rel="stylesheet" href="{{ asset('/frontend/ie7/ie7.css') }}">
<!--<![endif]-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:300,400,700" rel="stylesheet">
<!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
<!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
<!-- END Stylesheets -->
