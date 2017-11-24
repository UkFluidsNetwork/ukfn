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
<script src="{{ asset('js/talksCtrl.js')}}"></script>
@endsection

@section('content')

    <h2 class='line-break'>Talks</h2>
    <div ng-app="ukfn"
         ng-controller="talksController as talksCtrl"
         ng-init="talksCtrl.updateQuery('future')"
         class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4
                        col-md-offset-1 col-md-push-7">
                <!-- Filters - start -->
                <div id="talks-filters" data-spy="affix"
                     data-offset-top="50" data-offset-bottom="750"
                     class="bs-callout bs-callout-info container-fluid">
                    <ul>
                        <li>
                            <label for="current-option"
                                   ng-click="talksCtrl.updateQuery('future')">
                                Future talks
                            </label>
                            <input ng-checked="talksCtrl.query === 'future'"
                                   type="radio"
                                   id="current-option"
                                   name="selector">
                            <div class="check"
                                 ng-click="talksCtrl.updateQuery('future')">
                            </div>
                            <div ng-show="talksCtrl.query === 'future'"
                                 class='talk-series-filter nopadding'>
                                <selectize id="aggr_multiselect_current"
                                    options='talksCtrl.aggregators'
                                    config='talksCtrl.selectizeSeriesConfig'
                                    ng-change="talksCtrl.updateQuery('future')"
                                    ng-model="talksCtrl.selectedAggregators">
                                </selectize>
                            </div>
                        </li>
                        <li>
                            <label for="recorded-option"
                                   ng-click="talksCtrl.updateQuery('recorded')">                                Recorded talks
                            </label>
                            <input ng-checked="talksCtrl.query === 'recorded'"
                                   type="radio"
                                   id="recorded-option"
                                   name="selector">
                            <div ng-click="talksCtrl.updateQuery('recorded')"
                                 class="check">
                            </div>
                            <div ng-show="talksCtrl.query === 'recorded'"
                                 class='talk-series-filter nopadding'>
                                <selectize id="past_search"
                                   config='talksCtrl.selectizeSearchConfig'
                                   ng-change="talksCtrl.updateQuery('recorded')"
                                   ng-model="talksCtrl.searchTerms">
                                </selectize>
                            </div>
                        </li>
                        <li>
                            <label for="past-option"
                                   ng-click="talksCtrl.updateQuery('past')">
                                Past talks
                            </label>
                            <input ng-checked="talksCtrl.query === 'past'"
                                   type="radio"
                                   id="past-option"
                                   name="selector">
                            <div class="check"
                                 ng-click="talksCtrl.updateQuery('past')">
                            </div>
                            <div ng-show="talksCtrl.query === 'past'"
                                 class='talk-series-filter nopadding'>
                                <selectize id="aggr_multiselect_past"
                                    options='talksCtrl.aggregators'
                                    config='talksCtrl.selectizeSeriesConfig'
                                    ng-change="talksCtrl.updateQuery('past')"
                                    ng-model="talksCtrl.selectedAggregators">
                                </selectize>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Filters - end -->
            </div>
            <div id="talks-col" class="col-lg-7 col-md-7 col-md-pull-5 axis-y">
                <div class="well">
                    <p>
                        All the talks listed in this section are imported from the 
                        @foreach ($talksRSS as $talkRSS)
                            @if ($talkRSS !== end($talksRSS)) 
                                {{ Html::link($talkRSS->url, $talkRSS->longname, ['target' => '_blank']) }}, 
                            @else
                                and {{ Html::link($talkRSS->url, $talkRSS->longname, ['target' => '_blank']) }} RSS feeds.    
                            @endif
                        @endforeach
                    </p>
                    <p>
                        To link another RSS feed to this page, please {{ Html::link('/contact', 'contact us') }}.
                    </p>
                </div>

                <!-- no match message - start -->
                <div ng-if="!talksCtrl.talks.length && !talksCtrl.loading" class="alert alert-info line-break-dbl-top">
                    <i class="glyphicon glyphicon-info-sign margin-right"></i> Could not find talks matching your criteria.
                </div>
                <!-- no match message - end -->
                <!-- loading message - start -->
                <div ng-if="!talksCtrl.talks.length && talksCtrl.loading" class="line-break-dbl-top">
                    Loading...
                </div>
                <!-- loading message - end -->

                <!-- all talks list - start -->
                <div class='panel panel-default'
                     ng-repeat="talk in talksCtrl.talks"
                     ng-if="!talksCtrl.loading" ng-cloak>
                    <a  ng-href="#collapse_@{{talk.id}}" ng-click="isCollapsed = !isCollapsed" data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>
                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                               @{{ talk.title }}
                            </div>
                        </span>
                        <span ng-show="talk.speaker != null" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-user icon-item-padding display-table-cell"></icon> 
                            <span class="display-table-cell">
                               @{{ talk.speaker }}
                            </span>
                        </span>
                        <span ng-show="talk.aggregator != null" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-bullhorn icon-item-padding display-table-cell"></icon> 
                            <span class="display-table-cell">
                               @{{ talk.aggregator.longname }}
                            </span>
                        </span>
                        <span ng-show="talk.when != null" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-time icon-item-padding display-table-cell"></icon> 
                            <span class="display-table-cell">
                               @{{ talk.when }}
                            </span>
                        </span>
                        <span ng-show="talk.venue != null" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-map-marker icon-item-padding display-table-cell" style=""></icon>
                            <span class="display-table-cell">
                               @{{ talk.venue }}
                            </span>
                        </span>
                        <span ng-if="talk.displayRecording" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-facetime-video icon-item-padding display-table-cell"></icon>
                            <span class="display-table-cell"> Recording available</span>
                        </span>
                        <span ng-if="talk.isStreamed" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-play icon-item-padding display-table-cell"></icon>
                            <span class="display-table-cell">Live Streaming</span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_' + talk.id }}" class='accordion-body collapse padding'>
                        <div class="line-break">
                            @{{ talk.abstract }}
                        </div>
                        <p ng-if="talk.isStreamed && talk.isFuture">
                            <i class="glyphicon glyphicon-warning-sign"></i> Streaming will be made available 15 minutes before the start of the talk. 
                        </p>
                        <div class="pull-right" style="margin-top:-10px;">
                            <a ng-href="/talks/@{{talk.id}}" target="_blank" title="Open in a new tab">
                                <span class="glyphicon glyphicon-new-window"></span> Open in a new tab
                            </a>
                        </div>
                        <div ng-if="talk.displayRecording" class="line-break-dbl-top">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" ng-src="@{{talk.recordingurl}}" scrolling="no" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div ng-if="talk.displayStream" class="line-break-dbl-top">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" ng-src="@{{talk.streamingurl}}" scrolling="no" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- all talks list - end -->
            </div>
        </div>
    </div>
@endsection
