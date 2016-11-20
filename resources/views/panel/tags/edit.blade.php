@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Edit: {{ $tag->name }}</h2>

{!! Form::model($tag, [
'method' => 'PATCH',
'action' => ['TagsController@update', $tag->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('name', 'Tag:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('name', $tag->name, ['class' => 'form-control','placeholder' => 'The name of the tag']) !!}
    @if ($errors->has('name'))
    <span class="text-danger">
      <span>{{ $errors->first('name') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('category') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('category', 'Category:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('category', $tag->category, ['class' => 'form-control','placeholder' => 'The category of the tag']) !!}
    @if ($errors->has('category'))
    <span class="text-danger">
      <span>{{ $errors->first('category') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('type') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('tagtype_id', 'Type:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('tagtype_id', $tagtypes, $tag->tagtype_id, ['class' => 'selectpicker show-tick']) !!}
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