@extends('layouts.master')
@section('content')
  @include ('flash.success')

  <h2 class='line-break'>Contact Us</h2>
  <!-- CONTACT US FORM - START -->
  {!! Form::open(['url' => 'contact']) !!}
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding-left: 0;">
          <div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('name', 'Name :', ['class' => 'control-label text-uppercase']) !!}
            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Your name']) !!}
            @if ($errors->has('name'))
              <span class="text-danger">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
            @endif
          </div>
          <div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('email', 'Email :', ['class' => 'control-label text-uppercase']) !!}
            {!! Form::text('email', null, ['class' => 'form-control','placeholder' => 'your@email.com']) !!}
            @if ($errors->has('email'))
              <span class="text-danger">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            @endif
          </div>
        </div>
        <div class="col-lg-6 pull-right col-md-6 col-sm-6 col-xs-12" style="padding-left: 0;">
          <div class='form-group {{ $errors->has('message') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('message', 'Message :', ['class' => 'control-label text-uppercase']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control','placeholder' => 'Your message']) !!}
            @if ($errors->has('message'))
              <span class="text-danger">
                <strong>{{ $errors->first('message') }}</strong>
              </span>
            @endif
          </div>
          <div class='form-group line-break-dbl-top'>
            {!! Form::submit('Send Message', ['class' => 'btn btn-default btn-lg text-uppercase']) !!}
          </div>  
        </div>
      </div>
    </div>
  {!! Form::close() !!}
  <!-- CONTACT US FORM - END -->
@stop