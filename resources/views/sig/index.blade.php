@extends('layouts.master')
@section('content')
@include('flash.success')
<div class="line-break display-block" style="overflow: auto">
    <h2 class="full-width line-break">
       Special Interest Groups
       <a id="sig-calendar-btn"
          href="/sig/calendar/"
          class="pull-right btn btn-default">
           SIG meeting calendar
       </a>
    </h2>
    <div class="ell">
        <p>
          <span class="glyphicon glyphicon-exclamation-sign"></span>
          If you are interested in joining a SIG,
          please contact the SIG leader directly.
          There may be a third call for SIG proposals in Spring 2018.
        </p>
    </div>
</div>

<div ng-app="ukfn" ng-controller="sigController as sigCtrl"
     ng-init="sigCtrl.selectedSigId={{$selectedSigId}}">
    <div class="container-fluid nopadding">
        <!-- UK map -->
        <div class="col-md-6 col-md-push-3 col-sm-7 mobile-nopadding-from-md">
            <div map-lazy-load="@{{ sigCtrl.MAP_URL }}" >
                <ng-map center="@{{ sigCtrl.map.coordinates }}"
                        scrollwheel="false"
                        draggable="true"
                        map-type-control="false"
                        street-view-control="false"
                        zoom-control-options="{style:'SMALL',
                            position:'TOP_RIGHT'}"
                        options='@{{ sigCtrl.options }}'
                        zoom="6"
                        class="mapHeight">
                    <custom-marker
                        ng-repeat="institution
                          in sigCtrl.thisSig.data.institutions"
                        position="@{{ institution.lat }},@{{ institution.lng }}"
                        icon="@{{ sigCtrl.customIcon }}"
                        title="@{{institution.name}}">
                        <div class="map-pointer"></div>
                    </custom-marker>
                    <custom-marker
                        ng-if="sigCtrl.displayAll"
                        ng-repeat="institution in sigCtrl.distinctInstitutions"
                        position="@{{ institution.lat }},@{{ institution.lng }}"
                        icon="@{{ sigCtrl.customIcon }}"
                        title="@{{institution.name}}">
                        <div class="map-pointer"></div>
                    </custom-marker>
                </ng-map>
            </div>
        </div>
        <!-- Sig institutions -->
        <div class="col-lg-3 col-lg-pull-6 col-md-3 col-md-pull-6
                    mapHeight axis-y">
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
                <ul ng-repeat="ins in sigCtrl.distinctInstitutions"
                    class="no-li-style">
                    <li>
                        @{{ ins.name }}
                    </li>
                </ul>
            </div>
            <div ng-if="!sigCtrl.displayAll">
                <div class="page-header" style="margin-top: 0px;">
                    <a href="/sig/@{{sigCtrl.thisSig.data.shortname}}"
                       class="text-danger">
                        <div class="text-danger line-break">
                            <strong>
                                @{{ sigCtrl.thisSig.data.name }}
                            </strong>
                        </div>
                    </a>
                    <div ng-if="sigCtrl.thisSig.data.smallimage"
                         class='sig-map-image'>
                        <a href="/sig/@{{sigCtrl.thisSig.data.shortname}}">
                            <img class='sig-map-image'
                                 src="/pictures/sig/@{{sigCtrl.thisSig.data.smallimage}}"
                                 alt="@{{sigCtrl.thisSig.data.smallimage}}">
                        </a>
                    </div>
                    <p class="linre-break">
                        @{{ sigCtrl.thisSig.data.description }}
                    </p>
                    <p>
                        <a href="/sig/@{{sigCtrl.thisSig.data.shortname}}">
                          More details
                        </a>
                    </p>
                </div>
                <div class="page-header" style="margin-top: 0px;">
                    <p>
                        <strong class="line-break">Leader</strong>
                    </p>
                    <ul ng-repeat="leader in sigCtrl.thisSig.data.leader"
                        class="no-li-style">
                        <li>
                            @{{ leader.name }} @{{ leader.surname }} <i>(<span ng-repeat="institution in leader.institutions">@{{ institution.name }}</span>)</i></li>
                    </ul>
                </div>
                <p>
                    <strong class="line-break">Institutions</strong>
                </p>
                <ul ng-repeat="ins in sigCtrl.thisSig.data.institutions"
                    class="no-li-style">
                    <li>
                        @{{ ins.name }}</li>
                </ul>
            </div>
        </div>
        <!-- SIG list -->
        <div class="col-lg-3 col-md-3 mapHeight axis-y">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <ul class="nav nav-pills nav-stacked">
                <li ng-class="sigCtrl.displayAll ? 'active' : ''">
                    <a href=""
                       ng-click="sigCtrl.dispAll(); sigCtrl.setActive(false)">
                        All SIGs
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-stacked"
                ng-repeat="sig in sigCtrl.allSigs.data">
                <li ng-class="sigCtrl.sigActive === sig.id ? 'active' : ''" >
                    <a href=""
                       ng-click="sigCtrl.getSig(sig.id);
                                sigCtrl.setActive(sig.id);">
                        @{{ sig.name }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
