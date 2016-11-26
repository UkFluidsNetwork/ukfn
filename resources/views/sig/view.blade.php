@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>SIG Suggestions</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>SIG Title</th>
          <th>Contact</th>
          <th>Leader</th>
          <th>Organisation</th>
          <th class="hide-this">Contact Email Address</th>
          <th class="hide-this">Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($suggestions as $suggestion)
      <tr>
        <td>{{ $suggestion->id }}</td>
        <td>{{ $suggestion->suggestion }}</td>
        <td>{{ $suggestion->name }}</td>
        <td>{{ $suggestion->leader ? 'yes' : '-' }}</td>
        <td>{{ $suggestion->institution }}</td>
        <td class="hide-this">{{ Html::link('mailto:'.$suggestion->email, $suggestion->email)}}</td>
        <td class="hide-this">{{ $suggestion->created }}</td>
        <td>{{ $suggestion->updated }}</td>
        <td>{{ Html::link('/panel/suggestions/edit/' . $suggestion->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['SuggestionsController@delete', $suggestion->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection