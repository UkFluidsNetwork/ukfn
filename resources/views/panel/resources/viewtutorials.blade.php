@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Edit tutorials: {{ $resource->name }}</h2>
  {{ Html::link('/panel/resources/tutorials/add/' . $resource->id,
                "Add Tutorial", ["class" => "btn btn-default"])}}
  <div class="table-responsive">
    <table class='table'>
      <thead>
        <tr>
          <th>Order</th>
          <th>Title</th>
          <th>Status</th>
          <th class="hide-this">Created</th>
          <th class="hide-this">Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @if ($resource->tutorials)
      @foreach ($resource->tutorials as $tutorial)
      <tr>
        <td>{{ $tutorial->priority }}</td>
        <td>{{ $tutorial->name }}</td>
        <td>{{ $tutorial->status() }}</td>
        <td class="hide-this">{{ $tutorial->created_at }}</td>
        <td class="hide-this">{{ $tutorial->updated_at }}</td>
        <td>{{ Html::link('/panel/resources/tutorials/edit/' . $tutorial->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/resources/tutorials/move/up/' . $tutorial->id,
                          "Move Up", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/resources/tutorials/move/down/' . $tutorial->id,
                          "Move Down", ["class" => "btn btn-primary"])}}</td>
        <td>
            @if ($tutorial->status() === "Enabled")
            {{ Html::link('/panel/resources/tutorials/toggle/' . $tutorial->id,
                      "Disable", ["class" => "btn btn-warning"])}}
            @else
            {{ Html::link('/panel/resources/tutorials/toggle/' . $tutorial->id,
                      "Enable", ["class" => "btn btn-success"])}}
            @endif
        </td>
        <td>
             {{ Form::open(['action' => ['SigsController@deleteBox', $tutorial->id],
                            'class' => 'delete']) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      @endif
      </tbody>
    </table>
  </div>
<script>
 $(".delete").on("submit", function(){
      return confirm("Do you want to delete this tutorial?");
 });
</script>
@endsection
