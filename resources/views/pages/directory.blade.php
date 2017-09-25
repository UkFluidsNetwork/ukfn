@extends('layouts.master')

@section('head')
  <script src="{{ asset('js/directoryCtrl.js')}}"></script>
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
     ng-init="dirCtrl.updateQuery();
             dirCtrl.loadCategories();
             dirCtrl.loadDisciplines();">
  <div class="row">
    <div class="col-12">
      <selectize id="disciplines_search"
                 class="line-break"
                 options='dirCtrl.disciplines'
                 config='dirCtrl.selectizeDisciplinesConfig'
                 ng-change="dirCtrl.updateQuery()"
                 ng-model="dirCtrl.searchTerms">
      </selectize>

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

@endsection
