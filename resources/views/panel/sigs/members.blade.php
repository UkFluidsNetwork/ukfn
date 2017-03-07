@extends('layouts.admin')
@section('admincontent')

                                <h2 class='line-break'>Add members to: {{$sig->name}}</h2>

                                <div ng-controller="sigController as sigCtrl" ng-init="sigCtrl.selectedSigId={{$id}} ;sigCtrl.loadUsers();">                                    
                                    <div class="table-responsive line-break-dbl">
                                        <table class="table" ng-show="sigCtrl.thisMembers.length > 0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>e-mail</th>
                                                    <th>Institution</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>    
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="member in sigCtrl.thisMembers">
                                                <td>@{{ member.name + " " + member.surname}}</td>
                                                <td>@{{ member.email }}</td>
                                                <td>
                                                    <div ng-repeat="ins in member.institutions">
                                                        <span  class="block">
                                                            @{{ins.name}}
                                                        </span>    
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-control" ng-model="member.pivot.main" style="width: 140px"
                                                            ng-options="m.id as m.name for m in sigCtrl.sigMemebrships" 
                                                            ng-change="sigCtrl.updateMember(member.id, member.pivot.main)">
                                                    </select>                                                                                                    
                                                </td>
                                                <td><div class="btn btn-danger" ng-click="sigCtrl.deleteMember(member.id)">Delete</div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <label for="usr_search_input" class="sr-only">User search</label>
                                    <input type="text" ng-model="sigCtrl.addMemberSearch.fullname" placeholder="User Search" id="usr_search_input" 
                                           class="form-control">
                                    
                                    <div class="line-break-dbl-top alert alert-block alert-info" ng-show="usersFiltered.length < 1">
                                        <i class="glyphicon glyphicon-info-sign margin-right"></i>
                                        Could not find users matching your criteria.
                                    </div>
                                    <div class="table-responsive line-break-dbl-top">
                                        <table class="table" ng-show="sigCtrl.addMemberSearch.fullname!== '' && sigCtrl.addMemberSearch !== ''">
                                            <thead>
                                                <tr ng-hide="usersFiltered.length < 1">
                                                    <th>Name</th>
                                                    <th>e-mail</th>
                                                    <th>Institution</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="user in sigCtrl.ukfnUsers | filter:sigCtrl.addMemberSearch as usersFiltered" ng-if="sigCtrl.addMemberSearch !== ''">
                                                    <td>@{{ user.fullname }} </td>
                                                    <td>@{{ user.email }} @{{user.sigMain}}</td>
                                                    <td>
                                                        <div ng-repeat="ins in user.institutions">
                                                            <span  class="block">
                                                                @{{ins.name}}
                                                            </span>    
                                                        </div>                                                    
                                                    </td>
                                                    <td> 
                                                        <select class="form-control" ng-model="user.selected" style="width: 140px"
                                                            ng-options="m.id as m.name for m in sigCtrl.sigMemebrships">
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" ng-click="sigCtrl.addMember(user.id, user.selected);">Add</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                      
                                    </div>
                                </div>
                                <script>
                                  angular.module("ukfn").constant("CSRF_TOKEN", '{{ csrf_token() }}');
                                </script>
@endsection