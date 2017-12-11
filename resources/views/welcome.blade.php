<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Anaxi</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/styles.css') }}">

    </head>
    <body>

      <div id="app">

        <desktop-nav></desktop-nav>

        <!-- every components belonging to a route, will be shown here on the page. -->
        <router-view></router-view>

      </div>

      <script src="/js/app.js">

      </script>
    </body>
</html>
