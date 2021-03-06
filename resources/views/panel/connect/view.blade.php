@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Connect Page Boxes</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>Order</th>
          <th>Title</th>
          <th>Status</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($boxes as $box)
      <tr>
        <td>{{ $box->order }}</td>
        <td>{{ $box->title }}</td>
        <td>{{$box->status()}}</td>
        <td>{{ $box->created }}</td>
        <td>{{ $box->updated }}</td>
        <td>{{ Html::link('/panel/connect/edit/' . $box->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/connect/move/up/' . $box->id,
                          "Move Up", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/connect/move/down/' . $box->id,
                          "Move Down", ["class" => "btn btn-primary"])}}</td>
        <td>
            @if ($box->status() === "Enabled")
            {{ Html::link('/panel/connect/toggle/' . $box->id,
                      "Disable", ["class" => "btn btn-warning"])}}
            @else
            {{ Html::link('/panel/connect/toggle/' . $box->id,
                      "Enable", ["class" => "btn btn-success"])}}
            @endif
        </td>
        <td>
             {{ Form::open(['action' =>
                            ['ConnectController@deleteBox', $box->id],
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
