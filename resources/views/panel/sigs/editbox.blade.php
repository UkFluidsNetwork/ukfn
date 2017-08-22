@extends('layouts.admin')
@section('head')
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection
@section('admincontent')

<h2 class='line-break'>Edit box {{ $sigBox->title }}</h2>


{!! Form::model($sigBox, [
'method' => 'PATCH',
'action' => ['SigsController@updateBox', $sigBox->id],
'class' => 'form-horizontal'
]) !!}

<input type="hidden" name="sig_id" id="sig_id" value="{{ $sigBox->sig_id }}">
<input type="hidden" name="order" id="order" value="{{ $sigBox->order }}">
<input type="hidden" name="active" id="active" value="{{ $sigBox->active }}">
<input type="hidden" name="user_id" id="user_id" value="{{ $sigBox->user_id }}">

<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', $sigBox->title, ['class' => 'form-control',
                                 'placeholder' => 'Title']) !!}
    @if ($errors->has('title'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('content') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('content', 'Content:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::textarea('content', $sigBox->content, ['id' => 'content']) !!}
    @if ($errors->has('content'))
    <span class="text-danger">
      <span>{{ $errors->first('content') }}</span>
    </span>
    @endif
  </div>
</div>

{!! Form::submit('Save', ['class' => 'btn btn-default btn-lg2']) !!}

{!! Form::close() !!}

<script>
  CKEDITOR.replace('content');
</script>

@endsection
