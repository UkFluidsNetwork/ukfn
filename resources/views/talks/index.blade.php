@extends('layouts.master')
@section('content')

    <h2 class='line-break'>Talks</h2>
    <div class="container-fluid nopadding" ng-controller="talksController as talkCtrl">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-md-push-7">
                <!-- Filters - start -->
                <div id="talks-filters" class="bs-callout bs-callout-info container-fluid">
                    <h4>Filter talks</h4>
                    <div class='nopadding full-width'>     
                        <label for="aggr_multiselect" class="sr-only"></label>
                        <selectize id="aggr_multiselect" options='talkCtrl.thisAggregators' config='talkCtrl.selectizeConfig' ng-model="talkCtrl.filterAggregators"></selectize>
                    </div>
                    <div class='form-inline col-lg-6 col-md-6 col-sm-6 nopadding-left'>
                        <div class="checkbox margin-right" ng-repeat="(key,value) in talkCtrl.types">
                            <label>
                                <input type="checkbox" data-ng-model='talkCtrl.types[key]'> @{{ key }}
                            </label>
                        </div>
                    </div>
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
                <div ng-if="!filteredTalks.length" class="alert alert-info line-break-dbl-top">
                    <i class="glyphicon glyphicon-info-sign margin-right"></i> Could not find talks matching your criteria.
                </div>
                <!-- no match message - end -->

                <!-- all talks list - start -->
                <div class='panel panel-default' ng-repeat="talk in filteredTalks = (talkCtrl.talks | allTalksFilter: talkCtrl.types : talkCtrl.filterAggregators)">
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
                        <span ng-show="talk.longname != null" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-bullhorn icon-item-padding display-table-cell"></icon> 
                            <span class="display-table-cell">
                               @{{ talk.longname }}
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
                        <span ng-if="talk.recordingurl" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-facetime-video icon-item-padding display-table-cell"></icon>
                            <span class="display-table-cell"> Recording available</span>
                        </span>
                        <span ng-if="talk.streamingurl || talk.teradekip" class="display-block text-muted">
                            <icon class="glyphicon glyphicon-play icon-item-padding display-table-cell"></icon>
                            <span class="display-table-cell">Live Streaming</span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_' + talk.id }}" class='accordion-body collapse padding'>
                        <div class="line-break">
                            @{{ talk.abstract }}
                        </div>
                        <p ng-if="talk.isStreamed && !talk.displayStream">
                            <i class="glyphicon glyphicon-warning-sign"></i> Streaming will be made available 15 minutes before the start of the talk. 
                        </p>
                        <div class="pull-right" style="margin-top:-10px;">
                            <a ng-href="/talks/@{{talk.id}}" target="_blank" title="Open in a new tab">
                                <span class="glyphicon glyphicon-new-window"></span> Open in a new tab
                            </a>
                        </div>
                        <div ng-if="talk.recordingurl" class="line-break-dbl-top">
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
