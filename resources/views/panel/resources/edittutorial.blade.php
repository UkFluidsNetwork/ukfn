@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>
   Edit Tutorial: {{ $tutorial->name }}
</h2>

{!! Form::model($tutorial, [
'method' => 'PATCH',
'action' => ['ResourcesController@updateTutorial', $tutorial->id],
'class' => 'form-horizontal',
'files' => true
]) !!}

@include('panel.resources.add_edit_tutorial_form')

{!! Form::close() !!}

@endsection