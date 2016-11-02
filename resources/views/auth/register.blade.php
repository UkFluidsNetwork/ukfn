@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form name="registrationForm" class="form-horizontal line-break-dbl-top"
                          method="post" action="/register">
                        
                        {{ csrf_field() }}
                        <!-- title input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('title_id') ? ' has-error' : '' }}" ng-class="{
        'has-error' : registrationForm.title_id.$touched && registrationForm.title_id.$invalid,
        'has-success' : registrationForm.title_id.$touched && registrationForm.title_id.$valid}">
                                <label for="title_id" class="sr-only">Title</label>
                                <select id="title_id" type="text" class="form-control" name="title_id" value="{{ old('title_id')}}" 
                                        required="required" ng-model="data.title_id">
                                    <option value="">Select title</option>
                                    @foreach($titles as $title)
                                    <option value='{{ $title->id}}'>{{ $title->name}}</option>
                                    @endforeach
                                </select>

                                <div class="text-danger" ng-messages="registrationForm.name.$error" role="alert"
                                     ng-if="registrationForm.title_id.$touched && registrationForm.title_id.$invalid">
                                    <div ng-message="required">Please specify your title</div>
                                </div>

                                @if ($errors->has('title_id'))
                                <span class="help-block">
                                    <strong>{{ $errors-> first('title_id')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- Name input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('name') ? ' has-error' : ''}}" ng-class="{
        'has-error' : registrationForm.name.$touched && registrationForm.name.$invalid,
        'has-success' : registrationForm.name.$touched && registrationForm.name.$valid}">
                                <label for='name' class="sr-only">First name</label>
                                <input type="text" name="name" value="{{ old('name')}}" class="form-control"
                                       placeholder="First name" required="required" ng-model="data.name">
                                <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>

                                <div class="text-danger" ng-messages="registrationForm.name.$error" role="alert"
                                     ng-if="registrationForm.name.$touched && registrationForm.name.$invalid">
                                    <div ng-message="required">Please specify your name</div>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name')}}</strong>
                                </span>
                                @endif
                                
                            </div>
                        </div>
                        <!-- Name input - end -->
                        <!-- Surname input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('surname') ? ' has-error' : ''}}" ng-class="{
        'has-error' : registrationForm.surname.$touched && registrationForm.surname.$invalid,
        'has-success' : registrationForm.surname.$touched && registrationForm.surname.$valid}">
                                <label for='surname' class ="sr-only">Surname</label>
                                <input type="text" id="surname" name="surname" value="{{ old('surname')}}" class="form-control"
                                       placeholder="Surname" required="required" ng-model="data.surname">
                                <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>

                                <div class="text-danger" ng-messages="registrationForm.email.$error" role="alert"
                                     ng-if="registrationForm.surname.$touched && registrationForm.surname.$invalid">
                                    <div ng-message="required">Please specify your surname</div>
                                </div>

                                @if ($errors->has('surname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('surname')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- Surname input - end -->
                        <!-- E-mail input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('email') ? ' has-error' : ''}}" ng-class="{
        'has-error' : registrationForm.email.$touched && registrationForm.email.$invalid,
        'has-success' : registrationForm.email.$touched && registrationForm.email.$valid}">
                                <label for="email" class="sr-only">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email')}}"
                                       placeholder="e-mail address" ng-model="data.email" required="required">
                                <i class="form-control-feedback glyphicon glyphicon-envelope" aria-hidden="true"></i>

                                <div class="text-danger" ng-messages="registrationForm.email.$error" role="alert"
                                     ng-if="registrationForm.email.$touched && registrationForm.email.$invalid">
                                    <div ng-message="required">Please specify your e-mail</div>
                                    <div ng-message="email">Please enter valid e-mail</div>
                                </div>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- E-mail input - end -->
                        <!-- Password input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('password') ? ' has-error' : ''}}" ng-class="{
        'has-error' : registrationForm.password.$touched && registrationForm.password.$invalid,
        'has-success' : registrationForm.password.$touched && registrationForm.password.$valid}">
                                <label for="password" class="sr-only">Password</label>
                                <input id="password" type="password" class="form-control" name="password" 
                                       placeholder="Password" required="required" ng-model="data.password" ng-minlength="6">
                                <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>
                                
                                <div class="text-danger" ng-messages="registrationForm.password.$error" 
                                     ng-if="registrationForm.password.$touched && registrationForm.password.$invalid" role="alert">
                                    <div ng-message="minlength">Your passwords needs to be minimum of 6 characters long</div>
                                    <div ng-message="required">Please specify your password</div>
                                    
                                </div>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- Password input - end -->
                        <!-- Password check input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors-> has('password_confirmation') ? ' has-error' : ''}}" ng-class="{
        'has-error' : registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$invalid,
        'has-success' : registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$valid}">
                                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                       placeholder="Confirm password" ng-model="data.password_confirmation" ng-pattern="data.password"
                                       required="required" ng-minlength="6">
                                <i class="form-control-feedback glyphicon glyphicon-lock" aria-hidden="true"></i>

                                <div class="text-danger" ng-messages="registrationForm.password_confirmation.$error"
                                     ng-if="registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$invalid"
                                     role="alert">
                                    <div ng-message="minlength">Your passwords needs to be minimum of 6 characters long</div>
                                    <div ng-message="required">Please specify your password</div>
                                    <div ng-message="pattern">Password confirmation does not match</div>
                                </div>

                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- Password check input - end -->
                        <!-- Submit button - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group line-break-dbl-top">
                                <button type="submit" class="btn" ng-class="{
        'btn-primary' : registrationForm.$invalid,
        'btn-success' : registrationForm.$valid}">
                                    Register
                                </button>
                            </div>
                        </div>
                        <!-- Submit button - end -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
