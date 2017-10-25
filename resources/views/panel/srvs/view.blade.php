@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>SRV</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>visitor</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($srvs as $srv)
      <tr>
        <td>{{ $srv->id }}</td>
        <td>{{ $srv->name }}</td>
        <td>{{ $srv->visitor }}</td>
        <td>{{ $srv->created_at }}</td>
        <td>{{ $srv->updated_at }}</td>
        <td>{{ Html::link('/panel/srv/edit/' . $srv->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' =>
                            ['SrvsController@delete', $srv->id],
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
      return confirm("Do you want to delete this SRV?");
 });
</script>
@endsection
