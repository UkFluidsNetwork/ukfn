@extends('layouts.admin')
@section('head')
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection
@section('admincontent')

<h2 class='line-break'>Edit Caption</h2>


{!! Form::model($file, [
'method' => 'PATCH',
'action' => ['FilesController@update', $file->id],
'class' => 'form-horizontal'
]) !!}

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

{!! Form::submit('Save', ['class' => 'btn btn-default btn-lg2']) !!}

{!! Form::close() !!}

<script>
  CKEDITOR.replace('description');
</script>

@endsection
