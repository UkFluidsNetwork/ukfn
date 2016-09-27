@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add event</h2>

{!! Form::open(['action' => ['EventsController@create'], 'class' => 'form-horizontal']) !!}
<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', '', ['class' => 'form-control','placeholder' => 'The header of the event']) !!}
    @if ($errors->has('title'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('subtitle') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('subtitle', 'Subtitle:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('subtitle', '', ['class' => 'form-control','placeholder' => 'To appear next to the date']) !!}
    @if ($errors->has('subtitle'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'The body of the event']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('start') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('', 'DateTime:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::text('start', '', ['class' => 'form-control','placeholder' => 'The date and time the event takes place (yyyy-mm-dd h:m:s)']) !!}
    @if ($errors->has('start'))
    <span class="text-danger">
      <span>{{ $errors->first('start') }}</span>
    </span>
    @endif
  </div>
</div>
<div class=' col-lg-offset-2 col-lg-8'>
  <div class='form-group line-break-dbl-top'>
    {!! Form::submit('Add', ['class' => 'btn btn-default btn-lg2']) !!}
  </div>    
</div>
{!! Form::close() !!}
@endsection