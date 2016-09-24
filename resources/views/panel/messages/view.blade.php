@extends('layouts.admin')
@section('admincontent')

    <h2 class='line-break'>Messages</h2>

    @foreach ($messagesList as $record)
    <table class='table'>
        <thead>
            <tr>
                <th class='col-lg-2'>Created at</th>
                <th class='col-lg-10'>{{ $record['created_at'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>From</td>
                <td>{{ $record['from'] }} </td>
            </tr>
            <tr>
                <td>To</td>
                @if ($record['mailingList'] === '0')
                <td>
                @foreach(explode(';', $record['to']) as $email)     
                {{ $email }} <br>
                @endforeach
                </td>
                @else
                <td>{{ $record['to'] }}</td>
                @endif
            </tr>
            <tr>
                <td>Subject</td>
                <td>{{ $record['subject'] }} </td>
            </tr>    
            <tr>
                <td>Body</td>
                <td>{{ $record['body'] }} </td>
            </tr>
            <tr>
                <td>Visibility</td>
                <td>{{ $record['visibility'] }}</td>
            </tr>
        </tbody>
    </table>
    @endforeach
    


@endsection