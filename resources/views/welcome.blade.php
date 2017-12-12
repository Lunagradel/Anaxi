<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Anaxi</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/styles.css') }}">
        <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link href="https://fonts.googleapis.com/css?family=Didact+Gothic|Lobster|Montserrat:600" rel="stylesheet">

    </head>
    <body>

      <div id="app">


        <desktop-nav></desktop-nav>

        <!-- every components belonging to a route, will be shown here on the page. -->
        <router-view></router-view>
        <sign-up></sign-up>

      </div>

      <script src="/js/app.js">

      </script>
    </body>
</html>
