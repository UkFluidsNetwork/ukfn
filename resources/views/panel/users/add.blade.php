@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add user</h2>

{!! Form::open(['action' => ['UsersController@create'], 'class' => 'form-horizontal']) !!}
<div class='form-group {{ $errors->has('group_id') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('group_id', 'Access group:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('group_id', $groups, 0, ['class' => 'selectpicker show-tick']) !!}
    @if ($errors->has('group_id'))
    <span class="text-danger">
      <span>{{ $errors->first('group_id ') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('title_id') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title_id', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('title_id', $titles, 0, ['class' => 'selectpicker show-tick']) !!}
    @if ($errors->has('title_id'))
    <span class="text-danger">
      <span>{{ $errors->first('title_id') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Name:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', '', ['class' => 'form-control','placeholder' => 'The name of the user']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('surname') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('surname', 'Surname:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('surname', '', ['class' => 'form-control','placeholder' => 'The surname of the user']) !!}
    @if ($errors->has('surname'))
    <span class="text-danger">
      <span>{{ $errors->first('surname') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('email', 'Email:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('email', '', ['class' => 'form-control','placeholder' => 'The email of the user']) !!}
    @if ($errors->has('email'))
    <span class="text-danger">
      <span>{{ $errors->first('email') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('orcidid') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('orcidid', 'ORCID iD:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('orcidid', '', ['class' => 'form-control','placeholder' => 'The ORCID iD of the user']) !!}
    @if ($errors->has('orcidid'))
    <span class="text-danger">
      <span>{{ $errors->first('orcidid') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('url') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('url', 'Website:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('url', '', ['class' => 'form-control','placeholder' => 'The personal website of the user']) !!}
    @if ($errors->has('url'))
    <span class="text-danger">
      <span>{{ $errors->first('url') }}</span>
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