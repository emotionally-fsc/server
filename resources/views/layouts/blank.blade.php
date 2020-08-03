<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body{
            background-color: white!important;
            margin: 15px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-weight: 800!important;
            color: black!important;
        }

        .smaller-charts {
            width: 30vw!important;
        }

        .bigger-charts {
            width: 67vw!important;
        }
    </style>
    @yield('head', '')

    <title>@yield('title') | Emotionally</title>
</head>
<body>
    @yield('body')

    <script src="{{asset(mix('/js/app.js'))}}" type="text/javascript"></script>

    @yield('scripts', '')
</body>
</html>
