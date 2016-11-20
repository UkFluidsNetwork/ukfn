@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>{{ $tagtype }} tags</h2>
  <div class="table-responsive">
    @if (!empty($tags))
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          @if ($tagtype === "All")
          <th>Type</th>
          @endif
          <th class="hide-this">Category</th>
          <th class="hide-this">Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($tags as $tag)
      <tr>
        <td>{{ $tag->id }}</td>
        <td>{{ $tag->name }}</td>
        @if ($tagtype === "All")
        <td>{{ isset($tag->tagtype) ? $tag->tagtype['name'] : '' }}</td>
        @endif
        <td class="hide-this">{{ $tag->category }}</td>
        <td class="hide-this">{{ $tag->created }}</td>
        <td>{{ $tag->updated }}</td>
        <td>{{ Html::link('/panel/tags/edit/' . $tag->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['TagsController@delete', $tag->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
    @else
    No records were found.
    @endif
  </div>
@endsection