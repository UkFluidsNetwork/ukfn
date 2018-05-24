@extends('layouts.master')

@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
<script src="{{ asset('js/angular.min.js')}}"></script>
<script src="{{ asset('js/angular-messages.min.js')}}"></script>
<script src="{{ asset('js/ngStorage.min.js')}}"></script>
<script src="{{ asset('js/ng-map.min.js')}}"></script>
<script src="{{ asset('js/angApp.js')}}"></script>
<script src="{{ asset('js/selectize.js')}}"></script>
<script src="{{ asset('js/angularjs-dropdown-multiselect.min.js')}}"></script>
<script src="{{ asset('js/directoryCtrl.js')}}"></script>

<style>
    .filter-option {
        margin-left: 22px;
    }

    .form-control-feedback.glyphicon {
        z-index: 10;
    }

    .selectize-dropdown-content {
        max-height: 666px !important;
    }

    .optgroup {
        width : 300px !important;
        height : auto !important;
        padding-bottom: 50px !important;
        float: left !important;
        border: none !important;
    }

    .optgroup-header {
        font-size:1.5em !important;
    }
</style>
@endsection

@section('content')

<h2 class='line-break'>Researchers Directory</h2>

<div class="well responsive">
  <p>
    The UK Fluids Network contains details of {{ $total }} researchers across the UK. You can search this list by subject area or institution. To add yourself to the list, <a href="/register">create an account</a>.
  </p>
