@extends('layouts.master')
@section('content')
@include ('flash.success')

<div class="well">
  <h2 class="line-break">Welcome</h2>
  <p>
    The UK Fluids Network is an EPSRC-funded network of academic and industrial research groups, focused on innovative developments and applications in Fluid Mechanics. 
    Activities started in September 2016 and are funded for 3 years.
  </p>
  <p>
    The UKFN will fund {{ Html::link('/sig', 'Special Interest Group (SIG) meetings', ['title'=>'Special Interest Group (SIG)']) }},
    {{ Html::link('/srv', 'Short Research Visits (SRVs)', ['title'=>'Short Research Visits']) }},
    and a website containing resources for all fluid mechanics researchers.
  </p>
  <p>
    Registration is open to anyone interested in contributing to UKFN, to do so please {{ Html::link('/register', 'register here') }}.
  </p>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
      <h1>What's New</h1>
      @foreach ($news as $new)
      <section class="page-header">
        <div class="line-break">
          <div class="text-danger">
            <strong class="panel-title">{{ $new->title }}</strong>
          </div>
          <div class="text-muted">{{ $new->date }}</div>
        </div>
        @if ($new->link)
        <p class="line-break">{!! $new->description !!}</p>
        <a href="{{ $new->link }}">Read More</a>
        @else 
        <p>{!! $new->description !!}</p>
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
              @if ($event->new)
              <span class="label label-new label-ukfn-blue">New</span>
              @endif
            <strong class="panel-title">{{ $event->title }}</strong>
          </div>
          <div class="text-muted">{{ $event->date }}{{ $event->subtitle }}</div>
        </div>
        <p>{!! $event->description !!}</p>
      </section>
      @endforeach
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
      <h1>Tweets</h1>
      @include('pages.tweets')
    </div>
  </div>
</div>

@endsection
