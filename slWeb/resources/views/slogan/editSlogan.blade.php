@extends('layout')

@section('content')
    {{ Breadcrumbs::render('editSlogan', $slogan) }}
    <div class="container-fluid p-0">
        @include('errorMassageDiv')
        <div class="border p-4">
            <input type="hidden" form="editForm" name="slogan_id" value="{{$slogan->id}}">
            <div class="form-group">
                <label for="editPhrase">キャッチコピー</label>
                <textarea class="form-control form-control-lg" name="phrase" rows="3" form="editForm"
                          maxlength="{{config('const.SLOGAN_MAX_INPUT_NUM')}}"
                          id="editPhrase">{{$slogan->phrase}}</textarea>
            </div>
            <div class="form-group">
                <label for="editWriter">作者</label>
                <input type="text" class="form-control" id="editWriter" name="writer" form="editForm"
                       maxlength="{{config('const.WRITER_MAX_INPUT_NUM')}}"
                       value="{{$slogan->writer}}">
            </div>
            <div class="form-group">
                <label for="editSource">出典</label>
                <textarea class="form-control" name="source" form="editForm"
                          maxlength="{{config('const.SOURCE_MAX_INPUT_NUM')}}"
                          id="editSource">{{$slogan->source}}</textarea>
            </div>
            <div class="form-group">
                <label for="editSupplement">その他補足</label>
                <textarea class="form-control" name="supplement" form="editForm"
                          maxlength="{{config('const.SUPPLEMENT_MAX_INPUT_NUM')}}"
                          id="editSupplement">{{$slogan->supplement}}</textarea>
            </div>
            <label for="tag_name">タグを編集する</label>
            <br>
            <div class="mb-3" id="addedTags">
            </div>
            <div class="input-group">
                <input type="text" maxlength="{{config('const.TAG_NAME_MAX_INPUT_NUM')}}"
                       name="tag_name" id="tag_name" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="addPreTag">タグを追加</button>
                </div>
            </div>
            <div id="tagList">
            </div>
            <br>
            <br>
            <form id="editForm" action="{{ route('updateSlogan') }}" onsubmit="return false;" method="post">
                {{ csrf_field() }}
                <button type="button" form="editForm" onclick="submit();" class="btn btn-outline-primary mb-5">編集を完了する
                </button>
            </form>
        </div>
    </div>

    <script>
        let jqxhr = null;
        $(document).ready(function () {

            $('textarea').autosize();

            {{--オートコンプリート--}}
            $('#tag_name').keyup(function () {
                if (jqxhr) {
                    jqxhr.abort();
                }
                let query = $(this).val();
                if (query != '') {
                    jqxhr = $.ajax({
                        url: "{{ route('searchTag') }}",
                        method: "GET",
                        data: {query: query},
                    }).done(function (returnData) {
                        if (returnData && $('#tag_name:focus')[0]) {
                            $('#tagList').fadeIn();
                            $('#tagList').html(returnData);
                        } else {
                            $('#tagList').fadeOut();
                        }
                    });
                }
            });

            $("#tag_name").keypress(function (e) {
                {{--Enterキー押下でタグ追加--}}
                if (e.which == 13) {
                    $("#addPreTag").click();
                }
            }).blur(function (e) {
                $('#tagList').fadeOut();
            });

            {{--タグ名入力--}}
            $(document).on('click', 'li.tag_li', function () {
                $('#tag_name').val($(this).text());
                $('#tagList').fadeOut();
                return false;
            });

            {{--タグ追加--}}
            $('#addPreTag').click(function () {
                let tagName = $('#tag_name').val();
                if (tagName === "") {
                    return false;
                }
                addTag(tagName);
                $('#tag_name').val('');
            });

            function addTag(tagName) {
                $('#addedTags').prepend('<div class=\"badge badge-pill badge-secondary\">#'
                    + tagName
                    + '<span class=\'erase\'>｜×</span>'
                    + '<input type=\"hidden\" form=\"editForm\" name=\"tagNames[]\" value=\"'
                    + tagName
                    + '\"></div>');
            }

            {{--バリデーションエラーの場合にタグも再表示させる--}}
            @if (session('oldTagNames'))
            @foreach(session('oldTagNames') as $oldTagName)
            addTag("{{ $oldTagName }}");
            @endforeach
            @else
            @forelse ($slogan->tags as $tag)
            addTag("{{$tag->tag_name}}");
            @empty
            @endforelse
            @endif

            {{--タグ削除--}}
            $(document).on('click', '.erase', function (e) {
                $(e.target).parent().remove();
            });
        });
    </script>
@endsection
