@extends('layouts.master')
@section('content')
@include('flash.success')
<h2 class='line-break'>Special Interest Groups{{ Html::link('/sig', 'Back ', ['class'=> 'btn btn-default btn-lg text-uppercase pull-right']) }}</h2>

<div ng-controller="sigController as sigCtrl">
    <div class="container-fluid nopadding">
        <!-- UK map -->
        <div class="col-md-6 col-md-push-3 col-sm-7 mobile-nopadding-from-md">
            <div class="" map-lazy-load="https://maps.google.com/maps/api/js?key=AIzaSyBARkpTMK_9AmqRV967Lrjtx3UUkZrp_HI" >
                <ng-map center="@{{ sigCtrl.map.latitude }}, @{{ sigCtrl.map.longtitude }}" 
                        map-type-control="false" street-view-control="false" 
                        zoom-control="true" zoom-control-options="{style:'SMALL', position:'TOP_RIGHT'}" options='@{{ sigCtrl.options }}' zoom="6" class="mapHeight">
                    <custom-marker ng-repeat="institution in sigCtrl.thisSig.data.institutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                        title="@{{institution.name}}" icon="@{{ sigCtrl.customIcon }}"><span class="map-pointer"></span>
                    </custom-marker>
                    <custom-marker ng-if="sigCtrl.displayAll" ng-repeat="institution in sigCtrl.distinctInstitutions" position="@{{ institution.lat }},@{{ institution.lng }}"
                                   title="@{{institution.name}}" icon="@{{ sigCtrl.customIcon }}"><span class="map-pointer"></span>
                    </custom-marker>
                </ng-map>
            </div>
        </div>
        <!-- Sig institutions -->
        <div class="col-md-3 col-md-pull-6 col-sm-5 mapHeight axis-y">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <div ng-if="sigCtrl.displayAll">
                <div class="page-header nomargin-top">
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
        <div class="col-md-3 col-md-12 mapHeight axis-y">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
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
@endsection