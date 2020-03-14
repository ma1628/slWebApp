<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>キャッチコピーWiki</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slWeb.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.autosize.js') }}"></script>
    <script src="{{ asset('ratyLib/jquery.raty.js') }}"></script>
    <link href="{{ asset('ratyLib/jquery.raty.css') }}" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="{{ url('') }}">
            <h3>キャッチコピーWiki</h3>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navber" aria-controls="Navber" aria-expanded="false" aria-label="レスポンシブ・ナビゲーションバー">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="Navber">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <a class="navbar-brand" href="{{ url('inputContact') }}">
                    お問い合わせ
                </a>
            </ul>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                @auth
                    <form name="logout_form" method="POST" action="{{ route('logout') }}">
                        {{ csrf_field() }}
                        <a class="navbar-brand" href="javascript:logout_form.submit()">ログアウト</a>
                    </form>
                @else
                    <a class="navbar-brand" href="{{ route('login') }}">
                        管理者向け
                    </a>
                @endauth
            </ul>
        </div>
    </div>
</header>

<div>
    <!-- フラッシュメッセージ -->
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
