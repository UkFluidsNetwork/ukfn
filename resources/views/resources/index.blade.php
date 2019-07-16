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
<script src="{{ asset('js/resourcesCtrl.js')}}"></script>
@endsection

@section('content')
    <h2 class='line-break'>Researcher resources</h2>
    <div ng-app="ukfn"
         ng-controller="resourcesController as resourcesCtrl"
         ng-init="resourcesCtrl.updateQuery();
             resourcesCtrl.loadCategories();
             resourcesCtrl.loadDisciplines();"
         class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-md-push-7">
                <!-- Filters - start -->
                <div id="resources-filters" data-spy="affix"
                     data-offset-top="50" data-offset-bottom="730"
                     style="padding-top: 25px;"
                     class="bs-callout bs-callout-info container-fluid">
                    <selectize id="disciplines_search" 
                        options='resourcesCtrl.disciplines'
                        config='resourcesCtrl.selectizeDisciplinesConfig'
                        ng-change="resourcesCtrl.updateQuery()"
                        ng-model="resourcesCtrl.searchTerms">
                    </selectize>
                </div>
                <!-- Filters - end -->
            </div>
            <div id="resources-col" class="col-lg-7 col-md-7 col-md-pull-5 axis-y">
                <div class="well">
                    <p>
                        {{ $pageDescription }}
                    </p>
                    <p>
                        To add to these courses, please
                        {{ Html::link('/contact', 'contact us') }}.
                    </p>
                </div>
                <!-- resources - start -->
                <div ng-repeat="(key, tag) in resourcesCtrl.resources">
                    <h3>@{{key}}</h3>
                <div ng-repeat="(key, resource) in tag"
                     class='panel panel-default'>
                    <a  ng-href="@{{ '#collapse-' + key + resource.id }}"
                        ng-click="isCollapsed = !isCollapsed"
                        data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed,
                                      'glyphicon-chevron-down': !isCollapsed}" 
                           class='glyphicon pull-right'></i>

                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                                <span style="margin-right:10px;">
                                    @{{resource.name}}
                                </span>
                                <i ng-repeat="type in resource.types" 
                                   style="color:black; margin-left:5px;" 
                                   class="glyphicon @{{resourcesCtrl.icons[type]}}"></i>
                            </div>
                        </span>
                        <span class="display-block text-muted">
                            <span class="display-table-cell">
                               @{{resource.description}}
                            </span>
                        </span>
                    </a>
                    <!-- inner resource - tutorials - start !-->
                    <div ng-attr-id="@{{ 'collapse-' + key + resource.id }}" 
                         class='accordion-body collapse padding' 
                         style='padding-top:0;'>
                        <div ng-repeat="tutorial in resource.tutorials">
                            <hr>
                            <div class="">
                                <span><b>@{{tutorial.name}}</b></span><br>
                                <span class="display-block text-muted">
                                    @{{tutorial.author}}, 
                                    @{{tutorial.date | date: "yyyy"}}
                                </span>
                                <p class="line-break-top">
                                    @{{tutorial.description}}
                                </p>
                            </div>
                            <div class="line-break-top">
                                <div>
                                    <!-- Button trigger modal -->
                                    <button ng-if="file.filetype.shortname !== 'Link'"
                                            ng-repeat="file in tutorial.files"
                                            ng-click="resourcesCtrl.showframe['modal-'+file.id] = true"
                                            type="button"
                                            class="btn btn-default btn-resource"
                                            style="margin-right:10px;" 
                                            data-toggle="modal"
                                            data-backdrop="static"
                                            data-keyboard="false"
                                            data-target="#@{{file.id}}">
                                        <i class="glyphicon @{{resourcesCtrl.icons[file.filetype.shortname]}}"></i>
                                        @{{file.filetype.shortname}}
                                    </button>
                                    <a ng-if="file.filetype.shortname === 'Link'"
                                       ng-repeat="file in tutorial.files"
                                       ng-href="@{{file.path}}"
                                       target="_blank"
                                       type="button"
                                       class="btn btn-default btn-resource"
                                       style="margin-right:10px;">
                                        <i class="glyphicon @{{resourcesCtrl.icons[file.filetype.shortname]}}"></i>
                                        @{{file.filetype.shortname}}
                                    </a>
                                    <div ng-repeat="file in tutorial.files"
                                         class="modal fade" style="margin-top:10%;"
                                         id="@{{file.id}}" tabindex="-1"
                                         role="dialog" aria-labelledby="label-@{{file.id}}">
                                      <div class="modal-dialog" role="document" style="min-width:60%;">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close"
                                                    ng-click="resourcesCtrl.showframe['modal-'+file.id] = false"
                                                    data-dismiss="modal" 
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title"
                                                ng-attr-id="label-@{{file.id}}">
                                                    @{{tutorial.name}} - @{{file.filetype.shortname}}
                                            </h4>
                                          </div>
                                          <div ng-attr-id="body-@{{file.id}}" class="modal-body">
                                                <div ng-if="!resourcesCtrl.isUrl(file.name) && resourcesCtrl.isPdf(file.name)"
                                                    class="embed-responsive embed-responsive-4by3">
                                                    <object ng-if="resourcesCtrl.showframe['modal-'+file.id]"
                                                        class="embed-responsive-item"
                                                        data="@{{file.path}}/@{{file.name}}"></object>
                                                </div>
                                                <a ng-if="!resourcesCtrl.isUrl(file.name) && !resourcesCtrl.isPdf(file.name)"
                                                    href="@{{file.path}}/@{{file.name}}"
                                                    target="_blank">@{{file.name}}
                                                    <small class="glyphicon glyphicon-new-window"></small>
                                                </a>
                                                <div ng-if="resourcesCtrl.isUrl(file.name)"
                                                     ng-attr-id="wrapper-@{{file.id}}"
                                                     class="embed-responsive embed-responsive-4by3">
                                                    <center>Loading video...</center>
                                                    <iframe ng-if="resourcesCtrl.showframe['modal-'+file.id]"
                                                        ng-attr-id="iframe-@{{file.id}}"
                                                        class="embed-responsive-item" 
                                                        ng-src="@{{file.name}}" 
                                                        scrolling="no" 
                                                        frameborder="0" 
                                                        allowfullscreen></iframe>
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                            <a ng-attr-id="open-@{{file.id}}"
                                                ng-if="!resourcesCtrl.isUrl(file.name)"
                                                href="@{{file.path}}/@{{file.name}}"
                                                target="_blank">
                                                    Open in new tab
                                                    <small class="glyphicon glyphicon-new-window"></small>
                                            </a>
                                            <button ng-attr-id="close-@{{file.id}}" 
                                                ng-click="resourcesCtrl.showframe['modal-'+file.id] = false"
                                                type="button"
                                                class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- inner resource - tutorials -end !-->
                </div>
            </div>
                <!-- resources - end -->
            </div>
        </div>
    </div>
@endsection
