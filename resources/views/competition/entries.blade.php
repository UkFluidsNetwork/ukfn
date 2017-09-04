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

  <h2 class='line-break'>{{ $title }} Entries</h2>

  <div class="well">
    <p>
      The first UK Fluids Network photo and video competition has finished, and voting is now closed.
    </p>
    @if ($name === "photo")
    <p>
      Click <a href="/competition/winner/photos">here</a> to see the winner photo.
    </p>
    @elseif ($name === "video")
    <p>
      Click <a href="/competition/winner/videos">here</a> to see the winner video.
    </p>
    @endif
    <p>
  </div>

@if (false)
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
  <div class="well">
    @if ($name === "photo")
    <p>
      Below are the finalist {{ $name }} entries of the UK Fluids Network photo and video competition - click <a href="/competition/vote/videos">here</a> to vote for the finalist videos.
    </p>
    @elseif ($name === "video")
    <p>
      Below are the finalist {{ $name }} entries of the UK Fluids Network photo and video competition - click <a href="/competition/vote/photos">here</a> to vote for the finalist photos.
    </p>
    @endif
    <p>
      How to vote:
    </p>
    <ol type="a">
      @if ($name === "photo")
      <li>Review the photos by clicking on them to enlarge them.</li>
      @elseif ($name === "video")
      <li>Play the videos to review them.</li>
      @endif
      <li>
          Once you have chosen the best {{ $name }}, click on the "Vote" button next to it
      </li>
      <li>Enter your email address and confirm your vote</li>
    </ol>
    <p>N.B. Only one vote is accepted in each category.</p>
  </div>

@foreach ($entries as $entry)
<?php
if ($entry->file->filetype->shortname !== $title) {
  continue;
}
?>

<div class="row">
  <div class="col-sm-10">
    <div class="panel panel-default line-break-dbl">
        <div
           class="noborder list-group-item talk panel-body accordion-toggle">
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                {{$entry->name}}
            </div>
        </span>

        <span class="talks-speaker display-block"></span>
        <span class="display-block">
            {{$entry->description}}
        </span>
        </div>
        <div id="collapse-srv1" class="accordion-body padding">
            <p>
            @if ($entry->file->filetype->shortname === "Photo")
              <a href="#" data-target="#entry{{ $entry->id }}" data-toggle="modal">
                <img class="display" height="100"
                     src="{{$entry->file->path . "/" . $entry->file->name}}">
              </a>
            @elseif ($entry->file->filetype->shortname === "Video")
               <div class="embed-responsive embed-responsive-16by9">
                 <iframe class="embed-responsive-item"
                         src="{{$entry->file->path}}" scrolling="no"
                         frameborder="0" allowfullscreen></iframe>
               </div>
            @endif
            </p>
        </div>
        <div class="modal fade"
             id="entry{{ $entry->id }}" role="dialog"
             arial-labelledby="label-entry{{ $entry->id }}">
          <div class="modal-dialog" role="document" style="min-width: 90%">
            <div class="modal-content">
              <div id="body-entry{{ $entry->id }}" class="modal-body">
                  <img class="display" style="max-width: 99%"
                      src="{{$entry->file->path . "/" . $entry->file->name}}">
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="line-break-dbl">
      <span class="display-block">
        <button class="btn btn-default btn-vote"
                data-target="#vote{{ $entry->id }}" data-toggle="modal">
            Vote
        </button>
      </span>
    </div>
    <div class="modal fade"
         id="vote{{ $entry->id }}" role="dialog"
         arial-labelledby="label-vote{{ $entry->id }}">
      <div class="modal-dialog" role="document" style="min-width: 60%">
        <div class="modal-content">
         <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"
                  arial-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="label-srv1">
            {{ $entry->name }}
          </h4>
          </div>
          <div id="body-vote{{ $entry->id }}" class="modal-body">
            <p>
              Please enter your email address to place your vote.
              Only one vote is permited in each cateory (photos and videos)
              per person.
            </p>
             {!! Form::open(['action' => 'CompetitionController@vote',
                             'method' => 'POST',
                             'class' => 'form-inline']) !!}
             <input type="hidden" name="competitionentry_id"
                    id="competitionentry_id" value="{{ $entry->id }}">
             {!! Form::label('email', 'Email:',
                           ['class' => 'control-label col-lg-2 text-left']) !!}
             {!! Form::text('email', '', ['class' => 'form-control',
                            'placeholder' => 'your@email.com']) !!}
             {!! Form::submit('Vote',['class' =>'btn btn-default btn-lg2']) !!}
             {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endforeach
@endif

@endsection
