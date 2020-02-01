
    <div class="card-body">
        @forelse ($slogans as $slogan)
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{$slogan->phrase}}</h2>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="rate_star_output"><span hidden>{{$slogan->rating}}</span></div>
                        @forelse ($slogan->tags as $tag)
                            <a href="{{ route('sloganListByTagSearch',['tag_id'=> $tag->id]) }}" class="badge badge-pill  badge-secondary">{{$tag->tag_name}}</a>
                            @if ($loop->index == 2)
                                ...
                                <br>
                                <?php break; ?>
                            @elseif($loop->last)
                                <br>
                            @endif
                        @empty
                        @endforelse
                        {!! nl2br(e(Str::limit("作者：".$slogan->writer."\r\n", 200))) !!}
                        {!! nl2br(e(Str::limit("出典：".$slogan->source."\r\n", 200))) !!}
                        {!! nl2br(e(Str::limit("その他補足：".$slogan->supplement."\r\n", 40))) !!}
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
                    @else
                        <a href="{{ route('sloganDetail',['slogan_id'=> $slogan->id]) }}"
                           class="badge badge-primary">
                            コメント0件
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p>該当するキャッチコピーが存在しません。</p>
        @endforelse
    </div>
