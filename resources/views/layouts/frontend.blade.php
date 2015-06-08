<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="{{ $description or 'The BooBoo Description' }}">
    <meta name="author" content="{{ $author or 'BooBoo'}}">
    <meta name="rating" content="{{ $rating or 0 }}" />
    <meta name="thumbnail" content="{{$ogimage or ''}}" />
    <meta name="twitter:card" content="{{$twittercard or ''}}">
    <meta name="twitter:site" content="@themasqline">
    <meta name="twitter:title" content="{{$title or ''}}">
    <meta name="twitter:description" content="{{$description or ''}}">
    <meta name="twitter:creator" content="{{$twittercreator or '@booboo'}}">
    <meta name="twitter:image" content="{{$ogimage or ''}}">
    <!-- Open Graph data -->
    <meta property="og:title" content="{{$title or ''}}" />
    <meta property="og:type" content="{{$ogtype or ''}}" />
    <meta property="og:url" content="{{$ogurl or ''}}" />
    <meta property="og:image" content="{{$ogimage or ''}}" />
    <meta property="og:description" content="{{$description or ''}}" />
    <meta property="og:site_name" content="Og" />
    <link rel="canonical" href="{{Request::root()}}">

    <title>{{$title or 'Rate Designs'}}</title>

    <link rel="stylesheet" href="/css/app.css">

    @yield('styles')
</head>
<body>
<header>
    @include('layouts.nav.top2')
</header>
    @yield('below-nav')
<main>
        <div class="container-fluid">

            <div id="globals"></div>
            @include('partials._flash')

            @yield('main')
        </div>

</main>
<footer class="pager-footer">
    @include('layouts.nav.footer')
   <script src="/js/app.js"></script>
    <script>

    </script>
    @yield('scripts')
</footer>
</body>

</html>