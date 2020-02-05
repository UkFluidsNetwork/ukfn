@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Network News</h2>
  {{ Html::link('/panel/news/add/', "Add News",
                          ["class" => "btn btn-success"])}}
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Added by</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($news as $new)
      <tr>
        <td>{{ $new->id }}</td>
        <td>{{ $new->title }}</td>
        <td>{{ $new->user->name }} {{ $new->user->surname }}</td>
        <td>{{ $new->created }}</td>
        <td>{{ $new->updated }}</td>
        <td>{{ Html::link('/panel/news/edit/' . $new->id, "Edit",
                          ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['NewsController@delete', $new->id],
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
      return confirm("Do you want to delete this record?");
 });
</script>
@endsection
