@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/main.js')}}"></script>
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
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

<div class="form-group {{ $errors->has('multimedia') ? ' has-error' : ''}}">
    <label for="multimedia" class="control-label col-lg-2 text-left">Tags</label>
    <div class=' col-lg-8'>
        <select id="multimedia" type="text" class="tags form-control multi" name="multimedia[]" placeholder="Tags" multiple>
            @foreach($multimedia as $key => $tag)
            <option value='{{ $tag->id}}'>{{ $tag->name}}</option>
            @endforeach
        </select>
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
  $('.tags').selectize({
      plugins: ['remove_button'],
      delimiter: ',',
      persist: false,
      create: function (input) {
          return {
              value: input,
              text: input
          };
      }
  });
</script>

@endsection
