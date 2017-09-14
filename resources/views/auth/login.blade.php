@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal line-break-dbl-top" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <!-- e-mail - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="sr-only">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="Your e-mail address">
                                <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif

                            </div>
                        </div>
                        <!-- e-mail - start -->
                        <!-- Password - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" type="password" class="form-control" name="password"
                                       placeholder="Your password">
                                <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif

                            </div>
                        </div>
                        <!-- Password - end -->
                        <!-- Remember me check box - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">
                                        <span class="checkboxText">Remember Me</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Remember me check box - end -->
                        <!-- Login button - start-->
                        <div class="col-lg-10 col-lg-offset-1 line-break-dbl-top">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                        <!-- Login button - end-->
                        <!-- Signup button - start-->
                        <hr>
                        <div class="col-lg-10 col-lg-offset-1">
                            <center>
                                <a href="/register">
                                    Create an account
                                </a>
                            </center>
                        </div>
                        <!-- Signup button - end-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
