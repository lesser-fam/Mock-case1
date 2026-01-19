<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        
            <a href="{{ route('items.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>

        @if (!request()->routeIs('register', 'login'))
            <form class="header__search" action="{{ url('/') }}" method="GET">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="なにをお探しですか？">
                <input type="hidden" name="tab" value="{{ $tab ?? '' }}">
            </form>

            <ul class="header__nav">
                <li>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <button class="header__nav-item" type="submit">ログアウト</button>
                    </form>
                @endauth
                @guest
                    <a class="header__nav-item" href="{{ route('login') }}">ログイン</a>
                @endguest
                </li>

                <li>
                @auth
                    <a class="header__nav-item header__nav-item--link" href="{{ route('mypage.index') }}">マイページ</a>
                @endauth
                @guest
                    <a class="header__nav-item header__nav-item--link" href="{{ route('login') }}">マイページ</a>
                @endguest
                </li>

                <li>
                @auth
                    <a class="header__nav-item header__nav-item--sell" href="{{ route('items.create') }}">出品</a>
                @endauth
                @guest
                    <a class="header__nav-item header__nav-item--sell" href="{{ route('login') }}">出品</a>
                @endguest
                </li>
            </ul>
        @endif
    </header>
    
    @yield('content')
    
</body>
</html>