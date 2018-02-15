@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add Resource</h2>

{!! Form::model($resource, [
'method' => 'POST',
'action' => ['ResourcesController@create', $resource->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.resources.add_edit_form')

{!! Form::close() !!}

@endsection