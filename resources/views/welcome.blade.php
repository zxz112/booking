<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Booking</title>
        <script src="{{asset('js/app.js')}}" defer></script>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <index></index>
        </div>
    </body>
</html>
