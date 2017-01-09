@extends('layouts.talks')
@section('talkscontent')
<h2 class='line-break'>All Talks</h2>
         @foreach ($talks as $talk)
         
            <section class="page-header">
                <div>
                    <span class="h4 text-danger display-block">
                        {{ $talk->title }}
                    </span>
                    <span class="talks-speaker display-block line-break">
                        {{ $talk->speaker }} 
                    </span>
                    <span class="display-block line-break">
                        {{ $talk->aggregator->longname }}
                    </span>
                    <span class="text-muted display-block">
                        {{ $talk->when }}
                    </span>
                    <span class="text-muted line-break-dbl display-block">
                        {{ $talk->venue }}
                    </span>
                    <span class="line-break-dbl-top display-block line-break"> 
                        {{ $talk->abstract }}
                    </span>
                </div>
            </section>
            @endforeach
            
@endsection                      

