@extends('layouts.master')
@section('content')
@include ('flash.success')

<div class="well responsive">
  <p>
    Fluid mechanics underpins many established and emerging UK industries as
    well as critical societal issues such as air pollution,
    energy consumption, climate science, biology and medicine.
    Fluid mechanics is particularly strong in the UK, with world-class
    activity at several dozen institutions, involving hundreds of
    scientists and engineers. These institutions and individuals need to work
    together in order to benefit from the recent trend towards funding
    a small number of large grants. If you have any questions or suggestions,
    please {{ Html::link('/contact', 'contact us') }}.
  </p>
  <div id="well-col-1">
    The aims of the UK Fluids Network are to:
    <ul>
        <li>
           develop cross-institution bottom-up research programs and proposals;
        </li>
        <li>
          promote links with researchers and organisations in Europe and beyond;
        </li>
        <li>
          provide resources to the research community worldwide;
        </li>
        <li>
           act as a broker between UK academics and industry.
        </li>
    </ul>
  </div>
  <div id="well-col-2">
    The UKFN funds:
    <ul>
        <li>Special Interest Groups (SIGs);</li>
        <li>Short Research Visits (SRVs);</li>
        <li>
            a website containing resources for all fluid mechanics researchers.
        </li>
    </ul>
  </div>
  <div id="well-col-3">
    We encourage you to join the network and to play a part by:
    <ul>
        <li>signing up for the monthly newsletter</li>
        <li>
           registering your expertise in our searchable database of researchers;
        </li>
        <li>joining a Special Interest Group by emailing the SIG leader;</li>
        <li>contributing talks or researcher resources.</li>
    </ul>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
      <h1>What's New</h1>
      @foreach ($news as $new)
      <section class="page-header">
        <div class="line-break">
          <div class="text-danger">
            <h4 class="panel-title strong line-height-default">
              {{ $new->title }}
            </h4>
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
            <h4 class="panel-title strong line-height-default">
              {{ $event->title }}
            </h4>
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
