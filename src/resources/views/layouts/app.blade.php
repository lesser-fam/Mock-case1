<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/common.css">
    @yield('css')
</head>

<body>
    <header class="header">
        
            <a href="">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </a>
        
    </header>
    <div class="content">
            @yield('content')
    </div>
</body>
</html>