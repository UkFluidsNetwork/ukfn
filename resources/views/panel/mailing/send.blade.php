@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/main.js')}}"></script>
@endsection

@section('admincontent')

<h2 class='line-break'>Send Mail</h2>

    {!! Form::open(['url' => 'sendmail', 'class' => 'container-fluid nopadding', 'files' => true, 'id' => 'newMessageForm']) !!}

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
                    {!! Form::radio('mailinglist', 1, false, ['id' => 'recipient-mailing', 'onclick' => 'hideSendMail()']) !!} Mailing list
                </label>
                <label class='radio-inline'>
                    {!! Form::radio('mailinglist', 0, true, ['id' => 'recipient-other', 'onclick' => 'hideSendMail()']) !!} Other
                </label>
            </div>
        </div>
                    
        <div class='form-group row {{ $errors->has('to') ? ' has-error line-break-dbl' : '' }}' id='mail-to'>
            {!! Form::label('to', 'To', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                {!! Form::text('to', null, ['class' => 'form-control','placeholder' => 'e-mail addresses separated by ;']) !!}
                @if ($errors->has('to'))
                  <span class="text-danger">
                    <span>{{ $errors->first('to') }}</span>
                  </span>
                @endif
            </div>
        </div>
    
        <div class='form-group row {{ $errors->has('subject') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('subject', 'subject', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
            {!! Form::text('subject', null, ['class' => 'form-control','placeholder' => 'Subject']) !!}
            @if ($errors->has('subject'))
              <span class="text-danger">
                <span>{{ $errors->first('subject') }}</span>
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
    
        <!--div class="form-group row">
            {!! Form::label('Attachment', 'Attachment', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                {!! Form::file('attachment', null) !!}
            </div>
        </div-->
        <div class='form-group row' id="mail-visibility">
            {!! Form::label('', '', ['class' => 'control-label col-lg-2 col-md-2 text-uppercase']) !!}
            <div class='col-lg-10 col-md-10'>
                <label class='radio-inline'>
                    {!! Form::radio('public', 1, true) !!} Points of contact
                </label>
                <label class='radio-inline'>
                    {!! Form::radio('public', 0, false) !!} Other (private)

                </label>
            </div>
        </div>
               
        <div class='form-group row line-break-dbl-top'>
            <div class='col-lg-2 col-md-2'></div>
            <div class='col-lg-10 col-md-10'>
                {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>  
    
    {!! Form::close() !!}
    <!-- CONTACT US FORM - END -->
    
    <script>
        $( document ).ready(function() {
            hideSendMail();
        });
    </script>
    
@endsection
