@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>List of all emails</h2>

<table class='table'>
    <thead>
        <tr>
            <th>e-mail</th>
            <th>Joined on</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($mailingList as $record)
    <tr>
        <td>{{ $record['email'] }} </td>
        <td>{{ $record['created_at']    }}</td>
    </tr>    

    @endforeach
    
    </tbody>
</table>
 

@endsection