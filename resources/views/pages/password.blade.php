@extends('layouts.member')
@section('membercontent')
@include ('flash.success')

<h2 class='line-break'>My Account</h2>
<div class="container nopadding">
    <div class="row nopadding">
        <div class='col-lg-8'>
            <form id="changePassword" name="registrationForm" class="form-horizontal line-break-dbl-top" method="post" action="/register" novalidate>
                <!-- Password input - start -->
                <div class="col-lg-8">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('password') ? ' has-error' : ''}}" >
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Current Password" required="required">
                        <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password')}}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <!-- Password input - end -->
                <!-- Password input - start -->
                <div class="col-lg-8">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('password') ? ' has-error' : ''}}" >
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="New Password" required="required">
                        <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password')}}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <!-- Password input - end -->
                <!-- Password check input - start -->
                <div class="col-lg-8">
                    <div class="form-group has-feedback input-icon-left {{ $errors-> has('password_confirmation') ? ' has-error' : ''}}" >
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required="required">
                        <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation')}}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <!-- Password check input - end -->
                <!-- Submit button - start -->
                <div class="col-lg-8">
                    <div class="form-group line-break-dbl-top">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                <!-- Submit button - end -->
            </form>
        </div>
    </div>
</div>

@stop