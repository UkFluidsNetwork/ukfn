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
        <div class="col-lg-4 col-md-4 col-sm-4">
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
        <div class="col-lg-4 col-md-4 col-sm-4">
          <h1>What's On</h1>
            @foreach ($events as $event)
              <section class="page-header">
                <div class="line-break">
                  <div class="text-danger">
                    <strong class="panel-title">{{ $event['title'] }}</strong>
                  </div>
                    <div class="text-muted">{{ $event['start'] }}</div>
                    <div class="text-muted">{{ $event['subtitle'] }}</div>
                  </div>
                <p>{!! $event['description'] !!}</p>
               </section>
            @endforeach
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
          <h1>Tweets</h1>
            @foreach ($tweets as $key => $tweet)
              <section class="page-header">
                <div class="line-break">
                  <div class="text-primary">
                      <strong class="panel-title">{{ $tweet['user'] }}</strong>
                  </div>
                  <div class="text-muted">{{ $tweet['date'] }}</div>
                </div>
                <p class="line-break">{!! $tweet['text'] !!}</p>
                <a href="{{ $tweet['link'] }}" target="_blank">View tweet</a>
              </section>
            @endforeach
        </div>
      </div>
    </div>
      
@endsection
