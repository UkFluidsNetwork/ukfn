@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add institution</h2>

{!! Form::open(['action' => ['InstitutionsController@create'], 'class' => 'form-horizontal']) !!}
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
<div class=' col-lg-offset-2 col-lg-8'>
  <div class='form-group line-break-dbl-top'>
    {!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
  </div>    
</div>
{!! Form::close() !!}
@endsection
