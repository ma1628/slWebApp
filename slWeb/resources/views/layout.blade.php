<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laravel BBS</title>

    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"--}}
    {{--          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"--}}
    {{--          crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/style.css') }}">--}}
   {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>--}}

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>--}}
    {{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>--}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/jquery-autosize@1.18.18/jquery.autosize.min.js'></script>
    <script type="application/javascript" src="{{ asset('ratyLib/jquery.raty.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('ratyLib/jquery.raty.css') }}">

</head>
<body>
<header class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="{{ url('') }}">
            <h3>キャッチコピーBBS</h3>
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






{{--        @if (Route::has('login'))--}}
{{--            <div class="top-right links">--}}
{{--                @auth--}}
{{--                    <a href="{{ url('/home') }}">Home</a>--}}
{{--                    <p class="navbar-brand">{{Auth::user()->name}}さん</p>--}}
{{--                    <form method="post" name="form1" action="{{ route('logout') }}">--}}
{{--                        <button type="submit">aa</button>--}}
{{--                    </form>--}}
{{--                @else--}}
{{--                    <a href="{{ route('login') }}">ログイン</a>--}}
{{--                    <a href="{{ route('register') }}">会員登録</a>--}}
{{--                @endauth--}}
{{--            </div>--}}
{{--        @endif--}}
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
