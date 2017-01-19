@extends('layouts.talks')
@section('talkscontent')

<h2 class='line-break'>All Talks</h2>
<div ng-if="!filteredTalks.length" class="alert alert-info">
    <i class="glyphicon glyphicon-info-sign"></i> Could not find talks matching your criteria. Please try again.
</div>
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

@endsection