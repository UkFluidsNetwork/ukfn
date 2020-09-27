
<link rel="stylesheet" type="text/css" href="{{ asset('css/vendor/zoomify.css') }}" media="all" />
<script src="{{ asset('js/vendor/zoomify.js') }}" async="async"></script>

<figure>
  @if (strpos($file->type, 'image') === 0)
  <div id="image-zoom-wrapper">
      <img id="image-zoom" src="{{ $file->path }}/{{ $file->name }}" alt="{{ isset($file->competitionentries[0]) ? $file->competitionentries[0]->description : $file->name }}" />
  </div>
  @else
    @if ($file->getYoutubeId())
    <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $file->getYoutubeId() }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
    <video  controls muted autoplay loop>
            <source src="{{ $file->path }}" type="video/mp4">
            Your browser does not support the video tag.
    </video>
    @endif
  @endif
  <figcaption>
    <b>
      {{ $file->title }}
    </b>—{{ $file->author }}
    </br>
    </br>
    <i>
      {{ $file->description }}
    </i>
    </br>
    </br>
    @if (strpos($file->type, 'image') === 0)
    <a href="https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}">https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}</a>
  @else
    <a href="{{ $file->path }}">{{ $file->path }}</a>
  @endif
  </figcaption>
</figure>
