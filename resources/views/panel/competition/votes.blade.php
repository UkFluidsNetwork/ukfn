@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>Votes {{ Html::link('/panel/competition/votes/export/', "Export", ["class" => "btn btn-default pull-right"])}}</h2>
  
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>Entry ID</th>
          <th>Entry type</th>
          <th>Entry title</th>
          <th>Email</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($votes as $vote)
      <tr>
        <td>{{ $vote->entry->id }}</td>
        <td>{{ $vote->type }}</td>
        <td>{{ $vote->entry->name }}</td>
        <td>{{ $vote->email }}</td>
        <td>{{ $vote->created }}</td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
