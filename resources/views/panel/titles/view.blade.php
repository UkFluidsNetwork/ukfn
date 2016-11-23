@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Titles</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Abbreviation</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($titles as $title)
      <tr>
        <td>{{ $title->id }}</td>
        <td>{{ $title->name }}</td>
        <td>{{ $title->shortname }}</td>
        <td>{{ $title->created }}</td>
        <td>{{ $title->updated }}</td>
        <td>{{ Html::link('/panel/titles/edit/' . $title->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['TitlesController@delete', $title->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection