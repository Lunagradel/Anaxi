<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if ($loggedIn)
        <meta name="user" content="{{ $_SESSION["user_id"] }}">
        @endif
        <title>Anaxi</title>
        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/styles.css') }}">
        <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Didact+Gothic|Lobster|Montserrat:600" rel="stylesheet">
        <link rel="manifest" href="/manifest.json">
        {{--IOS WPA--}}
        <link rel="apple-touch-startup-image" href="{{ URL::asset('/img/icons/icon-512x512.png') }}">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="apple-touch-icon" href="{{ URL::asset('/img/icons/icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ URL::asset('/img/icons/icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ URL::asset('/img/icons/icon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="167x167" href="{{ URL::asset('/img/icons/icon-192x192.png') }}">

    </head>
    <body>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMF-q0qyWsEhxaZQAQLMuPcJbjVXn0Exg&libraries=places"></script>

      <div id="app">

          @if ($loggedIn)
            <desktop-nav userid="{{$_SESSION["user_id"]}}"></desktop-nav>
            <router-view :key="$route.fullPath"></router-view>
          @else
              <div class="login-container">
                  <div class="login-intro">
                      <span class="logo">
                          <h2> Anaxi </h2>
                      </span>
                      <span>Travel stuff and so forth</span>
                  </div>
                  <login></login>
                  <h3><span> OR </span></h3>
                  <sign-up></sign-up>
              </div>
          @endif
      </div>
      <script src="/js/app.js"></script>
      <script>

//      if('serviceWorker' in navigator) {
//          navigator.serviceWorker
//          .register('/sw.js')
//          .then(function() { console.log("Service Worker Registered"); });
//      }
      </script>
    </body>
</html>
