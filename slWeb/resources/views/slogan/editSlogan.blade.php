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
            <input type="hidden" form="editForm" name="id" value="{{$slogan->id}}">
            <div class="form-group">
                <label for="editPhrase">キャッチコピー</label>
                <textarea class="form-control form-control-lg" name="phrase" rows="3" form="editForm"
                          id="editPhrase">{!! nl2br(e(str_limit($slogan->phrase))) !!}</textarea>
            </div>
            <div class="form-group">
                <label for="editWriter">作者</label>
                <input type="text" class="form-control" id="editWriter" name="writer" form="editForm"
                       value="{!! nl2br(e(str_limit($slogan->writer))) !!}">
            </div>
            <div class="form-group">
                <label for="editSource">出典</label>
                <textarea class="form-control" name="source" form="editForm"
                          id="editSource">{!! nl2br(e(str_limit($slogan->source))) !!}</textarea>
            </div>
            <div class="form-group">
                <label for="editSupplement">その他補足</label>
                <textarea class="form-control" name="supplement" form="editForm"
                          id="editSupplement">{!! nl2br(e(str_limit($slogan->supplement))) !!}</textarea>
            </div>
            <label>タグを編集する</label>
            <br>
            <div class="mb-3" id="addedTags">
                @forelse ($slogan->tags as $tag)
                    <div class="badge badge-pill badge-secondary">#{{$tag->tag_name}}<span class="erase">｜×</span>
                    </div>
                @empty
                @endforelse
                    <input type="hidden" form="editForm" id="tagNames" name="tagNames" value="">
            </div>
            <div class="input-group">
                <input type="text" id="tag_name" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="addPreTag">タグを追加</button>
                </div>
            </div>
            <div id="tagList">
            </div>
            <br>
            <br>
            <form id="editForm" action="{{ route('updateSlogan') }}" method="post">
                {{ csrf_field() }}
                <button type="submit" form="editForm" name="submit" class="btn btn-outline-primary mb-5">編集を完了する
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('textarea').autosize();

            // 編集前のタグ名設定
            var beforeTagNames = "";
            @forelse ($slogan->tags as $tag)
                beforeTagNames = beforeTagNames + "#{{$tag->tag_name}}";
            @empty
            @endforelse
            $('#tagNames').val(beforeTagNames);

            // オートコンプリート
            $('#tag_name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    $.ajax({
                        url: "{{ route('searchTag') }}",
                        method: "GET",
                        data: {query: query},
                        success: function (data) {
                            if (data) {
                                $('#tagList').fadeIn();
                                $('#tagList').html(data);
                            } else {
                                $('#tagList').fadeOut();
                            }
                        }
                    });
                }
            });

            // タグ名入力
            $(document).on('click', 'li', function () {
                $('#tag_name').val($(this).text());
                $('#tagList').fadeOut();
            });

            // タグ追加
            $('#addPreTag').click(function () {

                //半角シャープは入力不可
                let tagName = $('#tag_name').val();
                if (tagName.indexOf('#') !== -1) {
                    alert("半角シャープ不要");
                    return;
                }

                tagName = '#' + tagName;
                $('#addedTags').prepend('<div class=\"badge badge-pill badge-secondary\">'
                    + tagName
                    + '<span class=\'erase\'>｜×</span></div>');

                let addedTagNames = $('#tagNames').val() + tagName;
                $('#tagNames').val(addedTagNames);

                $('#tag_name').val('');
            });

            // タグ削除
            $(document).on('click', '.erase', function (e) {
                alert($(e.target).parent().text());
                let aaa = $(e.target).parent().text();
                alert("かた"+typeof(aaa));
                let erasedTagName = aaa.slice(0, -2);
                // let erasedTagName = $(e.target).parent().text().slice( 0, -2 );
                $(e.target).parent().remove();
                alert(erasedTagName);
                let fixedTagNames = $('#tagNames').val().replace(erasedTagName, '');
                $('#tagNames').val(fixedTagNames);
            });
        });
    </script>




@endsection