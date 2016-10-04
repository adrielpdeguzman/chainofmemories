<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>

    <app></app>

    <script src="/js/app.js"></script>
</body>
</html>
