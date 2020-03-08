@extends('layout')

@section('content')
    {{ Breadcrumbs::render('sloganDetail', $slogan) }}
    @include('errorMassageDiv')
    <div class="container-fluid">
        <div class="border p-4">
            <h2>
                {!! nl2br(e(Str::limit($slogan->phrase."\r\n"))) !!}
            </h2>
            @forelse ($slogan->tags as $tag)
                <a href="{{ route('sloganListByTagSearch',['tag_id'=> $tag->id]) }}"
                   class="badge badge-pill badge-primary">{{$tag->tag_name}}</a>
            @empty
            @endforelse
            <br>
            <b>作者：</b>{!! nl2br(e($slogan->writer)."\r\n") !!}
            <b>出典：</b>{!! nl2br(e($slogan->source)."\r\n") !!}
            <b>その他補足：</b>{!! nl2br(e($slogan->supplement."\r\n")) !!}
            <a href="{{ route('editSlogan',['slogan_id'=> $slogan->id]) }}"
               class="btn btn-outline-primary mb-5">
                編集する
            </a>
            <section>
                <h2 class="h5 mb-4">
                    <div class="rate_star_output"><span hidden>{{$slogan->rating}}</span></div>
                    {{ $slogan->comments->count()}}件のコメント
                </h2>
                <button class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#comment-modal">
                    コメントする
                </button>
                @forelse($slogan->comments as $comment)
                    <div class="border-top p-4">
                        <div class="rate_star_output"><span hidden>{{$comment->rating}}</span></div>
                        投稿者：{{$comment->contributor_name}}<br>
                        <p class="mt-2">
                            {!! nl2br(e($comment->text)) !!}
                        </p>

                        <form name="deleteCommentForm" action="{{ route('deleteComment')}}" method="post">
                            <time class="text-secondary">
                                {{ $comment->created_at->format('Y.m.d H:i') }}
                            </time>
                            {{ csrf_field() }}
                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                            <input type="hidden" name="slogan_id" value="{{$slogan->id}}">
                            @auth
                                <button type="submit"><i class="fas fa-trash-alt"></i></button>
                            @endauth
                        </form>

                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>

    {{-- モーダルの配置 --}}
    <div class="modal" id="comment-modal" tabindex="-1">
        <div class="modal-dialog">
            {{-- モーダルのコンテンツ  --}}
            <div class="modal-content">
                {{-- モーダルのヘッダ --}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- モーダルのボディ --}}
                <form id="addForm" action="{{ route('addComment')}}" onsubmit="return false;" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="slogan_id" value="{{$slogan->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="text1">評価</label>
                            <div class="rate_star_input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contributor_name">投稿者名:</label>
                            <input type="text" id="contributor_name"
                                   maxlength="{{config('const.CONTRIBUTOR_NAME_MAX_INPUT_NUM')}}"
                                   class="form-control" name="contributor_name" value="匿名">
                        </div>
                        <div class="form-group">
                            <label for="text">コメント:</label>
                            <textarea id="comment" maxlength="{{config('const.COMMENT_MAX_INPUT_NUM')}}"
                                      class="form-control"
                                      name="text"></textarea>
                        </div>
                    </div>
                    {{-- モーダルのフッタ --}}
                    <div class="modal-footer">
                        <button type="button" onclick="submit();" form="addForm" class="btn btn-outline-primary mb-5">保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.rate_star_input').raty({
                readOnly: false,
                number: 5,
                scoreName: 'rating',
                path: '{{ asset('ratyLib/images') }}'
            });

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
        });
    </script>
@endsection
