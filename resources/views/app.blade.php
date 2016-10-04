<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>

    <div id="app">
        <h1>Chain of Memories</h1>
        <router-link to="/">Home</router-link>
        <router-link to="/journals">Journals</router-link>

        <router-view></router-view>
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
