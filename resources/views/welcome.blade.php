<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planifica App</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('images/brand/planifica-icon.svg') }}" type="image/png">

    <link rel="shortcut icon" href="{{ asset('images/brand/planifica-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/planifica-icon.svg') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/brand/planifica-icon.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/brand/planifica-icon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/brand/planifica-icon.svg') }}">

</head>
<body>
    <div id="app"></div>
</body>
</html>