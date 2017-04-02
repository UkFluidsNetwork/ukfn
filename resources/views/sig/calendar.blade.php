@extends('layouts.master')
@section('content')
@include ('flash.success')

<h2 class='line-break full-width'>
    Calendar of SIG meetings
    <a href="/sig/" class="pull-right btn btn-default">
        SIG Map
    </a>
</h2>

<div id="google_calendar">
    
<iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;height=600&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=ce7h79qrsq4a9degfo9khe0tbk%40group.calendar.google.com&amp;color=%2329527A&amp;ctz=Europe%2FLondon"
        style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div>

@endsection
