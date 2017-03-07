@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add SIG</h2>

{!! Form::model($sig, [
'method' => 'POST',
'action' => ['SigsController@create', $sig->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.sigs.add_edit_form')

{!! Form::close() !!}

@endsection