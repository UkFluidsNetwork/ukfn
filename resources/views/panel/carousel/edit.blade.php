@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>
   Edit carousel entry: {{ $carousel->name }}
</h2>

{!! Form::model($carousel, [
'method' => 'PATCH',
'action' => ['PagesController@updateCarousel', $carousel->id],
'class' => 'form-horizontal',
'files' => true
]) !!}

@include('panel.carousel.add_edit_form')

{!! Form::close() !!}

@endsection