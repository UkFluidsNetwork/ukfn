@extends('layouts.admin')
@section('admincontent')

  <h2 class='line-break'>SIG</h2>
  <div class="table-responsive">
    <table class='table' id="view_sigs_suggestions">
      <thead>
        <tr>
          <th>ID</th>
          <th>SIG</th>
          <th class="hide-this">Institution</th>
          <th class="hide-this">Created</th>
          <th>Updated</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($sigs as $sig)
      <tr>
        <td>{{ $sig->id }}</td>
        <td>{{ $sig->name }}</td>
        <td class="hide-this">
            @foreach ($sig->institutions as $key => $institution)
            @if ($key < count($sig->institutions) - 1)
            {{ Html::link('/panel/institutions/edit/' . $institution['id'], $institution['name'])}},
            @else
            {{ Html::link('/panel/institutions/edit/' . $institution['id'], $institution['name'])}}
            @endif
            @endforeach
        </td>
        <td class="hide-this">{{ $sig->created }}</td>
        <td>{{ $sig->updated }}</td>
        <td>{{ Html::link('/panel/sig/edit/' . $sig->id, "Edit", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/sig/members/' . $sig->id, "Members", ["class" => "btn btn-primary"])}}</td>
        <td>{{ Html::link('/panel/sig/subscriptions/' . $sig->id,
               "Subscriptions", ["class" => "btn btn-primary"])}}</td>
        <td>
             {{ Form::open(['action' => ['SigsController@delete', $sig->id]]) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
@endsection
