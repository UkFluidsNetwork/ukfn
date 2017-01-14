@extends('layouts.talks')
@section('talkscontent')
<h2 class='line-break'>All Talks</h2>

<div ng-controller="talksController as talkCtrl">
    <pre>
@{{ talkCtrl.thisAggregators | json}}
@{{ talkCtrl.types | json}}
    </pre>
    <h4>Filters</h4>
    <div ng-repeat="(key,value) in talkCtrl.types">
        
        <input type="checkbox" inverted data-ng-model='talkCtrl.types[key]'> @{{ key }}
        
        
    </div>
    
<!--    <input type="checkbox" inverted data-ng-model='talkCtrl.types.ukfn'> Cambridge Fluids Network
    <input type="checkbox" inverted data-ng-model='talkCtrl.types.imperial'> Imperial College-->

    
    <div ng-repeat="talk in talkCtrl.talks.data | myfilter: talkCtrl.types">
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
</div>
            
@endsection                      

