@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>Add new talk</h2>

{!! Form::model($talk, [
'method' => 'POST',
'action' => ['TalksController@create', $talk->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.talks.add_edit_form')
    
{!! Form::close() !!}
@endsection