<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="header__heading">
                <h1>Atte</h1>
            </div>
            @yield('link')
        </header>
        <div class="content">
            @yield('content')
        </div>
        <footer class="footer">
            <small class="company">Atte,inc.</small>
        </footer>
    </div>
</body>

</html>