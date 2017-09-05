@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Files</h2>

<div class="well"> 
  <p>
  You can <a href="/panel/sig/files/add/{{ $sig->id }}">upload any file</a> to a UK Fluids Network file storage; the file will then be publicly available using the resulting URL. Once uploaded you may reference to the file in the <a href="/panel/sig/box/{{$sig->id}}">SIG page</a>
  </p>
</div>

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
          <th>Action</th>
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
        <td>
             {{ Form::open(['action' => ['FilesController@delete',
                                         $file->id],
                            'class' => 'delete' ]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger delete"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>

<script>
$(".delete").on("submit", function(){
    return confirm("Do you want to permanently delete this file?");
});
</script>

@endsection
