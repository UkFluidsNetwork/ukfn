@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Researcher Resources</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>Order</th>
          <th>Title</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($resources as $resource)
      <tr>
        <td>{{ $resource->order }}</td>
        <td>{{ $resource->name }}</td>
        <td>{{ $resource->created }}</td>
        <td>{{ $resource->updated }}</td>
        <td>{{ Html::link('/panel/resources/edit/' . $resource->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/resources/tutorials/' . $resource->id,
                          "Tutorials", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/resources/move/up/' . $resource->id,
                          "Move Up", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/resources/move/down/' . $resource->id,
                          "Move Down", ["class" => "btn btn-primary"])}}</td>
        <td>
            @if ($resource->status() === "Enabled")
            {{ Html::link('/panel/resources/toggle/' . $resource->id,
                      "Disable", ["class" => "btn btn-warning"])}}
            @else
            {{ Html::link('/panel/resources/toggle/' . $resource->id,
                      "Enable", ["class" => "btn btn-success"])}}
            @endif
        </td>
        <td>
             {{ Form::open(['action' =>
                            ['ResourcesController@delete', $resource->id],
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
      return confirm("Do you want to delete this resource?");
 });
</script>
@endsection
