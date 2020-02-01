@extends('layout')

@section('content')
    <nav aria-label="パンくずリスト">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tagList') }}">タグ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">キャッチコピー一覧</li>
        </ol>
    </nav>
    <div class="container-fluid">
    <br>
    <form action="{{ route('sloganList') }}" id="searchForm" method="get">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-append dropdown">
                    <select class="form-control" form="searchForm" id="searchMethod" name="searchMethod" >
                        <option value="phrase">キャッチコピーから探す</option>
                        <option value="writer">ライターから探す</option>
                        <option value="source">出典から探す</option>
                    </select>
                </div>
                <input type="text" class="form-control" form="searchForm" placeholder="" aria-label="Recipient's username"
                       aria-describedby="button-addon2" name="keyword" value="{{$params["keyword"]}}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit" id="searchButton"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </form>
    <p>全{{$slogans->lastPage()}}ページ　{{$slogans->currentPage()}}ページ目を表示（約{{$slogans->total()}}件中）</p>
    <div class="card">
    @include('slogansCardBody')
        <div class="d-flex justify-content-center">
            {{ $slogans->appends($params)->links() }}
        </div>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#searchMethod").val("{{$params["searchMethod"]}}");
        });
    </script>
@endsection
