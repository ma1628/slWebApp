@extends('layout')

@section('content')
    <div class="container-fluid">
        <br>
        <form>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-append dropdown">
                        <select class="form-control">
                            <option>キャッチコピーから探す</option>
                            <option>ライターから探す</option>
                            <option>出典から探す</option>
                        </select>
                    </div>

                    <input type="text" class="form-control" placeholder="" aria-label="Recipient's username"
                           aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">検</button>
                    </div>
                </div>
            </div>
        </form>

        <a href="{{ route('tagList') }}">
            ＞＞タグからキャッチコピーを探す
        </a>
        <br><br>

        <button class="btn btn-outline-secondary btn-block">全てのキャッチコピーを見る</button>
        <button class="btn btn-outline-secondary btn-block mb-5"
                onclick="location.href='{{ route('inputSlogan') }}'">キャッチコピーを追加する</button>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#">評価順</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">新着順</a></li>
                </ul>
            </div>
            <div class="card-body">
                @forelse ($slogans as $slogan)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2>{{$slogan->phrase}}</h2>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="rate_star_output"><span hidden>{{$slogan->rating}}</span></div>
                                @forelse ($slogan->tags as $tag)
                                    <a href="{{ route('sloganListByTagSearch',['$tag_id'=> $tag->id]) }}" class="badge badge-pill  badge-secondary">{{$tag->tag_name}}</a>
                                    @if ($loop->last)
                                        <br>
                                    @endif
                                    @if ($loop->index == 2)
                                        ...
                                        <?php break; ?>
                                    @endif
                                @empty
                                @endforelse
                                {!! nl2br(e(str_limit($slogan->writer."\r\n", 200))) !!}
                                {!! nl2br(e(str_limit("出典：".$slogan->source."\r\n", 200))) !!}
                                {!! nl2br(e(str_limit("その他補足：".$slogan->supplement."\r\n", 40))) !!}
                            </div>
                        </div>
                        <div class="card-footer">
                    <span class="mr-2">
                        <time class="text-secondary">更新日時 {{ $slogan->updated_at->format('Y.m.d') }}</time>
                    </span>
                            @if ($slogan->comments_count)
                                <a href="{{ route('sloganDetail',['slogan_id'=> $slogan->id]) }}"
                                   class="badge badge-primary">
                                    コメント {{ $slogan->comments_count }}件
                                </a>
                            @else
                                <a href="{{ route('sloganDetail',['slogan_id'=> $slogan->id]) }}"
                                   class="badge badge-primary">
                                    コメント0件
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p>キャッチコピーはまだありません。</p>
                @endforelse

                    <div class="d-flex justify-content-center">
                        {{ $slogans->links() }}
                    </div>


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
        });
    </script>
@endsection