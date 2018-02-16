@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Files</h2>
  {{ Html::link('/panel/resources/tutorials/files/add/' . $tutorial->id,
                "Add File to Tutorial", ["class" => "btn btn-default"])}}
  {{ Html::link('/panel/files/add',
                "Upload File", ["class" => "btn btn-default"])}}
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>Name</th>
          <th>URL</th>
          <th>Type</th>
          <th>Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($tutorial->files as $file)
      <tr>
        <td>{{ $file->name }}</td>
        <td>
             {{ Html::link(
                  $file->full_path,
                  $file->full_path,
                  ['target' => '_blank']) }}
        </td>
        <td>{{ $file->filetype->shortname }}</td>
        <td>{{ $file->created }}</td>
        <td>
             {{ Form::open(['action' =>
                            ['ResourcesController@deleteFile', $file->id],
                            'class' => 'delete']) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
<script>
 $(".delete").on("submit", function(){
      return confirm("Do you want to delete this file?");
 });
</script>
@endsection
