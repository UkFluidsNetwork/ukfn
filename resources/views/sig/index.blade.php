@extends('layouts.master')

@section('head')
<script src="{{ asset('js/angular.min.js')}}"></script>
<script src="{{ asset('js/angular-messages.min.js')}}"></script>
<script src="{{ asset('js/ngStorage.min.js')}}"></script>
<script src="{{ asset('js/ng-map.min.js')}}"></script>
<script src="{{ asset('js/angApp.js')}}"></script>
<script src="{{ asset('js/selectize.js')}}"></script>
<script src="{{ asset('js/angularjs-dropdown-multiselect.min.js')}}"></script>
<script src="{{ asset('js/sigCtrl.js')}}"></script>
@endsection

@section('content')
@include('flash.success')

<div class="line-break display-block" style="overflow: auto">
    <h2 class="full-width line-break">
       Special Interest Groups
    </h2>
</div>

<div ng-app="ukfn" ng-controller="sigController as sigCtrl"
ng-init="sigCtrl.selectedSigId={{$selectedSigId}}">
<div style="text-align:center;">
    <div class="col-sm-4 col-xs-12">
        <button id="sig-calendar-btn"
           data-toggle="modal"
           data-target="#join-sig"
           style="width: 100%"
           class="btn btn-default line-break-dbl sig-extra-btn">
           Join a SIG
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="join-sig"
             role="dialog"
             aria-labelledby="label-join-sig">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="label-join-sig">
                            Join a SIG
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                        If you are interested in joining a SIG,
                        please contact the SIG leader directly.
                      </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-12">
        <button id="sig-booklet-btn"
           data-toggle="modal"
           data-target="#sig-booklet"
           style="width: 100%"
           class="btn btn-default line-break-dbl sig-extra-btn">
           Start a SIG
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="sig-booklet"
             role="dialog"
             aria-labelledby="label-sig-call">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="label-sig-booklet">
                            Start a SIG
                        </h4>
                    </div>
                    <div class="modal-body">
                      <div class="embed-responsive embed-responsive-4by3">
                        <object class="embed-responsive-item"
                                data="/files/SIGs_Open_call_guidance_template_200811.1597312481.pdf"></object>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xs-12">
        <button id="sig-calendar-btn"
           data-toggle="modal"
           data-target="#inactive-sig"
           style="width: 100%"
           class="btn btn-default line-break-dbl sig-extra-btn">
           Previous SIGs 
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="inactive-sig"
             role="dialog"
             aria-labelledby="label-join-sig">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close"
                                data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="label-join-sig">
                            Inactive SIGs 
                        </h4>
                    </div>
                    <div class="modal-body">
                      <div ng-repeat="sig in sigCtrl.inactiveSigs.data">
                        <h4 style="display:inline">@{{sig.name}}: </h4>
                        <div style="display:inline">
                            <a ng-if="!sig.external" 
                               href="/sig/@{{sig.shortname}}">
                              More details
                            </a>
                            <a ng-if="sig.external"
                               href="@{{sig.url}}" target="_blank">
                              External website
                            </a>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="container-fluid nopadding">
        <!-- SIG list -->
        <div class="col-md-3 col-sm-5 col-xs-12 mapHeight axis-y
                    no-axis-mobile">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <!-- SIG list accordion -->
            <div class="panel-group" id="accordion">
              <div class="panel panel-primary hide-mobile">
                <div class="panel-heading">
                  <a data-toggle="collapse"
                     data-parent="#accordion"
                     ng-click="sigCtrl.dispAll(); sigCtrl.setActive(false)"
                     ng-href="@{{ '#collapse-all' }}">
                    <h4 class="panel-title">All SIGs</h4>
                  </a>
                </div>
                <div ng-attr-id="@{{ 'collapse-all' }}"
                     ng-class="{in: sigCtrl.thisSig.data.id == null}"
                     class="panel-collapse collapse ">
                   <p class="line-break padding-left padding-right">
                    There are @{{sigCtrl.numberOfSigs}} Special Interest Groups
                    spanning @{{sigCtrl.distinctInstitutions.length}} institutions.
                  </p>
                </div>
              </div>
              <div ng-repeat="sig in sigCtrl.allSigs.data"
                   class="panel panel-primary">
                <div class="panel-heading">
                  <a data-toggle="collapse"
                     data-parent="#accordion"
                     ng-click="sigCtrl.getSig(sig.id); sigCtrl.setActive(sig.id);sigCtrl.displayAll = false;"
                     ng-href="@{{ '#collapse' + sig.id }}">
                     <h4 class="panel-title">
                      @{{ sig.name }}
                    </h4>
                  </a>
                 </h4>
                </div>
                <div ng-attr-id="@{{ 'collapse' + sig.id }}"
                     ng-class="{in: sig.id == sigCtrl.thisSig.data.id}"
                     class="panel-collapse collapse">
                  <div ng-if="sig.bigimage"
                       class='sig-map-image'>
                    <a ng-if="!sig.external" href="/sig/@{{sig.shortname}}">
                      <img class='sig-map-image'
                           src="/pictures/sig/@{{sig.bigimage}}"
                           alt="@{{sig.bigimage}}">
                    </a>
                    <a ng-if="sig.external" href="@{{sig.url}}" target="_blank">
                      <img class='sig-map-image'
                           src="/pictures/sig/@{{sig.bigimage}}"
                           alt="@{{sig.bigimage}}">
                    </a>
                   </div>
                   <p class="line-break padding-left padding-right">
                     @{{ sigCtrl.thisSig.data.description }}
                   </p>
                   <p  ng-repeat="leader in sigCtrl.thisSig.data.leader"
                       ng-if="!sig.external"
                       class="text-center">
                     <strong class="line-break">Leader:</strong> @{{ leader.name }} @{{ leader.surname }} <i>(<span ng-repeat="institution in leader.institutions">@{{ institution.name }}</span>)</i>
                   </p>
                   <p class="text-center">
                     <a ng-if="!sig.external" class="btn btn-default"
                        href="/sig/@{{sig.shortname}}">
                       More details
                     </a>
                     <a ng-if="sig.external" class="btn btn-default"
                        href="@{{sig.url}}" target="_blank">
                       External website
                     </a>
                   </p>
                </div>
              </div>
            </div>
        </div>
        <!-- UK map -->
        @if (!$isMobile)
        <div class="col-md-6 col-sm-7 mobile-nopadding-from-md hide-mobile">
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
                        title="@{{institution.name}}">
                        <div class="map-pointer small red"></div>
                    </custom-marker>
                    <custom-marker
                        ng-if="sigCtrl.displayAll"
                        ng-repeat="institution in sigCtrl.distinctInstitutions"
                        position="@{{ institution.lat }},@{{ institution.lng }}"
                        title="@{{institution.name}}">
                        <div class="map-pointer small red"></div>
                    </custom-marker>
                </ng-map>
            </div>
        </div>
        <!-- Sig institutions -->
        <div class="col-md-3 mapHeight axis-y hidden-sm hide-mobile">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <div ng-if="sigCtrl.displayAll">
                <div class="nomargin-top">
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
                <div class="nomargin-top">
                    <div class="text-danger line-break">
                        <strong>@{{ sigCtrl.thisSig.data.name }}</strong>
                    </div>
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
        @endif
    </div>
</div>
</div>
@endsection
