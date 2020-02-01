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
            <div class="form-group">
                <label for="addPhrase">キャッチコピー</label>
                <textarea class="form-control form-control-lg" name="phrase" rows="3" form="addForm"
                          id="addPhrase">{{ old("phrase") }}</textarea>
            </div>
            <div class="form-group">
                <label for="addWriter">作者</label>
                <input type="text" class="form-control" id="addWriter" name="writer" form="addForm"
                       value="{{ old("writer") }}">
            </div>
            <div class="form-group">
                <label for="addSource">出典</label>
                <textarea class="form-control" name="source" form="addForm"
                          id="addSource">{{ old("source") }}</textarea>
            </div>
            <div class="form-group">
                <label for="addSupplement">その他補足</label>
                <textarea class="form-control" name="supplement" form="addForm"
                          id="addSupplement">{{ old("supplement") }}</textarea>
            </div>
            <label>タグを追加する</label>
            <br>
            <div class="mb-3" id="addedTags">
                <input type="hidden" form="addForm" id="tagNames" name="tagNames" value="">
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
            {{--Enterキーによるsubmit防止--}}
            <form id="addForm" action="{{ route('addSlogan') }}" onsubmit="return false;" method="post">
                {{ csrf_field() }}
                <button type="button" form="addForm" onclick="submit();" class="btn btn-outline-primary mb-5">キャッチコピーを追加する
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('textarea').autosize();

            // オートコンプリート
            $('#tag_name').keyup(function () {
                var query = $(this).val();
                if (query != '') {
                    // var _token = $('input[name="_token"]').val();
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

            // Enterキー押下でタグ追加
            $("#tag_name").keypress(function(e){
                if(e.which == 13){
                    $("#addPreTag").click();
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
                let erasedTagName = $(e.target).parent().text().slice( 0, -2 );
                alert(erasedTagName);
                $(e.target).parent().remove();
                let fixedTagNames = $('#tagNames').val().replace(erasedTagName, '');
                $('#tagNames').val(fixedTagNames);
            });
        });
    </script>




@endsection
