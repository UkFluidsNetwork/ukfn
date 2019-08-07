
<link rel="stylesheet" type="text/css" href="{{ asset('css/vendor/zoomify.css') }}" media="all" />
<script src="{{ asset('js/vendor/zoomify.js') }}" async="async"></script>

<figure>
  @if ($file->filetype->shortname == 'Photo')
  <div id="image-zoom-wrapper">
      <img id="image-zoom" src="{{ $file->path }}/{{ $file->name }}" alt="{{ isset($file->competitionentries[0]) ? $file->competitionentries[0]->description : $file->name }}" />
  </div>
  @elseif ($file->filetype->shortname == 'Video')
  <video  controls muted autoplay loop>
          <source src="{{ $file->path }}" type="video/mp4">
          Your browser does not support the video tag.
  </video>
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
  @if ($file->filetype->shortname == 'Photo')
    <a href="https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}">https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}</a>
  @elseif ($file->filetype->shortname == 'Video')
    <a href="{{ $file->path }}">{{ $file->path }}</a>
  @endif
  </figcaption>
</figure>
