@extends('layouts.master')
@section('content')
@include('flash.success')
<h2 class='line-break'>Special Interest Groups</h2>
<div ng-controller="sigController as sigCtrl">
    <div class="container-fluid nopadding">
        <!-- UK map -->
        <div class="col-lg-6 col-lg-push-3 col-sm-6 col-sm-push-6 mobile-nopadding-from-md">
            <div class="" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI" >
                <ng-map center="@{{ sigCtrl.map.latitude }}, @{{ sigCtrl.map.longtitude }}" options='@{{ sigCtrl.options }}' zoom="6" class="mapHeight">
                    <custom-marker ng-repeat="institution in sigCtrl.thisSig.data.institutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                        title="@{{institution.name}}" icon="@{{ sigCtrl.customIcon }}"><span class="circle"></span>
                    </custom-marker>
                    <custom-marker ng-if="sigCtrl.displayAll" ng-repeat="institution in sigCtrl.distinctInstitutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                                   title="@{{institution.name}}" icon="@{{ sigCtrl.customIcon }}"><span class="circle"></span>
                    </custom-marker>
                </ng-map>
            </div>
        </div>
        <!-- Sig institutions -->
        <div class="col-lg-3 col-lg-pull6 col-sm-6 col-sm-pull-6 mapHeight axis-y nopadding-left ">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <div ng-if="sigCtrl.displayAll">
                <div class="page-header" style="margin-top: 0px;">
                    <div class="text-danger line-break">
                        <strong>All SIGs</strong>
                    </div>
                </div>
                <p>
                    <strong class="line-break">Institutions</strong>
                </p>
                <ul ng-repeat="ins in sigCtrl.distinctInstitutions" class="no-li-style">
                    <li>
                        @{{ ins.name }}
                    </li>
                </ul>
            </div>
            <div ng-if="!sigCtrl.displayAll">
                <div class="page-header" style="margin-top: 0px;">
                    <div class="text-danger line-break">
                        <strong>@{{ sigCtrl.thisSig.data.name }}</strong>
                    </div>
                    <p class="linre-break">
                        @{{ sigCtrl.thisSig.data.description }}
                    </p>
                </div>
                <p>
                    <strong class="line-break">Institutions</strong>
                </p>
                <ul ng-repeat="ins in sigCtrl.thisSig.data.institutions" class="no-li-style">
                    <li>
                        @{{ ins.name }}</li>
                </ul>
            </div>
        </div>
        <!-- SIG list -->
        <div class="col-lg-3 col-md-12 mapHeight mobile-nopadding-from-md">
            <h3 class="visible-md-block visible-sm-block visible-xs-block">&nbsp;</h3>
            <div class="axis-y mapHeight">
                <ul class="nav nav-pills nav-stacked">
                    <li ng-class="sigCtrl.displayAll ? 'active' : ''">
                        <a href="" ng-click="sigCtrl.dispAll(); sigCtrl.setActive(false)">
                            All SIGs
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-pills nav-stacked" ng-repeat="sig in sigCtrl.allSigs.data">
                    <li ng-class="sigCtrl.sigActive === sig.id ? 'active' : ''" >
                        <a href="" ng-click="sigCtrl.getSigInstitution(sig.id); sigCtrl.setActive(sig.id)">
                            @{{ sig.name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    .circle {
        background-image: radial-gradient(circle farthest-corner at 45px 45px , red, #a94442);
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right:20px;
        border: white 3px;
    }
</style>
@endsection