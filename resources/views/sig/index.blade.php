@extends('layouts.master')
@section('content')
@include('flash.success')
    <h2 class='line-break'>Special Interest Groups</h2>
    <div ng-controller="sigController as sigCtrl">
        <div class="" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI" >
            <ng-map center="@{{ sigCtrl.map.latitude }}, @{{ sigCtrl.map.longtitude }}" zoom="6" style="height:800px !important;  ">
                <marker ng-repeat="institution in sigCtrl.$storage.inst.data" position="@{{ institution.lat }},@{{ institution.lng }}"
                    title="@{{institution.name}}">
                </marker>
            </ng-map>
        </div>

        <ul ng-repeat="ins in sigCtrl.$storage.inst.data">
            <li>@{{ ins.name}}</li>
        </ul>
    </div>
@endsection