</div>
<div ng-app="ukfn"
     ng-controller="directoryController as dirCtrl"
     ng-init="dirCtrl.initialise();">
    <div class="nopadding">
        <!-- Select box -->
        <select id="disciplines" type="text" name="disciplines[]"
                class="tags form-control multi plugin-optgroup_columns"
                placeholder="Fluids sub-disciplines, application areas and SIGs"
                multiple
                 ng-change="dirCtrl.updateQuery()"
                 ng-model="dirCtrl.searchTerms">
            @foreach($subDisciplines as $key => $discipline)
            @if ($curDisciplinesCategory !== $discipline->category)
                <optgroup label="{{$discipline->category}}">
                {{$curDisciplinesCategory = $discipline->category}}

            @endif
                <option value='tag{{ $discipline->id}}'>
                    {{ $discipline->name}}
                </option>

            @if ($discipline === end($subDisciplines)) || ($curDisciplinesCategory !== $subDisciplines[$key+1]->category)
            </optgroup>
            <optgroup label="Application Areas">
             @foreach($applications as $key => $application)
                <option value='tag{{ $application->id}}'>
                    {{ $application->name}}
                </option>
             @endforeach
            </optgroup>
            <optgroup label="Special Interest Groups (SIG)">
             @foreach($sigs as $key => $sig)
                <option value='sig{{ $sig->id}}'>
                    {{ $sig->name}}
                </option>
             @endforeach
            </optgroup>
            @endif
            @endforeach
        </select>
        <selectize id="inst_multiselect"
            options='dirCtrl.institutions'
            config='dirCtrl.selectizeInstConfig'
            ng-change="dirCtrl.updateQuery()"
            ng-model="dirCtrl.searchInsts">
        </selectize>

        <!-- User list -->
      <div ng-if="!dirCtrl.users.length && dirCtrl.loading">
        @include('drop-loader')
      </div>

        <div class="col-sm-6 mapHeight axis-y
                    no-axis-mobile nopadding">
            <div class="line-break hidden-sm hidden-md hidden-lg"></div>
            <!-- User list accordion -->
            <div class="panel-group" ng-if="!dirCtrl.loading">
                <div ng-if="!dirCtrl.users.length">
                    <p>Your search did not return any results.</p>
                </div>
                <div ng-if="!dirCtrl.allDisplayed()">
                  <p>
                      @{{dirCtrl.totalDisplayed}}/@{{dirCtrl.users.length}} researchers shown.
                  </p>
                  <button class="btn btn-default"
                          ng-click="dirCtrl.loadMore(50)"
                          style="width: 48.5%;margin-right:2%;margin-bottom:5px;">
                      Load more
                  </button>
                  <button class="btn btn-default" ng-click="dirCtrl.loadAll()"
                          style="width: 48.5%;margin-bottom:5px;">
                      Load all
                  </button>
                </div>
                <div ng-repeat="user in dirCtrl.users | limitTo:dirCtrl.totalDisplayed"
                     ng-if="!dirCtrl.loading"
                     class='panel panel-default' ng-cloak>
                  <div class="panel-title list-group-item talk">
                    <span class="display-block text-danger line-break-half">
                      @{{ user.name }} @{{ user.surname }} |
                      <span ng-repeat="ins in user.institution_ids"
                            ng-class="{'highlight': dirCtrl.instSelected('inst'+ins.institution_id)}">
                      @{{ dirCtrl.distinctInstitutions[ins.institution_id].name }}
                      </span>
                    </span>
                    <span class="display-block display-table-cell">
                      <span ng-if="user.url">
                        <a href="@{{ user.url }}">@{{ user.url }}</a>
                        <br>
                      </span>
                    </span>
                    <div ng-if="user.sig_ids">
                      <div
                            ng-repeat="sig in user.sig_ids">
                        <span ng-if="sig.main == 0">
                        SIG Member of
                        </span>
                        <span ng-if="sig.main == 1">
                        SIG Leader of
                        </span>
                        <span ng-if="sig.main == 2">
                        SIG Co-leader of
                        </span>
                        <span ng-if="sig.main == 3">
                        SIG Key Personnel of
                        </span>
                        <a href="/sig/@{{ dirCtrl.sigs[sig.sig_id].shortname}}">@{{ dirCtrl.sigs[sig.sig_id].name }}</a>
                        <br>
                      </div>
                    </div>
                    <div ng-if="user.tag_ids"
                         style="width: 100%; display: flow-root;"
                         class="line-break-top line-break">
                      <div ng-repeat="tag in user.tag_ids"
                      <div ng-if="dirCtrl.tags[tag.tag_id]"
                           ng-class="{'highlight': dirCtrl.tagSelected('tag'+tag.tag_id)}"
                            class="label label-new label-ukfn-blue margin-right"
                            style="float:left; margin-top: 5px;">
                        @{{ dirCtrl.tags[tag.tag_id].name }}
                      </div>
                      </div>
                    </div>
                    <div style="clear:both"></div>
                  </div>
                </div>
            </div>
        </div>
        <!-- UK map -->
        <div class="col-sm-6 mobile-nopadding-from-md hide-mobile nopadding">
            <div map-lazy-load="@{{ dirCtrl.MAP_URL }}" >
                <ng-map center="@{{ dirCtrl.map.coordinates }}"
                        scrollwheel="false"
                        draggable="true"
                        map-type-control="false"
                        street-view-control="false"
                        zoom-control-options="{style:'SMALL',
                            position:'TOP_RIGHT'}"
                        options='@{{ dirCtrl.options }}'
                        zoom="6"
                        class="mapHeight">
                    <custom-marker
                        ng-repeat="institution in dirCtrl.distinctInstitutions"
                        position="@{{ institution.lat }},@{{ institution.lng }}"
                        on-click="dirCtrl.searchInst(institution.id)"
                        title="@{{institution.name}}">
                        <div class="map-pointer hand-cursor" ng-class="{'selected': dirCtrl.instSelected('inst'+institution.id), 'two-digits': institution.user_count > 9, 'three-digits': institution.user_count > 99}">
                            @{{ institution.user_count }}
                        </div>
                    </custom-marker>
                </ng-map>
            </div>
        </div>
    </div>
</div>

<script>

    $('.tags').selectize({
        plugins: ['remove_button', 'optgroup_columns'],
        delimiter: ',',
        persist: false,
        closeAfterSelect: true,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

</script>

@endsection
