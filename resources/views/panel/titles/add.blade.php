@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add title</h2>

{!! Form::open(['action' => ['TitlesController@create'], 'class' => 'form-horizontal']) !!}
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', '', ['class' => 'form-control','placeholder' => 'The title']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('shortname') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('shortname', 'Abbreviation:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('shortname', '', ['class' => 'form-control','placeholder' => 'The abbreviation of the title']) !!}
    @if ($errors->has('shortname'))
    <span class="text-danger">
      <span>{{ $errors->first('shortname') }}</span>
    </span>
    @endif
  </div>
</div>
<div class=' col-lg-offset-2 col-lg-8'>
  <div class='form-group line-break-dbl-top'>
    {!! Form::submit('Save', ['class' => 'btn btn-default btn-lg2']) !!}
  </div>    
</div>
{!! Form::close() !!}
@endsection