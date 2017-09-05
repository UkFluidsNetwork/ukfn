@extends('layouts.admin')
@section('head')
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection
@section('admincontent')

<h2 class='line-break'>New SRV</h2>


{!! Form::model($srv, [
'method' => 'PATCH',
'action' => ['SrvsController@update', $srv->id],
'class' => 'form-horizontal'
]) !!}

<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', $srv->name, ['class' => 'form-control',
                                 'placeholder' => 'Title']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('visitor') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('visitor', 'Visitor:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('visitor', $srv->visitor, ['class' => 'form-control',
                                 'placeholder' => 'Name of the visitor']) !!}
    @if ($errors->has('visitor'))
    <span class="text-danger">
      <span>{{ $errors->first('visitor') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('institution_id') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('institution_id', 'Institution:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('institution_id', $institutions, $srv->institution_id,
                      ['class' => 'form-control'] ) !!}
    @if ($errors->has('institution_id'))
    <span class="text-danger">
      <span>{{ $errors->first('institution_id') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('department') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('department', 'Department:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('department', $srv->department, ['class' => 'form-control',
                   'placeholder' => 'Department where the visitor works']) !!}
    @if ($errors->has('department'))
    <span class="text-danger">
      <span>{{ $errors->first('department') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('visiting') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('visiting', 'Visiting:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('visiting', $srv->visiting, ['class' => 'form-control',
              'placeholder' =>
              'People and institution where the visit will take place']) !!}
    @if ($errors->has('visiting'))
    <span class="text-danger">
      <span>{{ $errors->first('visiting') }}</span>
    </span>
    @endif
  </div>
</div>


<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::textarea('description', $srv->description,
                       ['id' => 'description']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('report') ? ' has-error line-break-dbl' : '' }}'> 
  {!! Form::label('report', 'Report:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::textarea('report', $srv->report, ['id' => 'report']) !!}
    @if ($errors->has('report'))
    <span class="text-danger">
      <span>{{ $errors->first('report') }}</span>
    </span>
    @endif
  </div>
</div>


{!! Form::submit('Save', ['class' => 'btn btn-default btn-lg2']) !!}

{!! Form::close() !!}

<script>
  CKEDITOR.replace('description');
  CKEDITOR.replace('report');
</script>

@endsection
