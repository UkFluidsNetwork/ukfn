@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Users {{ Html::link('/panel/users/export/', "Export", ["class" => "btn btn-default pull-right"])}}</h2>
  
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Name</th>
          <th>Surname</th>
          <th class="hide-this">Group</th>
          <th class="hide-this">Institution</th>
          <th class="hide-this">Email</th>
          <th class="hide-this">Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ isset($user->title) ? $user->title['shortname'] : '' }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->surname }}</td>
        <td class="hide-this">{{ $user->group['name'] }}</td>
        <td class="hide-this">
            @foreach ($user->institutions as $institution)
            {{ $institution['name'] }},
            @endforeach
        </td>
        <td class="hide-this">{{ Html::link('mailto:' . $user->email, $user->email) }}</td>
        <td class="hide-this">{{ $user->created }}</td>
        <td>{{ $user->updated }}</td>
        <td>{{ Html::link('/panel/users/edit/' . $user->id, "Edit", ["class" => "btn btn-primary"])}}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
