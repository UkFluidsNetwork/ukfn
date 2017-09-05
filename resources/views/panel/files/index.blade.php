@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Files</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
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
