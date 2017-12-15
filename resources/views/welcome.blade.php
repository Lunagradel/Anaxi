<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Anaxi</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/styles.css') }}">
        <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Didact+Gothic|Lobster|Montserrat:600" rel="stylesheet">

    </head>
    <body>

      <div id="app">
          <desktop-nav></desktop-nav>
          @if ($loggedIn)
              <router-view></router-view>
          @else
              <h2> PLEASE LOGIN </h2>
              <login></login>
              <h2> OR SIGN UP</h2>
              <sign-up></sign-up>
          @endif



        <!-- every components belonging to a route, will be shown here on the page. -->



      </div>

      <script src="/js/app.js">

      </script>
    </body>
</html>
