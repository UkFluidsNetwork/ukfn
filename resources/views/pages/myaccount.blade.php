@extends('layouts.member')
@section('membercontent')
@include ('flash.success')

<h2 class='line-break'>My Account</h2>
<a class="btn-primary2 add-shadow square relative" href="{{ URL::to('/myaccount/personal') }}">
    <div class="centered full-width">
        <span class="glyphicon glyphicon-user glyphicon-large full-width"> </span>
        <span class="full-width">Personal Details</span>
    </div>
</a>
<a class="btn-primary2 add-shadow square relative" href="{{ URL::to('/myaccount/academic') }}">
    <div class="centered full-width">
        <span class="glyphicon glyphicon-education glyphicon-large full-width"> </span>
        <span class="full-width">Academic Details</span>
    </div>
</a>
<a class="btn-primary2 add-shadow square relative" href="{{ URL::to('/myaccount/password') }}">
    <div class="centered full-width">
        <span class="glyphicon glyphicon-lock glyphicon-large full-width"> </span>
        <span class="full-width">Change Password</span>
    </div>
</a>
<a class="btn-primary2 add-shadow square relative" href="{{ URL::to('/myaccount/preferences') }}">
    <div class="centered full-width">
        <span class="glyphicon glyphicon-wrench glyphicon-large full-width"> </span>
        <span class="full-width">Preferences</span>
    </div>
</a>
@stop