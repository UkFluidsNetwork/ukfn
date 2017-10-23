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

<div style="text-align:center;">
    <div class="col-sm-4 col-xs-12">
        <a id="sig-calendar-btn" href="/sig/calendar/"
          style="width: 100%"
          class="btn btn-default line-break-dbl sig-extra-btn">
           SIG meeting calendar
       </a>
    </div>
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
        <button id="sig-calendar-btn"
           data-toggle="modal"
           data-target="#sig-call"
           style="width: 100%"
           class="btn btn-default line-break-dbl sig-extra-btn">
           Next call
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="sig-call"
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
                        <h4 class="modal-title" id="label-sig-call">
                            Next call
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                        There may be a third call for SIG proposals
                        in Spring 2018.
                       </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div ng-app="ukfn" ng-controller="sigController as sigCtrl"
     ng-init="sigCtrl.selectedSigId={{$selectedSigId}}">
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
                    There are 41 Special Interest Groups
                    spanning 63 institutions.
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
                    <a href="/sig/@{{sig.shortname}}">
                      <img class='sig-map-image'
                           src="/pictures/sig/@{{sig.bigimage}}"
                           alt="@{{sig.bigimage}}">
                    </a>
                   </div>
                   <p class="line-break padding-left padding-right">
                     @{{ sigCtrl.thisSig.data.description }}
                   </p>
                   <p  ng-repeat="leader in sigCtrl.thisSig.data.leader"
                       class="text-center">
                     <strong class="line-break">Leader:</strong> @{{ leader.name }} @{{ leader.surname }} <i>(<span ng-repeat="institution in leader.institutions">@{{ institution.name }}</span>)</i>
                   </p>
                   <p class="text-center">
                     <a class="btn btn-default"
                        href="/sig/@{{sig.shortname}}">
                       More details
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
@endsection
