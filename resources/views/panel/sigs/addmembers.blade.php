@extends('layouts.admin')
@section('admincontent')

          <h2 class='line-break'>Add memmbers to Sig no {{ $id }}</h2>


          <div ng-controller="sigController as sigCtrl" ng-init="sigCtrl.getSigMembers({{$id}})">

                                
                                <i ng-init="sigCtrl.getAllUsers()"></i>
                                
                                <table class="table" ng-show="sigCtrl.thisMembers.length > 0">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>e-mail</td>
                                            <td>Institution</td>
                                            <td>Action</td>
                                        </tr>    
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="member in sigCtrl.thisMembers">
                                        <td>@{{ member.name + " " + member.surname}}</td>
                                        <td>@{{ member.email }}</td>
                                        <td>@{{ member.email }}</td>
                                        <td>@{{ member.pivot.main}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                

                                

                                <input type="text" ng-model="sigCtrl.addMemberSearch.fullname" placeholder="User Search">
                                
                                <table class="table" ng-show="sigCtrl.addMemberSearch !== ''">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>e-mail</td>
                                            <td>Institution</td>
                                            <td>Action</td>
                                        </tr>    
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="user in sigCtrl.ukfnUsers | filter:sigCtrl.addMemberSearch" ng-if="sigCtrl.addMemberSearch !== ''">
                                            <td>@{{ user.fullname }} @{{user.userSigMain}}</td>
                                            <td>@{{ user.email }} @{{user.sigMain}}</td>
                                            
                                            <td>
                                                <select ng-model="user.userSigMain">
                                                    <option ng-repeat="membership in sigCtrl.sigMemebrships" 
                                                            value="@{{membership.id}}">@{{ membership.name }}</option><!--ng-selected="membership.id == 3"-->
                                                </select>
                                            </td>
                                            <td>
                                                
                                                <button class="btn btn-primary" ng-click="sigCtrl.addMember(user.id, user.userSigMain, {{$id}})">Add</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                      
                    </div>
<script>
  angular.module("ukfn").constant("CSRF_TOKEN", '{{ csrf_token() }}');
</script>
@endsection