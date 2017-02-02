@extends('layouts.talks')
@section('talkscontent')

            <h2 class='line-break'>Talks</h2>
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
                <p>
                  Click on any of the talks in the "{{ $talksMenu['header'] }}" menu to see details of them, or browse through the full list of talks.
                </p>
            </div>
                       
            <!-- Filters - start -->
            <div class="container-fluid nopadding">
                <div class='col-lg-6 col-md-6 col-sm-6 nopadding'>     
                    <label for="aggr_multiselect" class="sr-only"></label>
                    <selectize id="aggr_multiselect" options='talkCtrl.thisAggregators' config='talkCtrl.selectizeConfig' ng-model="talkCtrl.filterAggregators"></selectize>
                </div>
                <div class='form-inline col-lg-6 col-md-6 col-sm-6 hidden-xs'>
                    <div class="checkbox margin-right" ng-repeat="(key,value) in talkCtrl.types">
                        <label>
                            <input type="checkbox" data-ng-model='talkCtrl.types[key]'> @{{ key }}
                        </label>
                    </div>
                </div>
                <div class='form-inline col-xs-12 visible-xs nopadding'>
                    <div class="checkbox margin-right" ng-repeat="(key,value) in talkCtrl.types">
                        <label>
                            <input type="checkbox" data-ng-model='talkCtrl.types[key]'> @{{ key }}
                        </label>
                    </div>
                </div>
            </div>
            <!-- Filters - end -->
                
            <!-- no match message - start -->
            <div ng-if="!filteredTalks.length" class="alert alert-info line-break-dbl-top">
                <i class="glyphicon glyphicon-info-sign margin-right"></i> Could not find talks matching your criteria.
            </div>
            <!-- no match message - end -->
            
            <!-- all talks list - start -->
            <div ng-repeat="talk in filteredTalks = (talkCtrl.talks | allTalksFilter: talkCtrl.types : talkCtrl.filterAggregators)">
                <section class="page-header">
                    <div>
                        <span class="h4 text-danger display-block">
                           @{{ talk.title }}
                        </span>
                        <span class="talks-speaker display-block line-break">
                            @{{ talk.speaker }}
                        </span>
                        <span class="display-block line-break">
                            @{{ talk.longname }}
                        </span>
                        <span class="text-muted display-block">
                            @{{ talk.when }}
                        </span>
                        <span class="text-muted line-break-dbl display-block">
                            @{{ talk.venue }}
                        </span>

                        <a ng-href="/talks/view/ @{{talk.id}}" title="View more">View more</a>
                    </div>
                </section>
            </div>
            <!-- all talks list - end -->
@endsection                      
