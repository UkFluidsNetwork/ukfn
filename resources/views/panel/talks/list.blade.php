@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>Talks</h2>
    
<section class="page-header">    
    <table class="table">
        <thead>
            <tr>
                <th class="col-lg-6">Title</th>
                <th class="col-lg-4">When</th>
                <th class="col-lg-2" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($talks as $talk)
            <tr>
                <td>
                    {{ $talk->title }}
                </td>
                <td>
                    {{ $talk->when }}
                </td>
                <td>
                    {{ Html::link('/panel/talks/edit/' . $talk->id , 'Edit', ['class' => 'btn btn-primary']) }}
                </td>
                <td>
                    {{ Form::open(['action' => ['TalksController@delete', $talk->id]]) }}
                    {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
                    {{ Form::close() }}
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>

@endsection 