@extends('layouts.talks')
@section('talkscontent')

        <section class="line-break-dbl">
            <h3 class="text-danger line-break">{{ $talk['title'] }}</h3>
            <span class="talks-speaker display-block">{{ $talk['speaker'] }}</span>
            <span class="display-block line-break">{{ $talk['aggregator'] }}</span>
            <span class="text-muted display-block">{{ $talk['when'] }}</span>
            <span class="text-muted line-break-dbl display-block">{{ $talk['venue'] }}</span>
            <span class="line-break-dbl-top display-block line-break">{{ $talk['abstract'] }}</span>

            @if ($talk['recordingurl'])

            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ $talk['recordingurl'] }}" scrolling="no"></iframe>
            </div>

            @endif
        </section>
            
@endsection
