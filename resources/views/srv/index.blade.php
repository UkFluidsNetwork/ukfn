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
@endsection

@section('content')

<style>
/* TODO: move to main css and replace js in other pages with this */
.panel .accordion-toggle.collapsed:before {
    font-family: 'Glyphicons Halflings';
    content: "\e114"; /* = chevron-down */
    float: right;
    color: grey;
}
.panel  .accordion-toggle:not(.collapsed):before {
    font-family: 'Glyphicons Halflings';
    content: "\e113"; /* = chevron-down */
    float: right;
    color: grey;
}
</style>

  <h2 class='line-break'>Short Research Visits</h2>
  <div class="well">
    <p>
      The UKFN funded nearly 90 short research visits between January 2017 and January 2020.
    </p>
  </div>

@foreach ($srvs as $srv)
    <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv{{ $srv->id }}"
           data-toggle="collapse"
           class="noborder list-group-item talk panel-body accordion-toggle collapsed">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                {{ $srv->name }}
            </div>
        </span>

        <span class="talks-speaker display-block">
            {{ $srv->visitor }}
        </span>
        @if ($srv->department)
        <span class="display-block">
            {{ $srv->department }}
        </span>
        @endif
        <span class="display-block line-break">
            {{ $srv->institution->name }}
        </span>
        <span class="display-block line-break">
            Visiting: {{ $srv->visiting }}
        </span>
        </a>
        <div id="collapse-srv{{ $srv->id }}"
             class="accordion-body collapse padding">
            {!! $srv->description !!}
        @if ($srv->reporturl)
         <button class="btn btn-default btn-resource" data-toggle="modal"
                 data-target="#srv-{{ $srv->id }}">
              <i class="glyphicon glyphicon-file"></i> Report
          </button>
        @endif
        </div>
        @if ($srv->reporturl)
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-{{ $srv->id }}"
             role="dialog" arial-labelledby="label-srv{{ $srv->id }}">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv{{ $srv->id }}">
                    {{ $srv->name }}
                </h4>
              </div>
              <div id="body-srv{{ $srv->id }}" class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                  <object class="embed-responsive-item"
                          data="{{ $srv->reporturl }}">
                  </object>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
@endforeach

@endsection
