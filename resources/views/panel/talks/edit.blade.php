@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>Edit talk no: {{ $talk->id }}</h2>

{!! Form::model($talk, [
'method' => 'PATCH',
'action' => ['TalksController@update', $talk->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.talks.add_edit_form')
    
{!! Form::close() !!}
@endsection