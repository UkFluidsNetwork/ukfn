@extends('layouts.master')
@section('content')

  <div class="well">
    <h2 class="line-break">Welcome</h2>
    <p>
      The UK Fluids Network is an EPSRC-funded network of academic and industrial research groups, focused on innovative developments and applications in Fluid Mechanics. 
      Activities start in September 2016 and are funded for 3 years.
    </p>
    <p>
      The UKFN will fund {{ Html::link('/sig', 'Special Interest Group (SIG) meetings', ['title'=>'Special Interest Group (SIG)']) }},
      {{ Html::link('/srv', 'Short Research Visits (SRVs)', ['title'=>'Short Research Visits']) }},
      and a website containing resources for all fluid mechanics researchers.
    </p>
      <!--p>
        All UK-based fluid mechanics researchers, whether in academia or industry, are invited to <a href="register" title="Register">join.</a>
      </p-->
  </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4">
          <h1>What's New</h1>
            @foreach ($news as $new)
              <section class="page-header">
                <div class="line-break">
                  <div class="text-danger">
                      <strong class="panel-title">{{ $new['title'] }}</strong>
                  </div>
                  <div class="text-muted">{{ $new['start'] }}</div>
                </div>
                @if ($new['link'])
                <p class="line-break">{!! $new['description'] !!}</p>
                <a href="{{ $new['link'] }}">Read More</a>
                @else 
                <p>{!! $new['description'] !!}</p>
                @endif
               </section>
            @endforeach
        </div>
        <div class="col-lg-4">
          <h1>What's On</h1>
            @foreach ($events as $event)
              <section class="page-header">
                <div class="line-break">
                  <div class="text-danger">
                      <strong class="panel-title">{{ $event['title'] }}</strong>
                  </div>
                  <div class="text-muted">{{ $event['start'] }}{{ $event['subtitle'] }}</div>
                </div>
                <p>{!! $event['description'] !!}</p>
               </section>
            @endforeach
        </div>
        <div class="col-lg-4">
          <h1>Tweets</h1>
          <section class="page-header">
            <dl>
              @foreach ($tweets as $key => $tweet)
                <dt class="text-primary">{{ $tweet['date'] }}</dt>
                <dd>{!! $tweet['text'] !!}</dd>
                @if ($key < ($totalTweets -1))
                  <br>
                @endif
              @endforeach
            </dl>
          </section>
          <!--p class="read-more-wrapper">
            <a href="{{ url('https://twitter.com/UKFluidsNetwork') }}" class="btn btn-default text-uppercase" target="_blank">View more tweets <span class="glyphicon glyphicon-chevron-right"></span></a>
          </p-->
        </div>
      </div>
    </div>
      
@endsection
