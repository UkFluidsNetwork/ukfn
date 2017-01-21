@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>Edit talk no: {{ $talk->id }}</h2>

{!! Form::model($talk, [
'method' => 'PATCH',
'action' => ['TalksController@update', $talk->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('recordinguntil') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('title', $talk->title, ['class' => 'form-control','placeholder' => 'Talk title']) !!}
        @if ($errors->has('title'))
        <span class="text-danger">
          <span>{{ $errors->first('title') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('speaker') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('speaker', 'Speaker:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('speaker', $talk->speaker, ['class' => 'form-control','placeholder' => 'Speaker']) !!}
        @if ($errors->has('speaker'))
        <span class="text-danger">
          <span>{{ $errors->first('speaker') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('start') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('start', 'Start:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::date('start', $talk->start, ['class' => 'form-control','placeholder' => 'Talk start']) !!}
        @if ($errors->has('start'))
        <span class="text-danger">
          <span>{{ $errors->first('start') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('end') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('end', 'End:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::date('end', $talk->end, ['class' => 'form-control','placeholder' => 'Talk end']) !!}
        @if ($errors->has('end'))
        <span class="text-danger">
          <span>{{ $errors->first('end') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group'>
    {!! Form::label('teradekip', 'Teradek IP:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('teradekip', $talk->teradekip, ['class' => 'form-control','placeholder' => 'Teradek IP address']) !!}
    </div>
</div>
        
<div class='form-group'>
    {!! Form::label('streamingurl', 'Streaming URL:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('streamingurl', $talk->streamingurl, ['class' => 'form-control','placeholder' => 'Streaming URL']) !!}
    </div>
</div>
<div class='form-group'>
    {!! Form::label('recordingurl', 'Recording URL:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('recordingurl', $talk->recordingurl, ['class' => 'form-control','placeholder' => 'Recording URL']) !!}
    </div>
</div>
<div class='form-group {{ $errors->has('recordinguntil') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('recordinguntil', 'Recording Available Until:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-3'>
        {!! Form::date('recordinguntil', $talk->recordinguntil, ['class' => 'form-control','placeholder' => 'Recording Available Until Date']) !!}
        @if ($errors->has('recordinguntil'))
        <span class="text-danger">
          <span>{{ $errors->first('recordinguntil') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group line-break-dbl-top'>
    <div class=' col-lg-offset-3 col-lg-7'>
        {!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
    </div>    
</div>
{!! Form::close() !!}
@endsection