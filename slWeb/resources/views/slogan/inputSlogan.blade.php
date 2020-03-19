@extends('layout')

@section('content')
    {{ Breadcrumbs::render('inputSlogan') }}
    <div class="container-fluid p-0">
        @include('errorMassageDiv')
        <div class="border p-4">
            <div class="form-group">
                <label for="addPhrase">キャッチコピー</label>
                <textarea class="form-control form-control-lg" name="phrase" rows="3" form="addForm"
                          maxlength="{{config('const.SLOGAN_MAX_INPUT_NUM')}}"
                          id="addPhrase">{{ old("phrase") }}</textarea>
            </div>
            <div class="form-group">
                <label for="addWriter">作者</label>
                <input type="text" class="form-control" id="addWriter" name="writer" form="addForm"
                       maxlength="{{config('const.WRITER_MAX_INPUT_NUM')}}"
                       value="{{ old("writer") }}">
            </div>
            <div class="form-group">
                <label for="addSource">出典</label>
                <textarea class="form-control" name="source" form="addForm"
                          maxlength="{{config('const.SOURCE_MAX_INPUT_NUM')}}"
                          id="addSource">{{ old("source") }}</textarea>
            </div>
            <div class="form-group">
                <label for="addSupplement">その他補足</label>
                <textarea class="form-control" name="supplement" form="addForm"
                          maxlength="{{config('const.SUPPLEMENT_MAX_INPUT_NUM')}}"
                          id="addSupplement">{{ old("supplement") }}</textarea>
            </div>
            <label for="tag_name">タグを追加する</label>
            <br>
            <div class="mb-3" id="addedTags">
            </div>
            <div class="input-group">
                <input type="text" maxlength="{{config('const.TAG_NAME_MAX_INPUT_NUM')}}"
                       id="tag_name" name="tag_name" class="form-control">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="addPreTag">タグを追加</button>
                </div>
            </div>
            <div id="tagList">
            </div>
            <br>
            <br>
            {{--Enterキーによるsubmit防止--}}
            <form id="addForm" name="addForm" action="{{ route('addSlogan') }}" onsubmit="return false;" method="post">
                {{ csrf_field() }}
                <button type="button" form="addForm" onclick="submitAddForm();" class="btn btn-outline-primary mb-5">
                    キャッチコピーを追加する
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

            {{--タグ入力--}}
            $(document).on('click', 'li.tag_li', function () {
                $('#tag_name').val($(this).text());
                $('#tagList').fadeOut();
                {{--処理を中断してスクロールを戻させない--}}
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
                    + '<input type=\"hidden\" form=\"addForm\" name=\"tagNames[]\" value=\"'
                    + tagName
                    + '\"></div>');
            }

            {{--バリデーションエラーの場合にタグも再表示させる--}}
            @if (session('oldTagNames'))
            @foreach (session('oldTagNames') as $oldTagName)
            addTag("{{ $oldTagName }}");
            @endforeach
            @endif

            {{--タグ削除--}}
            $(document).on('click', '.erase', function (e) {
                $(e.target).parent().remove();
            });

        });

        function submitAddForm() {
            if (jqxhr) {
                jqxhr.abort();
            }
            document.addForm.submit();
        }
    </script>
@endsection
