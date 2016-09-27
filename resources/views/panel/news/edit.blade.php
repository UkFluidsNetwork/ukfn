@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Edit: {{ $new->title }}</h2>

{!! Form::model($new, [
'method' => 'PATCH',
'action' => ['NewsController@update', $new->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', $new->title, ['class' => 'form-control','placeholder' => 'The header of the news']) !!}
    @if ($errors->has('title'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::textarea('description', $new->description, ['class' => 'form-control','placeholder' => 'The body of the news']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('link') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('link', 'Link:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::text('link', $new->link, ['class' => 'form-control','placeholder' => 'The link to a page (View more)']) !!}
    @if ($errors->has('link'))
    <span class="text-danger">
      <span>{{ $errors->first('link') }}</span>
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