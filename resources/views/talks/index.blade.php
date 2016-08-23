@extends('layouts.master')
@section('content')

          <h2 class='line-break'>Talks</h2>
  
          @foreach ($allTalks as $talk)
  
          <section class="page-header">
            <div>
              <p class="h4 text-primary">{{ $talk->title }}</p>
              <p>{{ $talk->series }}<p>
              <p class="line-break-top line-break-dbl">{{ $talk->speaker }}</p>
              
              <p class="text-muted">{{ $talk->start }}</p>
              <p>{{ $talk->venue }}</p>
              <p>{{ $talk->abstract }}</p>
            </div>
          </section>
            
            
            
            
          @endforeach
         
@endsection