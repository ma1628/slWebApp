@extends('layout')

@section('content')
    <div class="container-fluid">
        <br>
        <form action="{{ route('sloganList') }}" id="searchForm" method="get">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-append dropdown">
                        <select class="form-control" form="searchForm" name="searchMethod" >
                            <option value="phrase">キャッチコピーから探す</option>
                            <option value="writer">ライターから探す</option>
                            <option value="source">出典から探す</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" form="searchForm" placeholder="" aria-label="Recipient's username"
                           aria-describedby="button-addon2" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="searchButton"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>

        <a href="{{ route('tagList') }}">
            ＞＞タグからキャッチコピーを探す
        </a>
        <br><br>

        <button class="btn btn-outline-secondary btn-block mb-5"
                onclick="location.href='{{ route('inputSlogan') }}'">キャッチコピーを追加する</button>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link" id="rating" href="{{ route('top' ,['order'=> 'rating']) }}">評価順</a></li>
                    <li class="nav-item"><a class="nav-link" id="updated_at" href="{{ route('top' ,['order'=> 'updated_at']) }}">新着順</a></li>
                </ul>
            </div>
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
                score : function() {
                    return $(this).children("span").text();
                },
                path:  '{{ asset('ratyLib/images') }}'
            });

            // 表示順をアクティブにする
            @if (Request::is('updated_at'))
                $("#updated_at").addClass("active");
            @else
                $("#rating").addClass("active");
            @endif

        });
    </script>
@endsection
