@extends('master')
@section('content')
          @include ('errors.list')
          
          <h2 class='line-break'>Contact</h2>

          {!! Form::open(['url' => 'contact']) !!}
            <div class='form-group'>
              {!! Form::label('name', 'Name :', ['class' => 'control-label']) !!}
              {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Your name']) !!}
            </div>
            <div class='form-group'>
              {!! Form::label('email', 'Email :', ['class' => 'control-label']) !!}
              {!! Form::text('email', null, ['class' => 'form-control','placeholder' => 'your@email.com']) !!}
            </div>
            <div class='form-group'>
              {!! Form::label('message', 'Message :', ['class' => 'control-label']) !!}
              {!! Form::textarea('message', null, ['class' => 'form-control','placeholder' => 'Your message']) !!}
            </div>
            <div class='form-group'>
              {!! Form::submit('Send', ['class' => 'btn btn-default btn-lg']) !!}
            </div>  
          {!! Form::close() !!}

@stop