@section('head')
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

<a class="twitter-timeline" data-height="1500"
   href="https://twitter.com/{{ $twitter }}">
    Tweets by {{ $twitter }}
</a>
