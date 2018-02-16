@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/main.js')}}"></script>
@endsection

@section('admincontent')

<h2 class='line-break'>Add a new link</h2>

{!! Form::model($file, [
'method' => 'POST',
'action' => ['FilesController@create'],
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

<div class=' col-lg-offset-2 col-lg-8'>
  	<div class='form-group line-break-dbl-top'>
    	{!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
  	</div>
</div>

{!! Form::close() !!}

@endsection
