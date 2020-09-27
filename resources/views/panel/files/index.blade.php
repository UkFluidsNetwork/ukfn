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
          <th>Gallery</th>
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
        <td>{{ $file->gallery ? 'Yes' : 'No' }}</td>
        <td>{{ $file->created }}</td>
        <td>
             {{ Form::open(['action' => ['FilesController@delete',
                                         $file->id],
                            'class' => 'delete' ]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger delete"]) }}
             {{ Form::close() }}
             {{ Form::open(['action' => ['FilesController@addToGallery',
                                         $file->id],
                            'class' => 'gallery' ]) }}
             @if ($file->gallery)
             {{ Form::submit("Remove from Gallery",
                            ["class" => "btn btn-warning"]) }}
             @else
             {{ Form::submit("Add to Gallery",
                            ["class" => "btn btn-success"]) }}
             @endif
             {{ Form::close() }}
             {{ Form::open(['action' => ['FilesController@edit',
                                         $file->id],
                            'class' => 'edit' ]) }}
             {{ Form::submit("Edit", ["class" => "btn btn-primary"]) }}
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
