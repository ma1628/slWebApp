@extends('layout')

@section('content')
    <nav aria-label="パンくずリスト">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tagList') }}">タグ一覧</a></li>
            <li class="breadcrumb-item active" aria-current="page">キャッチコピー一覧</li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-body">
            @forelse ($slogans as $slogan)
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>{{$slogan->phrase}}</h2>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            {{$slogan->rating}}<br>
                            @forelse ($slogan->tags as $tag)
                                <a href="#" class="badge badge-pill  badge-secondary">{{$tag->tag_name}}</a>
                                @if ($loop->index == 2)
                                    ...<br>
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
                        @endif
                    </div>
                </div>
            @empty
                <p>該当するキャッチコピーがありません</p>
            @endforelse
        </div>
    </div>
@endsection