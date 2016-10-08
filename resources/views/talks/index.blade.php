@extends('layouts.master')
@section('content')

            <h2 class='line-break'>Talks</h2>
            <div class="well">
                <p>
                    All the talks listed below are imported from the 
                    @foreach ($talksRSS as $talkRSS)
                        {{ Html::link($talkRSS['path'], $talkRSS['name'], ['target' => '_blank']) }}
                        @if ($talkRSS !== end($talksRSS)) 
                            and 
                        @else
                            RSS feed.    
                        @endif
                    @endforeach
                </p>
                <p>
                    To link another RSS feed to this page, please {{ Html::link('/contact', 'contact us') }}.
                </p>
            </div>
        
            @foreach ($talks as $talk)
        
            <section class="page-header">
                <div>
                    <span class="h4 text-danger display-block">
                        {{ $talk['title'] }}
                    </span>
                    <span class="talks-speaker display-block line-break">
                        {{ $talk['speaker'] }} 
                    </span>
                    <span class="text-muted display-block">
                        {{ $talk['when'] }}
                    </span>
                    <span class="text-muted line-break-dbl display-block">
                        {{ $talk['venue'] }}
                    </span>
                    <span class="line-break-dbl-top display-block line-break"> 
                        {{ $talk['abstract'] }}
                    </span>
                </div>
            </section>
            @endforeach
         
@endsection