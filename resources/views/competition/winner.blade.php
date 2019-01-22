@extends('layouts.master')
@section('head')
<style>
  .display {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
  .btn-vote {
    height: 242px;
    width: 60px;
  }

  @media only screen and (max-width: 850px) and (min-width:0px) {
    .btn-vote {
      width: 100%;
      height: 60px;
    }
  }
</style>
@endsection

@section('content')

  <h2 class='line-break'>{{ $title }} Competition Winner</h2>

  <div class="well">
    <p>
      The third UK Fluids Network photo and video competition has finished, and voting is now closed. The winning {{ $name }} is shown below.
    </p>
    @if ($name === "photo")
    <p>
      Click <a href="/competition/winner/videos">here</a> to see the winning video.
    </p>
    @elseif ($name === "video")
    <p>
      Click <a href="/competition/winner/photos">here</a> to see the winning photo.
    </p>
    @endif
    <p>
  </div>

@foreach ($entries as $entry)
<?php
if ($entry->file->filetype->shortname !== $title || $entry->created_at != "2018-12-05 10:00:00") {
 continue;
}
?>
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default line-break-dbl">
        <div
           class="noborder list-group-item talk panel-body accordion-toggle">
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                {{$entry->name}}
            </div>
        </span>
        <span class="text-muted display-block">
            <span class="display-table-cel bold">
                {{$entry->contestant}}
            </span>
        </span>
        <span class="text-muted display-block line-break">
            <span class="display-table-cel"> 
                {{$entry->institution->name}}
            </span>
        </span>

        <span class="talks-speaker display-block"></span>
        <span class="display-block">
            {{$entry->description}}
        </span>
        </div>
        <div id="collapse-srv1" class="accordion-body padding">
            <p>
            @if ($entry->file->filetype->shortname === "Photo")
                <img class="display" style="max-width: 99%;"
                     src="{{$entry->file->path . "/" . $entry->file->name}}">
            @elseif ($entry->file->filetype->shortname === "Video")
               <div class="embed-responsive embed-responsive-16by9">
                 <iframe class="embed-responsive-item"
                         src="{{$entry->file->path}}" scrolling="no"
                         frameborder="0" allowfullscreen></iframe>
               </div>
            @endif
            </p>
        </div>
    </div>
  </div>
</div>
@endforeach

@endsection
