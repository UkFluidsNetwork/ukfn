@extends('layouts.admin')
@section('admincontent')
<h2 class='line-break'>All Current Talks</h2>
    
<section class="page-header">    
    <table class="table">
        <thead>
            <tr>
                <th class="col-lg-7">Title</th>
                <th class="col-lg-4">When</th>
                <th class="col-lg-1">Acition</th>
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
            </tr>

            @endforeach
        </tbody>
    </table>
</section>

@endsection 