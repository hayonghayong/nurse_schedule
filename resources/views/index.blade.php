<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- app.css読み込み -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <title>Nurse Schedule</title>
    </head>

    <body>
        <!-- App.vueをマウント -->
        <div id="app">
        </div>
        
        <script>
        </script>
        <!-- app.js読み込み -->
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>