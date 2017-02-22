@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Events (What's on)</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Date</th>
          <th>Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($events as $event)
      <tr>
        <td>{{ $event->id }}</td>
        <td>{{ $event->title }}</td>
        <td>{{ $event->date }}</td>
        <td>{{ $event->created }}</td>
        <td>{{ $event->updated }}</td>
        <td>{{ Html::link('/panel/events/edit/' . $event->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['EventsController@delete', $event->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection