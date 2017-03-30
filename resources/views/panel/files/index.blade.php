@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Files</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Path</th>
          <th>Uploaded</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($files as $file)
      <tr>
        <td>{{ $file->id }}</td>
        <td>{{ $file->full_path }}/{{ $file->name }}</td>
        <td>{{ $file->created }}</td>
        <td>
             {{ Form::open(['action' => ['FilesController@delete', $file->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection