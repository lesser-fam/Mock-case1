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

            <div class="header__search">
                <input type="text" placeholder="なにをお探しですか？">
            </div>

            <ul class="header__nav">
                <li class="header__nav--list-first">
                @auth
                    <form class="header__nav--auth" method="POST" action="{{ route('logout') }}">
                    @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}">ログイン</a>
                @endguest
                </li>

                <li>
                @auth
                    <a class="header__nav--mypage" href="{{ route('mypage.index') }}">マイページ</a>
                @endauth
                @guest
                    <a class="header__nav--mypage" href="/login">マイページ</a>
                @endguest
                </li>

                <li>
                @auth
                <div class="header__nav--sell">
                    <a href="{{ route('items.create') }}">出品</a>
                </div>
                @endauth
                @guest
                <div class="header__nav--sell">
                    <a href="/login">出品</a>
                </div>
                @endguest
                </li>
            </ul>
        @endif
    </header>
    <div class="content">
            @yield('content')
    </div>
</body>
</html>