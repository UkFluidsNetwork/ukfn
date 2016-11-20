@extends('layouts.member')
@section('membercontent')
@include ('flash.success')

<h2 class='line-break'>Preferences</h2>
<div class="container nopadding">
    <div class="row nopadding">
        <div class='col-lg-8'>
            <form name="preferencesForm" class="nopadding form-horizontal line-break-dbl-top" method="post" action="/myaccount/preferences">

                {{ csrf_field() }}

                <!-- subscription input - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('institutions') ? ' has-error' : ''}}">
                        <div class="checkbox">
                            <label><input id='subscription' name='subscription' type="checkbox" {{ $subscription ? "checked='checked'" : "" }} value="1">Sign up to mailing list</label>
                        </div>
                    </div>
                </div>
                <!-- subscription input - end -->
                <!-- Submit button - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group line-break-dbl-top">
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
                <!-- Submit button - end -->
            </form>
        </div>
    </div>
</div>
@stop