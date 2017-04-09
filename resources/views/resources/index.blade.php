@extends('layouts.master')
@section('content')

    <h2 class='line-break'>Researcher resources</h2>
    <div class="container-fluid nopadding" ng-controller="resourcesController as resourcesCtrl" ng-init="resourcesCtrl.updateQuery('past')">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-md-push-7">
                <!-- Filters - start -->
                <div id="resources-filters" class="bs-callout bs-callout-info container-fluid">
                    <h4>Search by subject</h4>
                    <br>
                    <selectize id="past_search"config='resourcesCtrl.selectizeSearchConfig'
                        ng-change="resourcesCtrl.updateQuery('recorded')"
                        ng-model="resourcesCtrl.searchTerms">
                    </selectize>
                    <br>
                    <h4>Resource type</h4>  
                    <ul>
                        <li>
                            <input ng-checked="true" type="checkbox" id="current-option" name="selector">
                            <label for="current-option" ng-click="resourcesCtrl.updateQuery('file')">
                                Notes<icon class="media-icon glyphicon glyphicon-file"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="true" type="checkbox" id="recorded-option" name="selector">
                            <label for="recorded-option" ng-click="resourcesCtrl.updateQuery('console')">
                                Code<icon class="media-icon glyphicon glyphicon-console"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="true" type="checkbox" id="past-option" name="selector">
                            <label for="past-option" ng-click="resourcesCtrl.updateQuery('slides')">
                                Slides<icon class="media-icon glyphicon glyphicon-blackboard"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="true" type="checkbox" id="past-option" name="selector">
                            <label for="past-option" ng-click="resourcesCtrl.updateQuery('audio')">
                                Audio clip<icon class="media-icon glyphicon glyphicon-headphones"></icon>
                            </label>

                            <div class="check"></div>
                        </li>
                        <li>
                            <input ng-checked="true" type="checkbox" id="past-option" name="selector">
                            <label for="past-option" ng-click="resourcesCtrl.updateQuery('video')">
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
                
                <!-- all resources list - start -->
                <div class='panel panel-default'>
                    <a  ng-href="#collapse_1" ng-click="isCollapsed = !isCollapsed" data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>
                        <i class='glyphicon glyphicon-file pull-right' style='margin-right:434px;'></i>
                        <i class='glyphicon glyphicon-console pull-right' style='margin-right:-35px;'></i>
                        <i class='glyphicon glyphicon-blackboard pull-right' style='margin-right:-55px;'></i>
                        <i class='glyphicon glyphicon-headphones pull-right' style='margin-right:-75px;'></i>
                        <i class='glyphicon glyphicon-film pull-right' style='margin-right:-95px;'></i>
                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                                Control of fluid flows
                            </div>
                        </span>
                        <span class="display-block text-muted">
                            <span class="display-table-cell">
                               Collection of material from the AIM (Advanced Instability Methods) network...
                            </span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_1' }}" class='accordion-body collapse padding' style='padding-top:0;'>
                        <hr>
                        <div class="">
                            Optimal control, general form<br>
                            Patrick Huerre & Peter Schmid, 2008
                        </div>
                        <hr>
                        <div class="line-break">
                            Optimal control of plane Poiseuille flow<br>
                            George Papadakis, 2010
                        </div>
                        <hr>
                        <div class="line-break">
                            Tutorial on flow control<br>
                            John McKernan, 2010
                        </div>
                        <hr>
                        <div class="line-break">
                            A very rough guide to robust control<br>
                            Ati Sharma, 2010
                        </div>
                        <hr>
                        <div class="line-break">
                            Introduction to control<br>
                            James Whidborne, 2010
                        </div>
                        <hr>
                        <div class="line-break">
                            Model-based feedback control of thermoacoustic oscillations<br>
                            Simon Illingworth, 2011
                        </div>
                    </div>
                </div>
                <div class='panel panel-default'>
                    <a  ng-href="#collapse_2" ng-click="isCollapsed2 = !isCollapsed2" data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed2, 'glyphicon-chevron-down': !isCollapsed2}" class='glyphicon pull-right'></i>
                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                               Acoustofluidics techniques
                            </div>
                        </span>
                        <span class="display-block text-muted">
                            <span class="display-table-cell">
                               Notes and presentations (slides and video clips) from workshop organised by the Acoustofluidics SIG
                            </span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_2' }}" class='accordion-body collapse padding'>
                        <div class="line-break">
                            
                        </div>
                    </div>
                </div>
                <div class='panel panel-default'>
                    <a  ng-href="#collapse_3" ng-click="isCollapsed3 = !isCollapsed3" data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed3, 'glyphicon-chevron-down': !isCollapsed3}" class='glyphicon pull-right'></i>
                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                               Fluid mechanics of microorganisms
                            </div>
                        </span>
                        <span class="display-block text-muted">
                            <span class="display-table-cell">
                               Notes and presentations (slides and video clips) from short course organised by the Biologically Active Fluids SIG
                            </span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_3' }}" class='accordion-body collapse padding'>
                        <div class="line-break">
                            
                        </div>
                    </div>
                </div>
                <div class='panel panel-default'>
                    <a  ng-href="#collapse_4" ng-click="isCollapsed4 = !isCollapsed4" data-toggle='collapse' 
                        class="noborder list-group-item talk panel-body accordion-toggle">
                        <i ng-class="{'glyphicon-chevron-up': isCollapsed4, 'glyphicon-chevron-down': !isCollapsed4}" class='glyphicon pull-right'></i>
                        <span class="display-block text-danger">
                            <div class="panel-title line-break-half">
                               Adjoint methods for stability theory
                            </div>
                        </span>
                        <span class="display-block text-muted">
                            <span class="display-table-cell">
                               Notes and presentations (slides) from workshop organised by the Instability SIG
                            </span>
                        </span>
                    </a>
                    <div ng-attr-id="@{{ 'collapse_4' }}" class='accordion-body collapse padding'>
                        <div class="line-break">
                            
                        </div>
                    </div>
                </div>
                <!-- all talks list - end -->
            </div>
        </div>
    </div>

@endsection                      
