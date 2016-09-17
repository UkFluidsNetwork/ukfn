@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Send Mail</h2>


    {!! Form::open(['url' => 'sendmail', 'class' => 'container-fluid nopadding']) !!}

        <div class='form-group row'>
            {!! Form::label('from', 'from', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                {!! Form::select('from', ['no-reply' => 'no-reply@ukfluids.net', 'info' => 'info@ukfluids.net'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
    
        <div class='form-group row'>
            {!! Form::label('recipient', 'recipient', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                <label class='radio-inline'>
                    {!! Form::radio('mailing', 'true', true) !!} Mailing list
                </label>
                <label class='radio-inline'>
                    {!! Form::radio('mailing', 'false', false) !!} Other
                </label>
            </div>
        </div>
                    
        <div class='form-group row {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('to', 'To', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
            {!! Form::text('to', null, ['class' => 'form-control','placeholder' => 'e-mail addresses separated by ,']) !!}
            @if ($errors->has('name'))
              <span class="text-danger">
                <span>{{ $errors->first('name') }}</span>
              </span>
            @endif
            </div>
        </div>
    
    
        <div class='form-group row {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('subject', 'subject', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
            {!! Form::text('subject', null, ['class' => 'form-control','placeholder' => 'Subject']) !!}
            @if ($errors->has('name'))
              <span class="text-danger">
                <span>{{ $errors->first('name') }}</span>
              </span>
            @endif
            </div>
        </div>
    
        <div class='form-group row {{ $errors->has('message') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('message', 'Message', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                {!! Form::textarea('message', null, ['class' => 'form-control','placeholder' => 'Your message']) !!}
                @if ($errors->has('message'))
                  <span class="text-danger">
                    <span>{{ $errors->first('message') }}</span>
                  </span>
                @endif
            </div>
        </div>
            
    
        <div class='form-group row'>
            {!! Form::label('', '', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                <label class='radio-inline'>
                    {!! Form::radio('public', 'true', true) !!} Public
                </label>
                <label class='radio-inline'>
                    {!! Form::radio('public', 'false', false) !!} Private
                </label>
            </div>
        </div>
    
        <div class='form-group row line-break-dbl-top'>
            <div class='col-lg-2 col-md-2'></div>
            <div class='col-lg-10 col-md-10'>
                {!! Form::submit('Send', ['class' => 'btn btn-default text-uppercase']) !!}
            </div>
        </div>  
    
    {!! Form::close() !!}
    <!-- CONTACT US FORM - END -->

@endsection