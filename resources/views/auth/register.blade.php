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
                                <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>
                                <select id="title_id" type="text" class="form-control selectpicker show-tick" name="title_id" value="{{ old('title_id')}}" 
                                        title="Title" required="required">
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
                        <!-- institutions input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('institutions') ? ' has-error' : ''}}">
                                <label for="institutions" class="sr-only">Institution</label>
                                <select id="institutions" type="text" class="form-control multi" name="institutions[]" placeholder="Institution" required="required" multiple>
                                    @foreach($institutions as $institution)
                                    <option value='{{ $institution->id}}'>{{ $institution->name}}</option>
                                    @endforeach
                                </select>
                                <!--i class="form-control-feedback glyphicon glyphicon-education" aria-hidden="true"></i-->
                            </div>
                        </div>
                        <!-- institutions input - end -->
                        <!-- sub-disciplines input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('disciplines') ? ' has-error' : ''}}">
                                <label for="disciplines" class="sr-only">Fluids Sub-Discipline</label>
                                <!--i class="form-control-feedback glyphicon glyphicon-tint" aria-hidden="true"></i-->
                                <select id="disciplines" type="text" class="tags form-control multi" name="disciplines[]" placeholder="Fluids Sub-Discipline" required="required" multiple>
                                    @foreach($subDisciplines as $discipline)
                                    <?php
                                    if ($curDisciplinesCategory !== $discipline->category) {
                                        echo "<optgroup label=\"".$discipline->category."\">";
                                        $curDisciplinesCategory = $discipline->category;
                                    }
                                    ?>
                                    <option value='{{ $discipline->id}}'>{{ $discipline->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- sub-disciplines input - end -->
                        <!-- applications input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('applications') ? ' has-error' : ''}}">
                                <label for="applications" class="sr-only">Application Area</label>
                                <!--i class="form-control-feedback glyphicon glyphicon-tag" aria-hidden="true"></i-->
                                <select id="applications" type="text" class="tags form-control multi" name="applications[]" placeholder="Application Area" data-live-search="true" data-selected-text-format="count > 2" required="required" multiple>
                                    @foreach($applicationAreas as $application)
                                    <?php
                                    if ($curApplicationCategory !== $application->category) {
                                        echo "<optgroup label=\"".$application->category."\">";
                                        $curApplicationCategory = $application->category;
                                    }
                                    ?>
                                    <option value='{{ $application->id}}'>{{ $application->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- applications input - end -->
                        <!-- techniques input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('techniques') ? ' has-error' : ''}}">
                                <label for="techniques" class="sr-only">Techniques</label>
                                <!--i class="form-control-feedback glyphicon glyphicon-wrench" aria-hidden="true"></i-->
                                <select id="techniques" type="text" class="tags form-control multi" name="techniques[]" placeholder="Techniques" data-create-item="true" data-live-search="true" data-selected-text-format="count > 2" required="required" multiple>
                                    @foreach($techniques as $technique)
                                    <option value='{{ $technique->id}}'>{{ $technique->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- applications input - end -->
                        <!-- facilities input - start -->
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="form-group has-feedback input-icon-left {{ $errors->has('facilities') ? ' has-error' : ''}}">
                                <label for='facilities' class="sr-only">Facilities</label>
                                <select id="facilities" type="text" class="tags form-control multi" name="facilities[]" placeholder="Responsible for Facilities" data-create-item="true" multiple>
                                    @foreach($facilities as $facilitie)
                                    <option value='{{ $facilitie->id}}'>{{ $facilitie->name}}</option>
                                    @endforeach
                                </select>
                                <!--i class="form-control-feedback glyphicon glyphicon-compressed" aria-hidden="true"></i-->
                                @if ($errors->has('facilities'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('facilities')}}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!-- facilities input - end -->
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
<script>
    $('#institutions').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });
    
    $('.tags').selectize({
        plugins: ['remove_button', 'optgroup_columns'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });
</script>
<style>
    .filter-option {
        margin-left: 22px;
    }
    
    .form-control-feedback.glyphicon {
        z-index: 10;
    }
</style>
@endsection
