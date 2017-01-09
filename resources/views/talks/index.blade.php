@extends('layouts.talks')
@section('talkscontent')

            <h2 class='line-break'>Talks</h2>
            <div class="well">
                <p>
                    All the talks listed in this section are imported from the 
                    @foreach ($talksRSS as $talkRSS)
                        @if ($talkRSS !== end($talksRSS)) 
                            {{ Html::link($talkRSS->url, $talkRSS->longname, ['target' => '_blank']) }}, 
                        @else
                            and {{ Html::link($talkRSS->url, $talkRSS->longname, ['target' => '_blank']) }} RSS feeds.    
                        @endif
                    @endforeach
                </p>
                <p>
                    To link another RSS feed to this page, please {{ Html::link('/contact', 'contact us') }}.
                </p>
                <p>
                  Click on any of the talks in the "{{ $talksMenu['header'] }}" menu to see details of them, or click 
                  {{ Html::link('/talks/all', 'here') }} to see the full list of talks.
                </p>
            </div>
            
@endsection                      
