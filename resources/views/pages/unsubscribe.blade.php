@extends('layouts.master')
@section('content')

<h2 class='line-break'>Unsubscribe from mailing list</h2>
<p>Do you wish to remove your email address {{ Html::link('mailto:' . $subscription->email, $subscription->email) }} from the mailing list?</p>
<div class='pull-left margin-right line-break-top'>
  {{ Form::open(['action' => ['MailingController@removeSubscription', $subscription->id]]) }}
  {{ Form::submit("Yes, unsubscribe me", ["class" => "btn btn-danger"]) }}
  {{ Form::close() }}
</div>
<div class='pull-left margin-right line-break-top'>{{ Html::link('/', "No, keep my subscription", ["class" => "btn btn-primary"])}}</div>
@stop