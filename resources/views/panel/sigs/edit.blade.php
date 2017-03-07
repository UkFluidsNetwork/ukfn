@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>{{ (Auth::user()->group_id === 1) ? 'Edit SIG:' : '' }} {{ $sig->name }}</h2>

{!! Form::model($sig, [
'method' => 'PATCH',
'action' => ['SigsController@update', $sig->id],
'class' => 'form-horizontal',
'files' => true
]) !!}

@include('panel.sigs.add_edit_form')

{!! Form::close() !!}

@endsection