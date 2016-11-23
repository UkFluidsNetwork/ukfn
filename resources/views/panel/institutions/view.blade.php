@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Institutions</h2>
  <div class="table-responsive">
    <table class='table'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Institution</th>
          <th>Type</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($institutions as $institution)
      <tr>
        <td>{{ $institution->id }}</td>
        <td>{{ $institution->name }}</td>
        <td>{{ isset($institution->institutiontype) ? $institution->institutiontype['name'] : '' }}</td>
        <td>{{ $institution->created }}</td>
        <td>{{ $institution->updated }}</td>
        <td>{{ Html::link('/panel/institutions/edit/' . $institution->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['InstitutionsController@delete', $institution->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection