    <meta property="og:site_name" content="{{ config('app.name', 'Fantasy League') }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    
    <meta property="og:title" content="{{ $sharingData['title'] }}">
    <meta property="og:description" content="{{ $sharingData['description'] }}">
    <meta property="og:url" content="{{ $sharingData['url'] }}">
    <meta property="og:type" content="{{ $sharingData['type'] }}">
    <meta property="og:image" content="{{ $sharingData['image'] }}">

    <meta name="description" content="{{ $sharingData['twitter'] }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ config('app.name', 'Fantasy League') }}">
    <meta name="twitter:title" content="{{ $sharingData['title'] }}">
    <meta name="twitter:description" content="{{ $sharingData['description'] }}">
    <meta name="twitter:image" content="{{ $sharingData['image'] }}">
    <meta name="twitter:image:alt" content="{{ $sharingData['alt'] }}">