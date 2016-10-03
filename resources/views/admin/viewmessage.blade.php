@extends('layouts.master')
@section('content')

@if($message->mailinglist)
<h2 class='line-break'>Message sent to UKFN mailing list</h2>
@elseif($message->public)
<h2 class='line-break'>Message sent to UKFN points of contact</h2>
@endif
<section class="page-header">
  <div class="line-break">
    <div class="text-danger">
      <strong class="panel-title">{{ $message->subject }}</strong>
    </div>
    <div class="text-muted">{{ $message->date }}</div>
    
    <div class='line-break-top'>
    @if ($message->attachment)
        {{ Html::link('/files/attachments/' . $message->attachment, $message->attachment) }}        
        <icon class='glyphicon glyphicon-paperclip'></icon>
    @endif
    </div>
  </div>
  <p>{!! $message->text !!}</p>
</section>

@endsection