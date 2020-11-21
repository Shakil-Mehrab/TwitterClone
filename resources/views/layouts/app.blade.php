<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Twitter') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.User={
            id:{{optional(auth()->user())->id}},
            avatar:'{{optional(auth()->user())->avatar()}}'
        }
    </script>
</head>
<body>
    <div id="app">
        <main class="container mx-auto">
            @yield('content')
            <modals-container />
        </main>
    </div>
</body>
</html>
