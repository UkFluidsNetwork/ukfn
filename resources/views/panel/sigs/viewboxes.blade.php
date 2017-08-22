@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Edit page: {{ $sig->shortname }}</h2>
  {{ Html::link('/panel/sig/box/add/' . $sig->id, "Add Box",
                ["class" => "btn btn-default"])}}
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
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
      @if ($sig->boxes)
      @foreach ($sig->boxes as $box)
      <tr>
        <td>{{ $box->order }}</td>
        <td>{{ $box->title }}</td>
        <td>{{ $box->status() }}</td>
        <td class="hide-this">{{ $box->created_at }}</td>
        <td class="hide-this">{{ $box->updated_at }}</td>
        <td>{{ Html::link('/panel/sig/box/edit/' . $box->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/sig/box/move/up/' . $box->id,
                          "Move Up", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/sig/box/move/down/' . $box->id,
                          "Move Down", ["class" => "btn btn-primary"])}}</td>
        <td>
            @if ($box->status() === "Enabled")
            {{ Html::link('/panel/sig/box/toggle/' . $box->id,
                      "Disable", ["class" => "btn btn-warning"])}}
            @else
            {{ Html::link('/panel/sig/box/toggle/' . $box->id,
                      "Enable", ["class" => "btn btn-success"])}}
            @endif
        </td>
        <td>
             {{ Form::open(['action' => ['SigsController@deleteBox', $box->id],
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
      return confirm("Do you want to delete this box?");
 });
</script>
@endsection
