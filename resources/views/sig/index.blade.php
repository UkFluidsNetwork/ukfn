@extends('layouts.master')
@section('content')
@include('flash.success')
<h2 class='line-break'>Special Interest Groups</h2>
<div ng-controller="sigController as sigCtrl">
    <div class="container-fluid nopadding">
        <!-- UK map -->
        <div class="col-lg-6 col-lg-push-3 col-md-12 mobile-nopadding-from-md">
            <div class="" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI" >
                <ng-map center="@{{ sigCtrl.map.latitude }}, @{{ sigCtrl.map.longtitude }}" zoom="6" class="mapHeight">
                    <marker ng-repeat="institution in sigCtrl.thisSig.data.institutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                        title="@{{institution.name}}">
                    </marker>
                    <marker ng-if="sigCtrl.displayAll" ng-repeat="institution in sigCtrl.distinctInstitutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                        title="@{{institution.name}}">
                    </marker>
                </ng-map>
            </div>
        </div>
        <!-- SIG list -->
        <div class="col-lg-3 col-lg-push-3 col-md-12 mapHeight mobile-nopadding-from-md">
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
        <!-- Sig institutions -->
        <div class="col-lg-3 col-lg-pull-9 hidden-md hidden-sm hidden-xs mapHeight axis-y nopadding-left">
            <ul ng-repeat="ins in sigCtrl.distinctInstitutions" ng-if="sigCtrl.displayAll" class="no-li-style">
                <li>
                    @{{ ins.name }}
                </li>
            </ul>
            <ul ng-repeat="ins in sigCtrl.thisSig.data.institutions" ng-if="!sigCtrl.displayAll" class="no-li-style">
                <li>
                    @{{ ins.name }}</li>
            </ul>
        </div>
    </div>

    <h3 class="visible-lg-block visible-md-block visible-sm-block visible-xs-block">&nbsp;</h3>
    <div class="container-fluid line-break-dbl-top nopadding" ng-if="sigCtrl.thisSig.data && !sigCtrl.displayAll">
        <div class="col-lg-12 nopadding">
            <h3>@{{ sigCtrl.thisSig.data.name }}</h3>
            @{{ sigCtrl.thisSig.data.description }}
            <a ng-href="/sig/@{{sigCtrl.thisSig.data.id}}" ng-attr-title="@{{ sigCtrl.thisSig.data.name }}">
                This sig page
            </a>
        </div>
    </div>
</div>
@endsection