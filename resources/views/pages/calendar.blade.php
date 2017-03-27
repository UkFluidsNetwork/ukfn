@extends('layouts.master')
@section('content')
@include ('flash.success')

<h2 class='line-break'>Calendar</h2>

<div id="google_calendar">
    
<iframe src="https://calendar.google.com/calendar/embed?src=4utcij1bn8htlmec7094it7980%40group.calendar.google.com&ctz=Europe/London" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div>

@endsection
