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

    /*WHOLO GROUP BOX*/
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
<div class="container-fluid"
     ng-app="ukfn"
     ng-controller="directoryController as dirCtrl"
     ng-init="dirCtrl.updateQuery();">
  <div class="row">
    <div class="col-12">
        <select id="disciplines" type="text" name="disciplines[]"
                class="tags form-control multi plugin-optgroup_columns"
                placeholder="Fluids sub-disciplines" multiple
                 ng-change="dirCtrl.updateQuery()"
                 ng-model="dirCtrl.searchTerms">
            @foreach($subDisciplines as $key => $discipline)
            @if ($curDisciplinesCategory !== $discipline->category)
                <optgroup label="{{$discipline->category}}">
                {{$curDisciplinesCategory = $discipline->category}}

            @endif
                <option value='{{ $discipline->id}}'>{{ $discipline->name}}</option>

            @if ($discipline === end($subDisciplines)) || ($curDisciplinesCategory !== $subDisciplines[$key+1]->category)
            </optgroup>

            @endif
            @endforeach
        </select>

        <div ng-if="!dirCtrl.users.length && dirCtrl.loading"
             class="line-break-dbl-top text-center larger">
                    Loading...
        </div>

      <div ng-repeat="user in dirCtrl.users" class='panel panel-default'>
        <div class="panel-title list-group-item talk">
          <span class="display-block text-danger line-break-half">
            @{{ user.name }} @{{ user.surname }}
            <span ng-repeat="ins in user.institutions">
            | @{{ ins.name }}
            </span>
          </span>
          <span class="display-block display-table-cell">
            <span ng-if="user.url">
              <a href="@{{ user.url }}">@{{ user.url }}</a>
              <br>
            </span>
          </span>
          <div ng-if="user.disciplines"
               style="width: 100%; display: flow-root;"
               class="line-break-top line-break">
            <div ng-repeat="tag in user.disciplines"
                  class="label label-new label-ukfn-blue margin-right"
                  style="float:left; margin-top: 5px;">
              @{{ tag.name }}
            </div>
          </div>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    
    $('.tags').selectize({
        plugins: ['remove_button', 'optgroup_columns'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

</script>

@endsection
