@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add institution</h2>

{!! Form::open(['action' => ['InstitutionsController@create'], 'class' => 'form-horizontal']) !!}
<div class='form-group {{ $errors->has('type') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('institutiontype_id', 'Type:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('institutiontype_id', $institutiontypes, 0, ['class' => 'selectpicker show-tick']) !!}
    @if ($errors->has('type'))
    <span class="text-danger">
      <span>{{ $errors->first('type') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Institution:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', '', ['class' => 'form-control','placeholder' => 'The name of the institution']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('shortname') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('shortname', 'Short name:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('shortname', '', ['class' => 'form-control','placeholder' => 'The short name of the institution']) !!}
    @if ($errors->has('shortname'))
    <span class="text-danger">
      <span>{{ $errors->first('shortname') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('url') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('url', 'Website:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('url', '', ['class' => 'form-control','placeholder' => 'The URL of the institution']) !!}
    @if ($errors->has('url'))
    <span class="text-danger">
      <span>{{ $errors->first('url') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('lat') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('lat', 'Latitude:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('lat', '', ['class' => 'form-control','placeholder' => 'The latitude of the institution']) !!}
    @if ($errors->has('lat'))
    <span class="text-danger">
      <span>{{ $errors->first('lat') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('lng') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('lng', 'Longitude:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('lng', '', ['class' => 'form-control','placeholder' => 'The longitude of the institution']) !!}
    @if ($errors->has('lng'))
    <span class="text-danger">
      <span>{{ $errors->first('lng') }}</span>
    </span>
    @endif
  </div>
</div>
<div class=' col-lg-offset-2 col-lg-8'>
  <div class='form-group line-break-dbl-top'>
    {!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
  </div>    
</div>
{!! Form::close() !!}
@endsection
