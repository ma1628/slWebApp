@extends('layout')

@section('content')
    {{ Breadcrumbs::render('sloganListByTagSearch', $tag) }}
    <div class="container-fluid p-0">
        <br>
        <h3>
            タグ：#{{$tag->tag_name}} のキャッチコピー一覧
        </h3>
        <p>全{{$slogans->lastPage()}}ページ　{{$slogans->currentPage()}}ページ目を表示（約{{$slogans->total()}}件中）</p>
        <div class="card">
            @include('slogansCardBody')
            <div class="d-flex justify-content-center">
                {{ $slogans->appends($tag->tag_id)->links() }}
            </div>
        </div>
    </div>
@endsection
