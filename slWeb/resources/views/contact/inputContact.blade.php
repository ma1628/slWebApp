@extends('layout')

@section('content')
    <div class="container mt-4 p-0">
        @include('errorMassageDiv')
        <div class="border p-4">
            <form action="{{ route('sendContact') }}" onsubmit="return false;" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inquiry">お気軽にご意見・ご要望をお寄せください。</label>
                    <textarea class="form-control form-control-lg" maxlength="{{config('const.INQUIRY_MAX_INPUT_NUM')}}"
                              name="inquiry" rows="5">{{ old("inquiry") }}</textarea>
                </div>
                <button type="button" onclick="submit();" class="btn btn-outline-primary mb-5">送信する
                </button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('textarea').autosize();
        });
    </script>




@endsection
