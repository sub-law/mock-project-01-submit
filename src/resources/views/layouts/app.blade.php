<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('styles')
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-left">
                <a href="{{ route('index') }}" class="header-logo">
                    <img src="{{ asset('images/logo.svg') }}" alt="COACHTECHロゴ">
                </a>
            </div>

            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="text" name="query" placeholder="何をお探しですか？" class="search-input">
            </form>

            <div class="header-right">
                @guest
                <a href="{{ route('login') }}" class="header-link">ログイン</a>
                <a href="{{ route('mypage') }}" class="header-link">マイページ</a>
                <a href="{{ route('sell.form') }}" class="header-button">出品</a>
                @else
                <form method="POST" action="{{ route('logout') }}" class="header-form">
                    @csrf
                    <button type="submit" class="header-link">ログアウト</button>
                </form>
                <a href="{{ route('mypage') }}" class="header-link">マイページ</a>
                <a href="{{ route('sell.form') }}" class="header-button">出品</a>
                @endguest
            </div>

        </div>
    </header>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    @yield('content')

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }
        }, 3000);
    </script>
</body>

</html>