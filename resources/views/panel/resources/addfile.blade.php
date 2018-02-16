@extends('layouts.admin')
@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
@endsection
@section('admincontent')

<h2 class='line-break'>Add File</h2>

{!! Form::model($tutorial, [
'method' => 'POST',
'action' => ['ResourcesController@addTutorialFile', $tutorial->id],
'class' => 'form-horizontal'
]) !!}

{!! Form::hidden('user_id', Auth::user()->id) !!}

<div class="form-group {{ $errors->has('file_id') ? ' has-error' : ''}}">
    <label for="file_id" class="control-label col-lg-2 text-left">
        File
    </label>
    <div class=' col-lg-8'>
        <select id="file_id" type="text"
                class="form-control multi plugin-optgroup_columns"
                name="file_id" placeholder="File">
            @foreach($files as $file)
            <option value='{{ $file->id}}'>{{ $file->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group {{ $errors->has('filetype_id') ? ' has-error' : ''}}">
    <label for="filetype_id" class="control-label col-lg-2 text-left">
        File Type
    </label>
    <div class=' col-lg-8'>
        <select id="filetype_id" type="text"
                class="form-control multi plugin-optgroup_columns"
                name="filetype_id" placeholder="File Type">
            @foreach($filetypes as $filetype)
            <option value='{{ $filetype->id}}'>{{ $filetype->shortname}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class=' col-lg-offset-2 col-lg-8'>
  	<div class='form-group line-break-dbl-top'>
    	{!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
  	</div>
</div>

<script>
    $('#file_id').selectize({
        delimiter: ',',
        persist: false
    });
</script>

{!! Form::close() !!}

@endsection