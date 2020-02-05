@extends('layouts.master')

@section('head')
<script type="text/javascript" src="{{ asset('js/vendor/jquery.easing.1.3.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link href="{{ elixir('css/gallery.css') }}" rel="stylesheet" type="text/css">
<style>
    #main-content {
        height: 100% !important;
    }
    #top-nav {
        z-index: 10 !important;
    }
    .col-lg-8, .col-lg-offset-2, .col-md-12, .col-sm-12, .col-xs-12 {
        width: 100%;
        margin-left: 0px;
    }
</style>
@endsection

@section('content')
@include ('flash.success')

<button onclick="location.href='/gallery'" type="button" class="btn btn-gallery {{ $type == 'all' ? 'active' : '' }}">All</button>
<button onclick="location.href='/gallery/videos'" type="button" class="btn btn-gallery {{ $type == 'videos' ? 'active' : '' }}">Videos</button>
<button onclick="location.href='/gallery/photos'" type="button" class="btn btn-gallery {{ $type == 'photos' ? 'active' : '' }}">Photos</button>
<button onclick="location.href='/gallery/interviews'" type="button" class="btn btn-gallery {{ $type == 'interviews' ? 'active' : '' }}">Interviews</button>

<div id="customScrollBox" class="content" style="height: 100%">
    <div id="toolbar"></div><div class="clear"></div>
    @foreach ($files as $file)
    @if ($file->filetype->shortname == 'Photo')
    <a href="/gallery/zoomify/{{ $file->id }}" class="thumb_link">
        <img src="{{ $file->path }}/{{ $file->name }}" title="{{ $file->title }}"
              alt="{{ $file->description }}" class="thumb" />
    </a>
    @elseif ($file->filetype->shortname == 'Video')
    <a href="/gallery/zoomify/{{ $file->id }}" class="thumb_link">
        <span class="play-layer"></span>
        <img src="{{ $file->getThumbnail() }}" title="{{ $file->title }}"
              alt="{{ $file->description }}" class="thumb" />
    </a>
    @endif
    @endforeach
      <p class="clear"></p>
    </div>
</div>

@endsection
