@extends('layouts.master')
@section('content')
          @include ('flash.success')
          @include ('errors.list')
          
          <h2 class='line-break'>Contact Us</h2>
          <!-- CONTACT US FORM - START -->
          {!! Form::open(['url' => 'contact']) !!}
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding-left: 0;">
                  <div class='form-group'>
                    {!! Form::label('contact-name', 'Name :', ['class' => 'control-label text-uppercase']) !!}
                    {!! Form::text('contact-name', null, ['class' => 'form-control','placeholder' => 'Your name']) !!}
                  </div>
                  <div class='form-group'>
                    {!! Form::label('contact-email', 'Email :', ['class' => 'control-label text-uppercase']) !!}
                    {!! Form::text('contact-email', null, ['class' => 'form-control','placeholder' => 'your@email.com']) !!}
                  </div>
                </div>
                <div class="col-lg-6 pull-right col-md-6 col-sm-6 col-xs-12" style="padding-left: 0;">
                  <div class='form-group'>
                    {!! Form::label('contact-message', 'Message :', ['class' => 'control-label text-uppercase']) !!}
                    {!! Form::textarea('contact-message', null, ['class' => 'form-control','placeholder' => 'Your message']) !!}
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