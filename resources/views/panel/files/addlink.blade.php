@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/main.js')}}"></script>
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection

@section('admincontent')

<h2 class='line-break'>Add a new link</h2>

{!! Form::model($file, [
'method' => 'POST',
'action' => ['FilesController@createLink'],
'class' => 'form-horizontal',
'files'=>true
]) !!}

<div class='form-group {{ $errors->has('url') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('url', 'URL', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('url', $file->url, ['class' => 'form-control',
        'placeholder' => 'Full URL']) !!}
        @if ($errors->has('url'))
        <span class="text-danger">
            <span>{{ $errors->first('url') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Caption:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::textarea('description', $file->description,
                       ['id' => 'description']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
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

<script>
  CKEDITOR.replace('description');
</script>

@endsection
