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
            <form action="{{ route('sendContact') }}" onsubmit="return false;" method="post">
                {{ csrf_field() }}
            <div class="form-group">
                <label for="inquiry">お気軽にご意見・ご要望をお寄せください。</label>
                <textarea class="form-control form-control-lg" name="inquiry" rows="5">{{ old("inquiry") }}</textarea>
            </div>
                <button type="button" onclick="submit();" class="btn btn-outline-primary mb-5">送信する
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
