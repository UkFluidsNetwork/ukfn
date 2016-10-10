@extends('layouts.master')
@section('content')

<h2 class='line-break'>Admin</h2>
<section class="page-header">
  <div>
    <p class="h4 text-danger">Grants on the Web</p>
    <p class="line-break-dbl-top">
      Web pages giving details of the EPSRC grant for UK Fluids Network.
      There are multiple entries because it was a joint proposal between Cambridge, ICL, Leeds, Manchester, and Southampton.
    <ul>
      <li>Cambridge: {{ Html::link('http://gow.epsrc.ac.uk/NGBOViewGrant.aspx?GrantRef=EP/N032861/1') }}</li>
      <li>ICL: {{ Html::link('http://gow.epsrc.ac.uk/NGBOViewGrant.aspx?GrantRef=EP/N032934/1') }}</li>
      <li>Leeds: {{ Html::link('http://gow.epsrc.ac.uk/NGBOViewGrant.aspx?GrantRef=EP/P000851/1') }}</li>
      <li>Manchester: {{ Html::link('http://gow.epsrc.ac.uk/NGBOViewGrant.aspx?GrantRef=EP/N032411/1') }}</li>
      <li>Southampton: {{ Html::link('http://gow.epsrc.ac.uk/NGBOViewGrant.aspx?GrantRef=EP/N032152/1') }}</li>
    </ul>
    </p>
  </div>
</section>
<section class="page-header">
  <div>
    <p class="h4 text-danger">Proposal documents</p>
    <p class="line-break-dbl-top">
    <ul>
      <li><a href="{{ asset('files/UKFN_CfS_151020.pdf') }}">Case for Support</a></li>
      <li><a href="{{ asset('files/UKFN_CfS_Gantt_151102.pdf') }}">Workplan</a></li>
      <li><a href="{{ asset('files/UKFN_PtI__151020.pdf') }}">Pathways to Impact</a></li>
      <li><a href="{{ asset('files/UKFN_JoR_151020.pdf') }}">Justification of Resources</a></li>
    </ul>
    </p>
  </div>
</section>
<section class="page-header">
  <div>
    <p class="h4 text-danger">Minutes of meetings</p>
    <p class="line-break-dbl-top">
    <ul>
      <li>
        Advisory Board meeting, Wednesday 21st September 2016: 
        [<a href="{{ asset('files/meetings/Agenda_210916_AB_meeting.pdf') }}">Agenda_210916_AB_meeting.pdf</a>], 
        [<a href="{{ asset('files/meetings/Minutes_210916_AB_meeting.pdf') }}">Minutes_210916_AB_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 9th September 2016: 
        [<a href="{{ asset('files/meetings/Agenda_090916_EC_meeting.pdf') }}">Agenda_090916_EC_meeting.pdf</a>], 
        [<a href="{{ asset('files/meetings/Minutes_090916_EC_meeting.pdf') }}">Minutes_090916_EC_meeting</a>]
      </li>
    </ul>
    </p>
  </div>
</section>
<section class="page-header">
  <div>
    <p class="h4 text-danger">Institutional points of contact</p>
    <p class="line-break-dbl-top">
      <a href="{{ asset('files/UKFN_instn_PoC_160921.pdf') }}">List of points of contact</a>
    </p>
  </div>
</section>
<section class="page-header">
  <div>
    <p class="h4 text-danger">Communications</p>
    <p class="line-break-dbl-top">
      User guide to communications via the UKFN website <span class="text-muted">(pending)</span>
    </p>
  </div>
</section>
@if($totalListEmails)
<section class="page-header">
  <div>
    <p class="h4 text-danger">Records of emails sent to mailing list</p>
    <p class="line-break-dbl-top">
    <ul>
      @foreach ($listEmails as $message)
      <li>
          {{ $message->date }}, {{ Html::link('/viewmessage/' . $message->id, $message->subject) }} 
          @if ($message->attachment)
            <icon class='glyphicon glyphicon-paperclip'></icon>
          @endif
      </li>
      @endforeach
    </ul>
    </p>
  </div>
</section>
@endif
@if($totalPublicEmails)
<section class="page-header">
  <div>
    <p class="h4 text-danger">Records of emails sent to all points of contact</p>
    <p class="line-break-dbl-top">
    <ul>
      @foreach ($publicEmails as $message)
      <li>
          {{ $message->date }} - {{ Html::link('/viewmessage/' . $message->id, $message->subject) }} 
          @if ($message->attachment)
            <icon class='glyphicon glyphicon-paperclip'></icon>
          @endif
      </li>
      @endforeach
    </ul>
    </p>
  </div>
</section>
@endif
@endsection