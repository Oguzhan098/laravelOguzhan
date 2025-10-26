<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">Görev Sistemi</a>

        <div>
            <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm mr-2">Kullanıcılar</a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-sm mr-2">Kategoriler</a>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-light btn-sm mr-3">Görevler</a>
            <a href="{{ route('activity.index') }}" class="btn btn-outline-light btn-sm mr-3">Activity Log</a>

        </div>


        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Giriş</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Kayıt Ol</a></li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Çıkış Yap
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    </div>
                </li>

            @endguest
        </ul>
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

    @yield('content')
</div>
</body>
</html>
