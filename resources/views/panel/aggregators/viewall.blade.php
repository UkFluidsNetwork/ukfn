@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>RSS Feeds</h2>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="col-lg-1">ID</th>
                <th class="col-lg-3">Short Name</th>
                <th class="col-lg-6">Long Name</th>
                <th class="col-lg-2" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aggregators as $aggregator)
            <tr>
                <td>{{ $aggregator->id}}</td>
                <td>{{ $aggregator->name}}</td>
                <td>{{ $aggregator->longname}}</td>
                <td>{{ Html::link('/panel/talks/feeds/edit/' . $aggregator->id, "Edit", ["class" => "btn btn-primary"])}}</td>
                <td>
                    {{ Form::open(['action' => ['AggregatorsController@delete', $aggregator->id]]) }}
                    {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
                    {{ Form::close() }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection 