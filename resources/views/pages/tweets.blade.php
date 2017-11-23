@section('head')
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

<div class="line-break line-break-dbl-top"></div>

<a class="twitter-timeline" data-tweet-limit="5"
   href="https://twitter.com/{{ $twitter }}"
   data-chrome="noscrollbar nofooter transparent noheader">
    Tweets by {{ $twitter }}
</a>
