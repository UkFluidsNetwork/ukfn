@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div ng-class="registerBasic ? '' : 'col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3'">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create account
                    <span class="pull-right">Step
                    <span ng-show="!registerBasic ? no=1 : no=2">@{{ no }} of 2</span>
                    </span>
                </div>
                <div class="panel-body">
                    <form id="registrationForm" name="registrationForm" class="form-horizontal line-break-dbl-top"
                          method="post" action="/register" novalidate>

                        {{ csrf_field() }}
                        <div id="basicRegister" ng-hide="registerBasic">
                            <!-- title input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('title_id') ? ' has-error' : '' }}" ng-class="{
            'has-error' : registrationForm.title_id.$touched && registrationForm.title_id.$invalid}">
                                    <label for="title_id" class="sr-only">Title</label>
                                    <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>
                                    <select id="title_id" type="text" class="form-control selectpicker show-tick" name="title_id" value="{{ old('title_id')}}"
                                            title="Title" required="required">
                                        @foreach($titles as $title)
                                        <option {{ $title->id == old('title_id') ? 'selected' : ''}} value='{{ $title->id}}'>{{ $title->shortname }}</option>
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
            'has-error' : registrationForm.name.$touched && registrationForm.name.$invalid}">
                                    <label for='name' class="sr-only">First name</label>
                                    <input type="text" name="name" value="{{ old('name')}}" class="form-control"
                                           placeholder="First name" required="required" ng-model="data.name" ng-init="data.name='{{ old('name')}}'">
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
            'has-error' : registrationForm.surname.$touched && registrationForm.surname.$invalid}">
                                    <label for='surname' class ="sr-only">Surname</label>
                                    <input type="text" id="surname" name="surname" value="{{ old('surname')}}" class="form-control"
                                           placeholder="Surname" required="required" ng-model="data.surname" ng-init="data.surname='{{ old('surname')}}'">
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
            'has-error' : registrationForm.email.$touched && registrationForm.email.$invalid}">
                                    <label for="email" class="sr-only">E-Mail address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email')}}"
                                           placeholder="E-mail address" ng-model="data.email" required="required" ng-init="data.email='{{ old('email')}}'">
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
            'has-error' : registrationForm.password.$touched && registrationForm.password.$invalid}">
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
            'has-error' : registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$invalid}">
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
                            <!-- Next button - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group line-break-dbl-top">
                                    <a href class="btn btn-success" ng-disabled="registrationForm.$invalid" ng-show="registrationForm.$invalid">
                                        Next
                                    </a>
                                    <a href class="btn btn-success" ng-show="registrationForm.$valid" ng-click="registerBasic=true">
                                        Next
                                    </a>
                                </div>
                            </div>
                            <!-- Next button - end -->
                        </div>
                        <div id="register2" ng-show="registerBasic && registrationForm.$valid">
                        <!--div id="register2" -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left">
                                    <p>
                                        <b>Please provide some information about your research career and interests.</b>
                                    </p>
                                </div>
                            </div>
                            <!-- user website input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('url') ? ' has-error' : ''}}">
                                    <label for='url' class ="sr-only">Personal website</label>
                                    <input type="url" id="surname" name="url" value="{{ old('url')}}" class="form-control"
                                           placeholder="Personal website" ng-init="data.url='{{ old('url')}}'">
                                    <i class="form-control-feedback glyphicon glyphicon-globe" aria-hidden="true"></i>
                                </div>
                            </div>
                            <!-- user website input - end -->
                            <!-- orcid input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('orcidid') ? ' has-error' : ''}}">
                                    <label for='orcidid' class ="sr-only">ORCID iD</label>
                                    <input type="orcidid" id="surname" name="orcidid" value="{{ old('orcidid')}}" class="form-control"
                                           placeholder="ORCID iD" ng-init="data.orcidid='{{ old('orcidid')}}'">
                                    <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>
                                </div>
                            </div>
                            <!-- orcid website input - end -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left">
                                    The following are multi-option lists. You may add missing options by typing them and hitting return.
                                </div>
                            </div>
                            <!-- institutions input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('institutions') ? ' has-error' : ''}}">
                                    <label for="institutions" class="sr-only">Institution</label>
                                    <select id="institutions" type="text" class="form-control multi" name="institutions[]"
                                            placeholder="Institution" multiple>
                                        @foreach($institutions as $institution)
                                        <option value='{{ $institution->id}}'>{{ $institution->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- institutions input - end -->
                            <!-- sub-disciplines input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('disciplines') ? ' has-error' : ''}}">
                                    Select the tags from the drop-down list that best represent your research interests
                                    <label for="disciplines" class="sr-only">Fluids sub-disciplines</label>
                                    <!--i class="form-control-feedback glyphicon glyphicon-tint" aria-hidden="true"></i-->
                                    <select id="disciplines" type="text" class="tags form-control multi plugin-optgroup_columns" name="disciplines[]"
                                             placeholder="Fluids sub-disciplines" multiple>
                                        @foreach($subDisciplines as $key => $discipline)
                                        @if ($curDisciplinesCategory !== $discipline->category)
                                            <optgroup label="{{$discipline->category}}">
                                            {{$curDisciplinesCategory = $discipline->category}}

                                        @endif
                                                <option value='{{ $discipline->id}}'>{{ $discipline->name}}</option>

                                        @if ($discipline === end($subDisciplines)) || ($curDisciplinesCategory !== $subDisciplines[$key+1]->category)
                                        </optgroup>

                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- sub-disciplines input - end -->
                            <!-- applications input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('applications') ? ' has-error' : ''}}">
                                    Select the tags from the drop-down list that best represent the application areas of your research; you may also add your own (suggested max 40 chars each) 
                                    <label for="applications" class="sr-only">Application areas</label>
                                    <select id="applications" type="text" class="tags form-control multi" name="applications[]"
                                            placeholder="Application areas" data-live-search="true" data-selected-text-format="count > 2" multiple>
                                        @foreach($applicationAreas as $application)

                                        @if ($curApplicationCategory !== $application->category)
                                            <optgroup label="{{$application->category}}">
                                            {{$curApplicationCategory = $application->category}}
                                        @endif
                                                <option value='{{ $application->id}}'>{{ $application->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- applications input - end -->
                            <!-- techniques input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('techniques') ? ' has-error' : ''}}">
                                    Select the tags from the drop-down list that best represent your research techniques (analytical, numerical, experimental); you may also add your own (suggested max 40 chars each) 
                                    <label for="techniques" class="sr-only">Techniques</label>
                                    <!--i class="form-control-feedback glyphicon glyphicon-wrench" aria-hidden="true"></i-->
                                    <select id="techniques" type="text" class="tags form-control multi" name="techniques[]"
                                            placeholder="Techniques" data-create-item="true" data-live-search="true" data-selected-text-format="count > 2" multiple>
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
                                    Please list any facilities at your institution, such as wind tunnels, rotating tables, etc, for which you are responsible
                                    <label for='facilities' class="sr-only">Facilities</label>
                                    <select id="facilities" type="text" class="tags form-control multi" name="facilities[]"
                                            placeholder="Responsible for facilities" data-create-item="true" multiple>
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
                            <!-- subscription input - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group has-feedback input-icon-left {{ $errors->has('institutions') ? ' has-error' : ''}}">
                                    <div class="checkbox">
                                        <label><input id='subscription' name='subscription' type="checkbox" checked='checked' value="1">Add me to the mailing list</label>
                                    </div>
                                </div>
                            </div>
                            <!-- subscription input - end -->
                            <!-- Submit button - start -->
                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="form-group line-break-dbl-top">
                                    <a href class="btn btn-warning" ng-show="registrationForm.$valid" ng-click="registerBasic=false">
                                        Previous
                                    </a>
                                    <button id="registration-button" type="button" class="btn" ng-class="{
            'btn-primary' : registrationForm.$invalid,
            'btn-success' : registrationForm.$valid}" ng-disabled="registrationForm.$invalid">
                                        Register
                                    </button>
                                </div>
                            </div>
                            <!-- Submit button - end -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#registration-button').click(function() {
        $('#registrationForm').submit();
    });
    
    $('#institutions').selectize({
        plugins: ['remove_button',],
        delimiter: ',',
        framework: 'bootstrap',
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

    .selectize-dropdown-content {
        max-height: 666px !important;
    }

    /*WHOLO GROUP BOX*/
    .optgroup {
        width : 300px !important;
        height : auto !important;
        padding-bottom: 50px !important;
        float: left !important;
        border: none !important;
    }
    
    .optgroup-header {
        font-size:1.5em !important;
    }
</style>

@endsection
