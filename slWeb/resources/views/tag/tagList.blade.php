@extends('layout')

@section('content')
    <nav aria-label="パンくずリスト">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ホーム</a></li>
            <li class="breadcrumb-item active" aria-current="page">タグ一覧</li>
        </ol>
    </nav>
    <div class="container mt-4">
        <h2>タグ一覧</h2>
        @forelse ($tags as $tag)
            <a href="{{ route('sloganListByTagSearch',['$tag_id'=> $tag->id]) }}"
               class="badge badge-pill badge-secondary">{{$tag->tag_name}}({{ $tag->slogans_count}})</a>
        @empty
            <p>タグが存在しません</p>
        @endforelse
    </div>
@endsection