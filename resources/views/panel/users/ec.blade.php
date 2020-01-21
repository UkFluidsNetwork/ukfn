@extends('layouts.admin')

@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
<script src="{{ asset('js/angular.min.js')}}"></script>
<script src="{{ asset('js/angular-messages.min.js')}}"></script>
<script src="{{ asset('js/ngStorage.min.js')}}"></script>
<script src="{{ asset('js/ng-map.min.js')}}"></script>
<script src="{{ asset('js/angApp.js')}}"></script>
<script src="{{ asset('js/selectize.js')}}"></script>
<script src="{{ asset('js/angularjs-dropdown-multiselect.min.js')}}"></script>
<script src="{{ asset('js/ecCtrl.js')}}"></script>
@endsection

@section('admincontent')

<h2 class='line-break'>Executive Committee</h2>

<div ng-app="ukfn"
     ng-controller="ecController as ecCtrl"
      ng-init="ecCtrl.initialise();">
    <div class="table-responsive line-break-dbl">
        <table class="table" ng-show="ecCtrl.thisMembers.length > 0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th>Photo</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="member in ecCtrl.thisMembers">
                    <td>@{{ member.fullname }}</td>
                    <td>
                      <img height="80" width="60" src="@{{ member.photo }}">
                    </td>
                    <td>
                      <selectize id="file_select"
                          options='ecCtrl.files'
                          config='ecCtrl.selectizeFileConfig'
                          ng-change="ecCtrl.updateMember(member.user_id, member.file_id, member.role)"
                          ng-model="member.file_id">
                      </selectize>
                    </td>
                    <td>
                        <input ng-model="member.role"
                               ng-change="ecCtrl.updateMember(member.user_id, member.file_id, member.role)"
                               type="text"
                               id="role"
                               placeholder="Role"
                               class="form-control" />
                    </td>
                    <td>
                        <div ng-click="ecCtrl.deleteMember(member.user_id)"
                             class="btn btn-danger">
                            Delete
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <label for="usr_search_input" class="sr-only">User search</label>
    <input ng-model="ecCtrl.addMemberSearch.fullname"
           id="usr_search_input"
           type="text"
           placeholder="User Search"
           class="form-control">

    <div ng-show="usersFiltered.length < 1"
         class="line-break-dbl-top alert alert-block alert-info">
        <i class="glyphicon glyphicon-info-sign margin-right"></i>
        Could not find users matching your criteria.
    </div>
    <div class="table-responsive line-break-dbl-top">
        <table class="table"
               ng-show="ecCtrl.addMemberSearch.fullname!== ''
                           && ecCtrl.addMemberSearch !== ''">
            <thead>
                <tr ng-hide="usersFiltered.length < 1">
                    <th>Name</th>
                    <th>e-mail</th>
                    <th>Institution</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-if="ecCtrl.addMemberSearch !== ''"
                    ng-repeat="user in ecCtrl.ukfnUsers
                            | filter:ecCtrl.addMemberSearch as usersFiltered">
                    <td>@{{ user.fullname }} </td>
                    <td>@{{ user.email }}</td>
                    <td>
                        <div ng-repeat="ins in user.institutions">
                            <span  class="block">
                                @{{ins.name}}
                            </span>
                        </div>
                    </td>
                    <td>
                        <button ng-click="ecCtrl.addMember(user.id, user.selected);"
                                class="btn btn-primary">
                            Add
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
