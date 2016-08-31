@extends('layouts.master')
@section('content')

<h2 class='line-break'>Talks</h2>
<div class="well">
  <p>
    All the talks listed below are imported from the 
    {{ Html::link('http://talks.cam.ac.uk/show/index/54169', 'Cambridge Fluids Network - fluids-related seminars') }} RSS feed.
  </p>
  <p>
    To link another RSS feed to this page, please {{ Html::link('/contact', 'contact us') }}.
  </p>
</div>
@foreach ($talks as $talk)
  <section class="page-header">
    <div>
      <p class="h4 text-danger">{{ $talk['title'] }}</p>
      <p class=""><b><i>{{ $talk['speaker'] }} </i></b></p>
      <div class="text-muted">{{ $talk['when'] }}</div>
      <div class="text-muted line-break-dbl">{{ $talk['venue'] }}</div>

      <p class="line-break-dbl-top"> {{ $talk['abstract'] }}</p>
    </div>
  </section>
@endforeach
         
@endsection