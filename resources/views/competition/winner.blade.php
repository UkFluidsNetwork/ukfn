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

  <h2 class='line-break'>Winner {{ $title }}</h2>

  <div class="well">
    <p>
      The first UK Fluids Network photo and video competition has finished, and voting is now closed. The winner {{ $name }} is shown below.
    </p>
    @if ($name === "photo")
    <p>
      Click <a href="/competition/winner/videos">here</a> to see the winner video.
    </p>
    @elseif ($name === "video")
    <p>
      Click <a href="/competition/winner/photos">here</a> to see the winner photo.
    </p>
    @endif
    <p>
  </div>

  @if (Session::has('vote_ok'))
    <div class="alert alert-success">
        @if ($name === "photo")
        Thank you for your vote. You can also <a href="/competition/vote/videos">vote for the best video</a> if you haven't already.
        @elseif ($name === "video")
        Thank you for your vote. You can also <a href="/competition/vote/photos">vote for the best photo</a> if you haven't already.
        @endif
    </div>
  @elseif (Session::has('duplicate_vote'))
     <div class="alert alert-danger">
        @if ($name === "photo")
        You have already voted. If you haven't, you can still <a href="/competition/vote/videos">vote for the best video</a>.
        @elseif ($name === "video")
        You have already voted. If you haven't, you can still <a href="/competition/vote/photos">vote for the best photo</a>.
        @endif
     </div>
  @elseif ($errors->has('email'))
     <div class="alert alert-danger">
        The email entered is not valid.
     </div>
  @endif

@foreach ($entries as $entry)
<?php
if ($entry->file->filetype->shortname !== $title) {
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
                {{$entry->department}}, {{$entry->institution->name}}
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
