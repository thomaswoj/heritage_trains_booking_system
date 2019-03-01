<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    <title>@if(isset($page_title)) {{ $page_title }} @else {{ config('app.name', 'Laravel') }} @endif</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="app-container">
            <header class="app-header">
                <h2>The Heritage Train Co.</h2>
                <div class="nav-right">
                    @if(request()->route()->getName() === 'booking.index')
                        <language-select></language-select>
                    @endif
                    <div class="logo-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c8/Mogul_steam_locomotive_icon.svg/2000px-Mogul_steam_locomotive_icon.svg.png">
                    </div>
                </div>
            </header>
            @yield('content')
            <footer class="booking-footer flex-column-center">&copy; Heritage Trains {{ date('Y') }}</footer>
        </div>
    </div>
</body>
</html>
