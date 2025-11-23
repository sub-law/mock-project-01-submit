<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layout_login.css') }}" />
    @yield('styles')
</head>

<body>
    <header>
        <a href="{{ route('index') }}" class="header-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ">
        </a>
    </header>

    @yield('content')
</body>

</html>