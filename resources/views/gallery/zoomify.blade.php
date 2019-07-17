<style>
#image-zoom-wrapper {
  width: 100% !important;
  height: 100% !important;
  margin: 0 !important;
  background-color: #FFF !important;
}
figure {
  float: right;
  width: 100%;
  height: 80%;
  text-align: center;
  text-indent: 0;
  margin: 0;
  padding: 0;
}
figcaption {
  margin-top: 0.5em;
}
#backbutton {
  background-color: #e80c28;
  color: #fff;
  width: 25px;
  height: 25px;
  float: right;
  border-radius: 50%;
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  margin-top: -38.5%;
  margin-right: 10px;
  z-index: 1;
  position: relative;
}

#backbutton > a, #backbutton > a:visited, #backbutton > a:active {
  color: #fff;
  text-decoration: none;
}
</style>

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
      {{ isset($file->competitionentries[0]) ? $file->competitionentries[0]->name : $file->name }}
    </b>
    </br>
    </br>
    <i>
      {{ isset($file->competitionentries[0]) ? $file->competitionentries[0]->description : $file->name }}
    </i>
    </br>
    </br>
    @if (isset($file->competitionentries[0]->contestant))
    Credit: {{ $file->competitionentries[0]->contestant }}
    </br>
    @endif
  @if ($file->filetype->shortname == 'Photo')
    Resource URL: <a href="https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}">https://fluids.ac.uk{{ $file->path }}/{{ $file->name }}</a>
  @elseif ($file->filetype->shortname == 'Video')
    Resource URL: <a href="{{ $file->path }}">{{ $file->path }}</a>
  @endif
  </figcaption>
</figure>

<div id="backbutton">
  <a href="/gallery">x</a>
</div>
