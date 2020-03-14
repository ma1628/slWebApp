@extends('layout')

@section('content')
    {{ Breadcrumbs::render('sloganList', $params["keyword"]) }}
    <div class="container-fluid p-0">
        <br>
        <form action="{{ route('sloganList') }}" id="searchForm" method="get">
            <div class="form-group">
                <div class="dropdown">
                    <select class="form-control" form="searchForm" id="searchMethod" name="searchMethod">
                        <option value="phrase">キャッチコピーから探す</option>
                        <option value="writer">ライターから探す</option>
                        <option value="source">出典から探す</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <input type="text" maxlength="50" class="form-control" form="searchForm" placeholder=""
                           aria-label="Recipient's username"
                           aria-describedby="button-addon2" name="keyword" value="{{$params["keyword"]}}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="searchButton"><i
                                class="fas fa-search"></i></button>
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
