<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/css/app.css" rel="stylesheet">

    @if ($errors->has('username'))
        <script>
            window.loginError = '{{ $errors->first('username') }}'
        </script>
    @endif
</head>
<body>
    <div id="app"></div>
    <script src="/js/app.js"></script>
</body>
</html>
