@extends('layouts.master')
@section('content')

  <h2 class='line-break'>Special Interest Groups</h2>
  <div class="well">
    <p>
      UKFN is pleased to invite proposals for the first round of Special
      Interest Groups. The call is open to anyone working in fluid mechanics
      in the UK. The following pdf gives the context of the call and sets out
      the information you need to provide in your proposal:
    </p>
    <p>
      <a href="{{ asset('files/UKFN_SIGs_call_for_proposals.pdf') }}">[UKFN_SIGs_call_for_proposals.pdf]</a>
    </p>
    <p>
      The closing date is 31st Oct 2016.
    </p>
  </div>
         
  @include('sig.suggestions')
@endsection