@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Files</h2>
  {{ Html::link('/panel/sig/files/add/' . $sig->id, "Add File",
                ["class" => "btn btn-default"])}}

  <div class="table-responsive">
    <table class='table'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>URL</th>
          <th>Uploaded</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($files as $file)
      <tr>
        <td>{{ $file->id }}</td>
        <td>{{ $file->name }}</td>
        <td>
             {{ Html::link(
                  $file->full_path, 
                  $file->full_path, 
                  ['target' => '_blank']) }}
        </td>
        <td>{{ $file->created }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
