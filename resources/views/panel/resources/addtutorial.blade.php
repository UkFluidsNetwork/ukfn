@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add Tutorial</h2>

{!! Form::model($tutorial, [
'method' => 'POST',
'action' => ['ResourcesController@createTutorial', $tutorial->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.resources.add_edit_tutorial_form')

{!! Form::close() !!}

@endsection