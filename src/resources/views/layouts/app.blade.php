<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__title-area">
                <a href=" {{ route('items.index') }}">
                    <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}" alt="coachtech_logo">
                </a>
            </div>
            @if(View::hasSection('header-button'))
            <form class="header__search-form" action="{{ route('items.index') }}">
                <input class="header__search-input" type="search" name="keyword" value="{{ $keyword ?? request()->input('keyword') }}" placeholder="なにをお探しですか？">
            </form>
            <div class="header__nav">
                @auth
                <form class="header__nav-item" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="header__action-link" type="submit">ログアウト</button>
                </form>
                @endauth

                @guest
                <div class="header__nav-item">
                    <a class="header__action-link" href="/login">ログイン</a>
                </div>
                @endguest
                <div class="header__nav-item">
                    <a class="header__action-link" href="{{ route('mypage') }}">マイページ</a>
                </div>
                <div class="header__nav-item">
                    <a class="header__action-link--primary" href="{{ route('sell.create') }}">出品</a>
                </div>
            </div>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>