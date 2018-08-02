<style>
    .navbar {
        margin-bottom: 0px;
    }
    video {
        width:100%;
        margin-top: -6em;
    }
    .carousel-caption {
        background-color:rgba(0, 0, 0, 0.3);
    }
    .new-window {
       color: inherit;
    }
    .new-window:hover,
    .new-window:active {
       color: grey;
    }
</style>

<div id="carousel" class="carousel slide" data-ride="carousel"
     data-interval="false">
  <div class="carousel-inner" role="listbox">
    @foreach ($carousel as $key => $item)
    <div @if ($key == 0) class="item active" @else class="item" @endif>
      @if ($item->file->name == $item->file->path)
        <video  controls muted autoplay loop>
                 <source src="{{ $item->file->name }}" type="video/mp4">
                 Your browser does not support the video tag.
        </video>
      @else
      <img class="first-slide"
         src="{{ $item->file->path }}/{{ $item->file->name }}"
         alt="{{ $item->file->name }}">
      @endif
      <div class="container">
        <div class="carousel-caption">
          <h3>
              {{ $item->name }}
              <a class="new-window" title="Open in a new tab" target="_blank" href="@if($item->file->name == $item->file->path){{ $item->file->name }}@else{{ $item->file->path }}/{{ $item->file->name }}@endif">
                <span class="glyphicon glyphicon-new-window" aria-hidden="true">
                </span>
              </a>
          </h3>
          <h4>{{ $item->author }}</h4>
          <p>{{ $item->description }}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
