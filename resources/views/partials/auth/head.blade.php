<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<title>{{ config('app.meta_title', 'Fantasy League') }}</title>
<meta name="description" content="{{ config('app.description') }}">
<meta name="author" content="aecor">
<!-- Open Graph Meta -->
<meta property="og:title" content="{{ config('app.meta_title', 'Fantasy League') }}">
<meta property="og:site_name" content="{{ config('app.name', 'Fantasy League') }}">
<meta property="og:description" content="{{ config('app.description') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="">
<meta property="og:image" content="">
<!-- Icons -->
<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
@include('public-website.partials.favicons')
<!-- END Icons -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Stylesheets -->
@stack('plugin-styles')
<link rel="stylesheet" id="css-main" href="{{ asset('/assets/frontend/css/app.css') }}">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:300,400,700" rel="stylesheet">
<!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
<!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
<!-- END Stylesheets -->
