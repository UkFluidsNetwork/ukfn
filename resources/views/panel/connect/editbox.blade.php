@extends('layouts.admin')
@section('head')
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection
@section('admincontent')

<h2 class='line-break'>Edit box {{ $connectBox->title }}</h2>


{!! Form::model($connectBox, [
'method' => 'PATCH',
'action' => ['ConnectController@updateBox', $connectBox->id],
'class' => 'form-horizontal'
]) !!}

<input type="hidden" name="order" id="order" value="{{ $connectBox->order }}">
<input type="hidden" name="active" id="active" value="{{ $connectBox->active }}">
<input type="hidden" name="user_id" id="user_id" value="{{ $connectBox->user_id }}">

<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', $connectBox->title, ['class' => 'form-control',
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
    {!! Form::textarea('content', $connectBox->content, ['id' => 'content']) !!}
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
CKEDITOR.stylesSet.add( 'my_styles', [
    { name: 'Red title', element: 'p', styles: { 'color': '#a94442', 'margin-top': '2em !important', 'font-size': '18px' } },
  ]);
CKEDITOR.config.stylesSet = 'my_styles';
</script>

@endsection
