@extends('layouts.master')
@section('content')

    <h2 class='line-break'>Researcher resources</h2>
    <div class="container-fluid nopadding" ng-controller="resourcesController as resourcesCtrl"
         ng-init="resourcesCtrl.updateQuery();resourcesCtrl.loadCategories();resourcesCtrl.loadDisciplines();">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-md-push-7">
                <!-- Filters - start -->
                <div id="resources-filters" class="bs-callout bs-callout-info container-fluid">
                    <h4>Search by subject</h4>
                    <br>@{{resourcesCtrl.showframe}}
                    <selectize id="disciplines_search" 
                        options='resourcesCtrl.disciplines'
                        config='resourcesCtrl.selectizeDisciplinesConfig'
                        ng-change="resourcesCtrl.updateQuery()"
                        ng-model="resourcesCtrl.searchTerms">
                    </selectize>
                    <br>
                    <h4>Resource type</h4>  
                    <ul>
                        <li>
                            <input ng-checked="resourcesCtrl.types.Notes"
                                   type="checkbox" id="type-notes" name="type-notes">
                            <label for="current-option"
                                ng-click="resourcesCtrl.types.Notes = !resourcesCtrl.types.Notes; resourcesCtrl.updateQuery()">
                                Notes<icon class="media-icon glyphicon glyphicon-file"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="resourcesCtrl.types.Code"
                                   type="checkbox" id="type-code" name="type-code">
                            <label for="recorded-option"
                                ng-click="resourcesCtrl.types.Code = !resourcesCtrl.types.Code; resourcesCtrl.updateQuery()">
                                Code<icon class="media-icon glyphicon glyphicon-console"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="resourcesCtrl.types.Slides"
                                   type="checkbox" id="type-slides" name="type-slides">
                            <label for="past-option"
                                ng-click="resourcesCtrl.types.Slides = !resourcesCtrl.types.Slides; resourcesCtrl.updateQuery()">
                                Slides<icon class="media-icon glyphicon glyphicon-blackboard"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="resourcesCtrl.types.Video"
                                   type="checkbox" id="type-video" name="type-video">
                            <label for="past-option"
                                ng-click="resourcesCtrl.types.Video = !resourcesCtrl.types.Video; resourcesCtrl.updateQuery()">
                                Video clip<icon class="media-icon glyphicon glyphicon-film"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                    </ul>
                </div>
                <!-- Filters - end -->
            </div>
            <div id="talks-col" class="col-lg-7 col-md-7 col-md-pull-5 axis-y">
                <div class="well">
                    <p>
                        {{ $pageDescription }}
                    </p>
                    <p>
                        To add to these courses, please {{ Html::link('/contact', 'contact us') }}.
                    </p>
                </div>
                <!-- resources - start -->
                <div class='panel panel-default' ng-repeat="resource in resourcesCtrl.resources">
                    <a  ng-href="#collapse" ng-click="isCollapsed = !isCollapsed"
                        data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" 
                           class='glyphicon pull-right'></i>

                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                                <span style="margin-right:10px;">@{{resource.name}}</span>
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
                    <div ng-attr-id="@{{ 'collapse' }}" 
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
                                    <button ng-repeat="file in tutorial.files"
                                            ng-click="resourcesCtrl.showframe = true"
                                            type="button" class="btn btn-default"
                                            style="margin-right:10px;" 
                                            data-toggle="modal"
                                            data-backdrop="static"
                                            data-keyboard="false"
                                            data-target="#@{{file.id}}">
                                        <i class="glyphicon @{{resourcesCtrl.icons[file.filetype.shortname]}}"></i>
                                        @{{file.filetype.shortname}}
                                    </button>
                                    <div ng-repeat="file in tutorial.files"
                                         class="modal fade" style="margin-top:10%;"
                                         id="@{{file.id}}" tabindex="-1"
                                         role="dialog" aria-labelledby="label-@{{file.id}}">
                                      <div class="modal-dialog" role="document" style="min-width:60%;">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close"
                                                    ng-click="resourcesCtrl.showframe = false"
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
                                                <a ng-if="!resourcesCtrl.isUrl(file.name)"
                                                 href="@{{file.path}}/@{{file.name}}">@{{file.name}}</a>
                                                <div ng-if="resourcesCtrl.isUrl(file.name)"
                                                     ng-attr-id="wrapper-@{{file.id}}"
                                                     class="embed-responsive embed-responsive-4by3">
                                                    <center>Loading video...</center>
                                                    <iframe ng-if="resourcesCtrl.showframe"
                                                        ng-attr-id="iframe-@{{file.id}}"
                                                        class="embed-responsive-item" 
                                                        ng-src="@{{file.name}}" 
                                                        scrolling="no" 
                                                        frameborder="0" 
                                                        allowfullscreen></iframe>
                                              
                                                </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button ng-attr-id="close-@{{file.id}}" 
                                                ng-click="resourcesCtrl.showframe = false"
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
                <!-- resources - end -->
            </div>
        </div>
    </div>

@endsection
