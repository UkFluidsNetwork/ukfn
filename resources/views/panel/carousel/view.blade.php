@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Homepage Carousel</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($carousels as $carousel)
      <tr>
        <td>{{ $carousel->id }}</td>
        <td>{{ $carousel->name }}</td>
        <td>{{ $carousel->created }}</td>
        <td>{{ $carousel->updated }}</td>
        <td>{{ Html::link('/panel/carousel/edit/' . $carousel->id,
                          "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' =>
                            ['PagesController@deleteCarousel', $carousel->id],
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
