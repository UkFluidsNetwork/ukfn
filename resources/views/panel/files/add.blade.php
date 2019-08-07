@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/main.js')}}"></script>
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
@endsection

@section('admincontent')

<h2 class='line-break'>Upload new file</h2>

<div class="well">
  <p>
  You may specify the file storage to use - file storages represent the path where the file will be uploaded to, e.g. /files/sig, /files/meetings. By default all files will be uploaded to /files
  </p>
  <p>
  All file names will be suffixed with the current timestamp in order to ensure uniqueness; i.e. uploading the same file multiple times will not replace the previous files.
  </p>
</div>

{!! Form::model($file, [
'method' => 'POST',
'action' => ['FilesController@create', $file->id],
'class' => 'form-horizontal',
'files'=>true
]) !!}


<div class="form-group {{ $errors->has('file') ? ' has-error' : ''}}">
    <label for='smallimage' class="control-label col-lg-2 text-left">New file</label>
    <div class=' col-lg-8'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 nopadding'>
            <label class="btn btn-default">
                Browse {!! Form::file('file', ['class' => 'control-label col-lg-2 text-left hide',
                'id' => 'newfile', 'onchange' => 'getFileDetails("newfile")']) !!}
            </label>
        </div>
        <div id="newfile_details" class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding-top: 6px;">
            @if ($file->name)
            {{$file->name}}
            @elseif ($errors->has('file'))
                <span class="{{ $errors->has('file') ? ' has-error control-label' : ''}}">No file selected</span>
            @endif
        </div>
    </div>
</div>

<div class='form-group {{ $errors->has('disk') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('disk', 'Storage:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::select('disk', $disks, null,
                      ['class' => 'form-control'] ) !!}
    @if ($errors->has('disk'))
    <span class="text-danger">
      <span>{{ $errors->first('disk') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('filename') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('filename', 'Alternative file name (optional)', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('filename', $file->filename, ['class' => 'form-control','placeholder' => 'Alternative name to use instead of the native file name, e.g. UKFN_file_1']) !!}
        @if ($errors->has('filename'))
        <span class="text-danger">
            <span>{{ $errors->first('filename') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', $file->title, ['class' => 'form-control','placeholder' => 'The title of the file']) !!}
    @if ($errors->has('title'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('author') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('author', 'Author:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('author', $file->author, ['class' => 'form-control','placeholder' => 'The author of the file']) !!}
    @if ($errors->has('author'))
    <span class="text-danger">
      <span>{{ $errors->first('author') }}</span>
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
      {!! Form::submit('Upload', ['class' => 'btn btn-success btn-lg2']) !!}
    </div>
</div>

{!! Form::close() !!}

<script>
  CKEDITOR.replace('description');
</script>

@endsection
