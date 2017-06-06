@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Subscriptions</h2>

<table class='table'>
    <thead>
        <tr>
            <th>e-mail</th>
            <th>Subscribed on</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

    @foreach ($mailingList as $record)
    <tr>
        <td>{{ $record->email }} </td>
        <td>{{ $record->created }}</td>
        <td>
             {{ Form::open(
                    ['action' => ['MailingController@deleteSubscription',
                                  $record->id],
                     'class' => 'delete']) }}
             {{ Form::submit("Delete", ["class" => "btn btn-danger"]) }}
             {{ Form::close() }}
        </td>
    </tr>

    @endforeach

    </tbody>
</table>

<script>
 $(".delete").on("submit", function(){
      return confirm("Do you want to delete this subscription?");
 });
</script>

@endsection
