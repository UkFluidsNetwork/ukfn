@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>
   'Edit Resource: {{ $resource->name }}
</h2>

{!! Form::model($resource, [
'method' => 'PATCH',
'action' => ['ResourcesController@update', $resource->id],
'class' => 'form-horizontal',
'files' => true
]) !!}

@include('panel.resources.add_edit_form')

{!! Form::close() !!}

@endsection