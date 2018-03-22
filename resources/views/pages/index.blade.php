@extends('layouts.master')
@section('carousel')
    @include('pages.carousel')
@endsection
@section('content')
@include ('flash.success')

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
      <h1>What's New</h1>
      @foreach ($news as $key => $new)
      @if ($key === 0)
      <section class="page-header" style="margin-top: 2em;">
      @else
      <section class="page-header">
      @endif
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
              <span class="label label-new label-ukfn-blue
                           pull-left margin-right">
                  New
              </span>
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
      @if (empty($events))
      <div class="text-muted line-break-dbl-top">
          There are no future events to display.
      </div>
      @endif
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
      <h1>Tweets</h1>
      @include('pages.tweets')
    </div>
  </div>
</div>

@endsection
