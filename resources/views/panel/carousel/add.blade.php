@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Add Carousel Entry</h2>

{!! Form::model($carousel, [
'method' => 'POST',
'action' => ['PagesController@createCarousel', $carousel->id],
'class' => 'form-horizontal'
]) !!}

@include('panel.carousel.add_edit_form')

{!! Form::close() !!}

@endsection