@extends('layouts.talks')
@section('talkscontent')

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
            
@endsection                      
