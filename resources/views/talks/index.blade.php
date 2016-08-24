@extends('layouts.master')
@section('content')

          <h2 class='line-break'>Talks</h2>
  
          @foreach ($allTalks as $talk)
  
          <section class="page-header">
            <div>
              <p class="h4 text-danger">{{ $talk->title }}</p>
              <p class=""><b><i>{{ $talk->speaker }} </i></b></p>
              <div class="text-muted">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $talk->start)->format('l jS F') }}
                at {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $talk->start)->format('H:i') }}</div>
              <div class="text-muted line-break-dbl">{{ $talk->venue }}</div>
              
              
              
              
              
              
              <p class="line-break-dbl-top"> {{ $talk->abstract }}</p>
            </div>
          </section>
            
            
            
            
          @endforeach
         
@endsection