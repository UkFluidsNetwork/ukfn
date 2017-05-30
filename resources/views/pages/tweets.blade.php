@if (!empty($tweets))
    @foreach ($tweets as $tweet)
    <section class="page-header">
        <div class="line-break">
            <div class="text-primary">
                <strong class="panel-title">
                  <a href="{{ $tweet->userUrl }}" target="_blank">{{ $tweet->user }}</a>
                </strong>
            </div>
            <div class="text-muted">{{ "@" . $tweet->username }}</div>
            <div class="text-muted">{{ $tweet->date }}</div>
        </div>
        <p class="line-break">{!! $tweet->text !!}</p>
        @if (isset($tweet->media))
            @foreach ($tweet->media as $media)
                @if ($media->type === "photo")
                    <p class="line-break">
                        {{ HTML::image($media->url, '', ['class' => 'thumb']) }}
                    </p>
                @endif
            @endforeach
        @endif
        <a href="{{ $tweet->link }}" target="_blank">View tweet</a>
    </section>
    @endforeach
@else
    <div class="text-muted">No tweets to show</div>
@endif
