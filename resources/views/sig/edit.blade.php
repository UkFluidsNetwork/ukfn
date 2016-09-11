@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Edit: {{ $suggestion->suggestion }}</h2>

{!! Form::model($suggestion, [
'method' => 'PATCH',
'action' => ['SuggestionsController@update', $suggestion->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('suggestion') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('suggestion', 'SIG Title :', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::text('suggestion', $suggestion->suggestion, ['class' => 'form-control','placeholder' => 'Suggested SIG Title']) !!}
    @if ($errors->has('suggestion'))
    <span class="text-danger">
      <span>{{ $errors->first('suggestion') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Contact Name:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', $suggestion->name, ['class' => 'form-control','placeholder' => 'Your name']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('institution') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('institution', 'Organisation:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::text('institution', $suggestion->institution, ['class' => 'form-control','placeholder' => 'Your organisation name']) !!}
    @if ($errors->has('institution'))
    <span class="text-danger">
      <span>{{ $errors->first('institution') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('email', 'Email :', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::text('email', $suggestion->email, ['class' => 'form-control','placeholder' => 'e@mail.com']) !!}
    @if ($errors->has('email'))
    <span class="text-danger">
      <span>{{ $errors->first('email') }}</span>
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