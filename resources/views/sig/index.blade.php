@extends('layouts.master')
@section('content')
@include('flash.success')
  <h2 class='line-break'>Special Interest Groups</h2>
  <div class="well">
    <p>
      UKFN is pleased to invite proposals for the first round of Special Interest Groups. 
      The call is open to anyone working in fluid mechanics in the UK. 
      The following pdf gives the context of the call and sets out the information you need to provide in your proposal:
    </p>
    <p>
      <a href="{{ asset('files/UKFN_SIGs_1st_call_for_proposals_Rev.160922.pdf') }}">[UKFN_SIGs_1st_call_for_proposals_Rev.160922.pdf]</a><br>
      This is a revised version of the call (22/9/16): the changes, shown in red, were made following discussion with the Executive Committee and Advisory Board.
      Note in particular that additional information on funding is now required in the proposal.
    </p>
    <p>
      The closing date is 31st Oct 2016.
    </p>
    <p>
      The score sheet that will be used when assessing the proposals is here: <br>
      <a href="{{ asset('files/SIG_score_sheet_1st_call.xlsx') }}">[SIG_score_sheet_1st_call.xlsx]</a>
    </p>
  </div>
         
  @include('sig.suggestions')
@endsection