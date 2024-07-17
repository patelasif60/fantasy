<meta name="description" content="{{ config('app.description') }}">
<meta name="author" content="aecor">
<!-- Open Graph Meta -->
<meta name="keywords" content="keywords,here">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="{{ config('app.meta_title', 'Fantasy League') }}" />
<meta property="og:description" content="{{ config('app.description') }}" />
<meta property="og:site_name" content="{{ config('app.name', 'Fantasy League') }}" />
<meta property="og:image" content="{{ asset('/frontend/img/banner/banner.png') }}" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:alt" content="{{ config('app.name', 'Fantasy League') }}" />
<meta property="og:image:width" content="1280" />
<meta property="og:image:height" content="1024" />
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:domain" value="{{ request()->getHttpHost() }}" />
<meta name="twitter:title" value="{{ config('app.meta_title', url()->current()) }}" />
<meta name="twitter:description" value="{{ config('app.description') }}" />
<meta name="twitter:image" content="{{ asset('/frontend/img/banner/banner.png') }}" />
<meta name="twitter:url" value="{{ url()->current() }}" />
