@extends('layouts.master')

@section('content')

<div class="container-fulid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    <form class="form-horizontal line-break-dbl-top" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <!-- e-mail - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="sr-only">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}"
                                       placeholder="Your e-mail addrress" disabled="disabled">
                                <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- e-mail - end -->
                        <!-- password - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" type="password" class="form-control" name="password" password="Password"
                                   placeholder="Enter your new password">
                            <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- password - end -->
                        <!-- password check - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="sr-only">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                       placeholder="Confirm your new password">
                                <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>
                                
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- password check - end -->
                        <!-- reset button - start-->
                        <div class="col-lg-10 col-lg-offset-1 line-break-dbl-top">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                        <!-- reset button - end -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
