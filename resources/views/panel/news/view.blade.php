@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>News (What's new)</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($news as $new)
      <tr>
        <td>{{ $new->id }}</td>
        <td>{{ $new->title }}</td>
        <td>{{ $new->created }}</td>
        <td>{{ $new->updated }}</td>
        <td>{{ Html::link('/news/edit/' . $new->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['NewsController@delete', $new->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection