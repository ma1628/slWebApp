@extends('layout')

@section('content')
    {{ Breadcrumbs::render('home') }}
    @include('errorMassageDiv')
    <div class="container-fluid p-0">
        <br>
        <form action="{{ route('sloganList') }}" id="searchForm" method="get">
            <div class="form-group">
                <div class="mb-3">
                    <div class="dropdown">
                        <select class="form-control" form="searchForm" name="searchMethod">
                            <option value="phrase">キャッチコピーから探す</option>
                            <option value="writer">ライターから探す</option>
                            <option value="source">出典から探す</option>
                        </select>
                    </div>
                    <div class="input-group">
                    <input type="text" maxlength="{{config('const.SEARCH_CONDITION_MAX_STR_NUM')}}" class="form-control" form="searchForm" placeholder=""
                           aria-label="search"
                           aria-describedby="button-addon2" name="keyword">
                    <div class="">
                        <button class="btn btn-outline-secondary" type="submit" id="searchButton"><i
                                class="fas fa-search"></i></button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
        <a href="{{ route('tagList') }}">
            ＞＞タグからキャッチコピーを探す
        </a>
        <br><br>
        <button class="btn btn-outline-secondary btn-block mb-5"
                onclick="location.href='{{ route('inputSlogan') }}'">キャッチコピーを追加する
        </button>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link" id="rating"
                                            href="{{ route('home' ,['order'=> 'rating']) }}">評価順</a></li>
                    <li class="nav-item"><a class="nav-link" id="updated_at"
                                            href="{{ route('home' ,['order'=> 'updated_at']) }}">新着順</a></li>
                </ul>
            </div>
            <br>
            @include('slogansCardBody')
            <div class="d-flex justify-content-center">
                {{ $slogans->links() }}
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.rate_star_output').raty({
                readOnly: true,
                number: 5,
                precision: true,
                half: true,
                score: function () {
                    return $(this).children("span").text();
                },
                path: '{{ asset('ratyLib/images') }}'
            });

            {{--表示順をアクティブにする--}}
            @if (Request::is('updated_at'))
            $("#updated_at").addClass("active");
            @else
            $("#rating").addClass("active");
            @endif
        });
    </script>
@endsection
