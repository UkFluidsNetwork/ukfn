@extends('layouts.master')
@section('content')

        <section class="line-break-dbl">
            <h3 class="text-danger line-break">{{ $talk->title }}</h3>
            <span class="talks-speaker display-block">{{ $talk->speaker }}</span>
            <span class="display-block line-break">{{ isset($talk->aggregator->longname) ? $talk->aggregator->longname : ""}}</span>
            <span class="text-muted display-block">{{ $talk->when }}</span>
            <span class="text-muted line-break-dbl display-block">{{ $talk->venue }}</span>
            <span class="line-break-dbl-top display-block line-breakdbl">{{ $talk->abstract }}</span>

            <div class="line-break-dbl-top">

                @if ($talk->displayRecording())
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $talk->recordingurl }}" scrolling="no" frameborder="0" allowfullscreen></iframe>
                    </div>
                @elseif ($talk->displayStream())
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="{{ $talk->streamingurl }}" scrolling="no" frameborder="0" allowfullscreen></iframe>
                    </div>
                @elseif ($talk->isStreamed() && $talk->isFuture())
                    <p>
                        <i class="glyphicon glyphicon-warning-sign"></i> Streaming will be made available 15 minutes before the start of the talk. 
                    </p>
                @endif

            </div>
        </section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "{{ $talk->title }}",
  "startDate": "{{ $talk->start }}",
  "location": {
    "@type": "Place",
    "name": "{{ $talk->venue }}",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "UK"
    }
  },
  "description": "{{ $talk->abstract }}",
  "endDate": "{{ $talk->end }}",
  "performer": {
    "@type": "Person",
    "name": "{{ $talk->speaker }}"
  },
  "image": "https://fluids.ac.uk/pictures/logo.png",
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "GBP",
    "availability": "InStock",
    "validFrom": "{{ $talk->created_at }}",
    "url": "{{ $talk->url }}"
  }
}
</script>

@endsection
