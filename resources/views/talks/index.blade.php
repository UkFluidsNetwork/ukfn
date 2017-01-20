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
            <form class="form-inline">
                <div class="form-group margin-right">
                    <label for="aggr_multiselect" class="sr-only"></label>
                    <div id="aggr_multiselect" ng-dropdown-multiselect="" options="talkCtrl.thisAggregators" selected-model="talkCtrl.filterAggregatorsLookup" 
                       events="talkCtrl.multiselectEvents" translation-texts="talkCtrl.multiselectTranslations" extra-settings="talkCtrl.multiselectSettings"></div>
                </div>
                <div class="checkbox margin-right" ng-repeat="(key,value) in talkCtrl.types">
                    <label>
                        <input type="checkbox" data-ng-model='talkCtrl.types[key]'> @{{ key }}
                    </label>
                </div>
            </form>
            <!-- Filters - end -->
                
            <!-- no match message - start -->
            <div ng-if="!filteredTalks.length" class="alert alert-info">
                <i class="glyphicon glyphicon-info-sign"></i> Could not find talks matching your criteria. Please try again.
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
