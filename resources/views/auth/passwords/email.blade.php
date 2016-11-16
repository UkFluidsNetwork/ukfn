@extends('layouts.master')

<!-- Main Content -->
@section('content')

@include ('errors.list')

<div class="container-fulid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Form - start -->
                    <form class="form-horizontal line-break-dbl-top" role="form" method="POST" action="{{ url('/password/email') }}">
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
                        <!-- e-mail - end -->
                        <div class="col-lg-10 col-lg-offset-1 line-break-top">
                            <div class="form-group">    
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- Form - end -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
