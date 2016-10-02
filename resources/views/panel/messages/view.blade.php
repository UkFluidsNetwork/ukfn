@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Messages</h2>

@foreach ($messages as $record)
<table class='table'>
  <thead>
    <tr>
      <th class='col-lg-2'>Sent on</th>
      <th class='col-lg-10'>{{ $record->date }}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Sent by</td>
      <td>{{ $record->sentBy }} </td>
    </tr>
    <tr>
      <td>From</td>
      <td>{{ $record->from }} </td>
    </tr>
    <tr>
      <td>To</td>
      <td>{{ $record->sentTo }}</td>
    </tr>
    <tr>
      <td>Subject</td>
      <td>{{ $record->subject }} </td>
    </tr>    
    <tr>
      <td>Body</td>
      <td>{!! $record->body !!} </td>
    </tr>
    @if ($record->attachment)
    <tr>
      <td>Attachment</td>
      <td>{{ Html::link('/files/attachments/'.$record->attachment , $record->attachment) }} </td>
    </tr>
    @endif
    <tr>
      <td>Visibility</td>
      <td>{{ $record->visibility }}</td>
    </tr>
  </tbody>
</table>
@endforeach
@endsection