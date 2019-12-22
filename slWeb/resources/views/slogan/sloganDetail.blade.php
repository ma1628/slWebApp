@extends('layout')

@section('content')
    <div class="container mt-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="border p-4">
            <h2>
                {!! nl2br(e(str_limit($slogan->phrase."\r\n", 200))) !!}
            </h2>
            @forelse ($slogan->tags as $tag)
                <a href="#" class="badge badge-pill  badge-primary">{{$tag->tag_name}}</a>
            @empty
            @endforelse
            <br>
            {!! nl2br(e(str_limit($slogan->writer."\r\n", 200))) !!}
            {!! nl2br(e(str_limit("出典：".$slogan->source."\r\n", 200))) !!}
            {!! nl2br(e(str_limit("その他補足：".$slogan->supplement."\r\n", 200))) !!}
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
                        <time class="text-secondary">
                            {{ $comment->created_at->format('Y.m.d H:i') }}
                        </time>
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>

    <!-- 2.モーダルの配置 -->
    <div class="modal" id="comment-modal" tabindex="-1">
        <div class="modal-dialog">
            <!-- 3.モーダルのコンテンツ -->
            <div class="modal-content">
                <!-- 4.モーダルのヘッダ -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{--                    <h4 class="modal-title" id="modal-label">ダイアログ</h4>--}}
                </div>
                <!-- 5.モーダルのボディ -->
                <form id="addForm" action="{{ route('addComment')}}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="slogan_id" value="{{$slogan->id}}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="text1">評価</label>
                            <div class="rate_star_input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text1">投稿者名:</label>
                            <input type="text" id="contributor_name" class="form-control" name="contributor_name"
                                   value="匿名">
                        </div>
                        <div class="form-group">
                            <label for="textarea1">コメント:</label>
                            <textarea id="comment" class="form-control" name="text"></textarea>
                        </div>
                    </div>
                    <!-- 6.モーダルのフッタ -->
                    <div class="modal-footer">


                        <button type="submit" form="addForm" name="submit" class="btn btn-outline-primary mb-5">保存
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
        });
    </script>
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
    <script>
        $(document).ready(function () {
            $('#tag_name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    // var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('searchTag') }}",
                        method: "GET",
                        data: {query: query},
                        success: function (data) {
                            $('#tagList').fadeIn();
                            $('#tagList').html(data);
                        }
                    });
                }
            });

            $(document).on('click', 'li', function () {
                $('#tag_name').val($(this).text());
                $('#tagList').fadeOut();
            });

            $('#addPreTag').click(function () {
                let tagName = $('#tag_name').val();
                $('#addedTags').prepend('<span class="badge badge-pill badge-primary preAddedTag">' + tagName + '<span class=\'erase\'>｜×</span>\'</span>');
            })

            $(".preAddedTag").click(function (e) {
                if ($(e.target).hasClass("erase")) {
                    alert(2);
                    // $(this).unwrap();
                    $(e).remove();
                } else {
                    //普通の動作
                }
            });

        });
    </script>




@endsection