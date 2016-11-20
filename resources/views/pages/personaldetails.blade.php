@extends('layouts.member')
@section('membercontent')
@include ('flash.success')

<h2 class='line-break'>Personal Details</h2>
<div class="container nopadding">
    <div class="row nopadding">
        <div class='col-lg-8'>
            <form name="registrationForm" class="nopadding form-horizontal line-break-dbl-top" method="post" action="/myaccount/personal">

                {{ csrf_field() }}

                <!-- title input - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('title_id') ? ' has-error' : '' }}" ng-class="{
'has-error' : registrationForm.title_id.$touched && registrationForm.title_id.$invalid}">
                        <label for="title_id" class="control-label text-left">Title</label>
                        <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>
                        <select id="title_id" type="text" class="form-control selectpicker show-tick" name="title_id" value="{{ old('title_id')}}"
                                title="Title">
                            @foreach($titles as $title)
                            <option {{ $user->title_id == $title->id ? "selected" : "" }} value='{{ $title->id}}'>{{ $title->shortname}}</option>
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('name') ? ' has-error' : ''}}" ng-class="{
'has-error' : registrationForm.name.$touched && registrationForm.name.$invalid}">
                        <label for='name' class="control-label text-left">First name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                               placeholder="First name" required="required" ng-model="data.name" ng-init="data.name='{{ $user->name }}'">
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('surname') ? ' has-error' : ''}}" ng-class="{
'has-error' : registrationForm.surname.$touched && registrationForm.surname.$invalid}">
                        <label for='surname' class ="control-label text-left">Surname</label>
                        <input type="text" id="surname" name="surname" value="{{ $user->surname }}" class="form-control"
                               placeholder="Surname" required="required" ng-model="data.surname" ng-init="data.surname='{{ $user->surname }}'">
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('email') ? ' has-error' : ''}}" ng-class="{
'has-error' : registrationForm.email.$touched && registrationForm.email.$invalid}">
                        <label for="email" class="control-label text-left">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}"
                               placeholder="e-mail address" ng-model="data.email" required="required" ng-init="data.email='{{ $user->email }}'">
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
                <!-- Submit button - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group line-break-dbl-top">
                        <button type="submit" class="btn btn-success">
                            Save changes
                        </button>
                    </div>
                </div>
                <!-- Submit button - end -->
            </form>
        </div>
    </div>
</div>
<style>
    .filter-option {
        margin-left: 22px;
    }

    .form-control-feedback.glyphicon {
        z-index: 10;
    }
</style>
@stop