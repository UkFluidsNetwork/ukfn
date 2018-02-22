@extends('layouts.master')
@section('content')
<style>
    .titleless {
        margin-top: 2.85em;
    }
</style>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<section class="page-header">
  <div class="line-break">
    <p>
      <a href="https://twitter.com/UKFluidsNetwork"
         class="twitter-follow-button"
         data-show-count="false"
         data-size="large">Follow @UKFluidsNetwork</a>
      <script async src="//platform.twitter.com/widgets.js" charset="utf-8">
      </script>

      <div class="fb-follow" data-href="https://www.facebook.com/UKFluids/" data-layout="button" data-size="large" data-show-faces="false"></div>

    </p>
  </div>
  <div>
    <p class="h4 text-danger">Contact us</p>
    <p class="line-break-dbl-top">
{!! Form::open(['url' => 'contact']) !!}
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
          <div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('name', 'Name :', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Your name']) !!}
            @if ($errors->has('name'))
              <span class="text-danger">
                <span>{{ $errors->first('name') }}</span>
              </span>
            @endif
          </div>
          <div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('email', 'Email :', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control','placeholder' => 'your@email.com']) !!}
            @if ($errors->has('email'))
              <span class="text-danger">
                <span>{{ $errors->first('email') }}</span>
              </span>
            @endif
          </div>
          <div class='form-group {{ $errors->has('message') ? ' has-error line-break-dbl' : '' }}'>
            {!! Form::label('message', 'Message :', ['class' => 'control-label']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control','placeholder' => 'Your message']) !!}
            @if ($errors->has('message'))
              <span class="text-danger">
                <span>{{ $errors->first('message') }}</span>
              </span>
            @endif
          </div>
          <div class='form-group line-break-dbl-top'>
            {!! Form::submit('Send Message', ['class' => 'btn btn-default btn-lg']) !!}
          </div>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
    </p>
  </div>
</section>
<section class="page-header">
<h3>Downloads</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top">UKFN logo</p>
    <ul class="line-break-dbl-top">
      <li>
        <a href="/pictures/ukfn-logo-250.png" target="_blank">
          UKFN logo 250x115
        </a>
      </li>
      <li>
        <a href="/pictures/ukfn-logo-500.png" target="_blank">
          UKFN logo 500x230
        </a>
      </li>
      <li>
        <a href="/pictures/ukfn-logo-1000.png" target="_blank">
          UKFN logo 1000x460
        </a>
      </li>
    </ul>
  </div>
</section>
<section class="page-header">
<h3>People</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top">Executive Committee</p>
    <p class="line-break-dbl-top">
    <div class="row">
        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/MJ_1.5_250h.jpg" alt="Prof. Matthew Juniper">
            <div class="caption">
              <h4>PI</h4>
              <p>
                <a href="http://www2.eng.cam.ac.uk/~mpj1001/MJ_biography.html"
                   target="_blank">
                       Prof. Matthew Juniper
                </a>
                  <br>
                  <i>University of Cambridge</i>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/ND_1.5_250h.jpg" alt="Dr Nick Daish">
            <div class="caption">
              <h4>Coordinator</h4>
              <p>
                <a href="http://www.eng.cam.ac.uk/profiles/ncd1"
                   target="_blank">
                       Dr Nick Daish
                </a>
                  <br>
                  <i>University of Cambridge</i>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/YH_1.5_250h.jpg"
                 alt="Prof. Yannis Hardalupas">
            <div class="caption">
              <h4>Executive Committee</h4>
              <p>
                <a href="https://www.imperial.ac.uk/people/y.hardalupas"
                   target="_blank">
                       Prof. Yannis Hardalupas
                </a>
                  <br>
                  <i>Imperial College London</i>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/AJ_1.5_250h.jpg" alt="Prof. Anne Juel">
            <div class="caption">
              <p class="titleless">
                <a href="http://www.maths.manchester.ac.uk/~ajuel/"
                   target="_blank">
                       Prof. Anne Juel
                </a>
                  <br>
                  <i>University of Manchester</i>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/PFL_1.5_250h.jpg" alt="Prof. Paul Linden">
            <div class="caption">
              <p class="titleless">
                <a href="http://www.damtp.cam.ac.uk/people/p.f.linden/"
                   target="_blank">
                       Prof. Paul Linden
                </a>
                  <br>
                  <i>University of Cambridge</i>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/NS_1.5_250h.jpg" alt="Prof. Neil Sandham">
            <div class="caption">
              <p class="titleless">
                <a href="http://www.southampton.ac.uk/engineering/about/staff/nds9.page"
                   target="_blank">
                       Prof. Neil Sandham
                </a>
                  <br>
                  <i>University of Southampton</i>
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-3">
          <div class="thumbnail">
            <img src="/pictures/ec/ST_1.5_250h.jpg" alt="Prof. Steve Tobias">
            <div class="caption">
              <p class="titleless">
                <a href="http://www1.maths.leeds.ac.uk/~smt/"
                   target="_blank">
                       Prof. Steve Tobias
                </a>
                  <br>
                  <i>University of Leeds</i>
              </p>
            </div>
          </div>
        </div>

    </div>
    </p>
  </div>

  <div>
    <p class="h4 text-danger line-break-dbl-top">Advisory Board</p>
    <p class="line-break-dbl-top">
    <ul>
        <li>Dr Simon Bittleston, <i>Schlumberger Gould Research</i></li>
        <li>Dr Ton van den Bremer, <i>University of Oxford</i></li>
        <li>Prof. GertJan van Heijst, <i>Burgerscentrum</i></li>
        <li>Prof. Ann Karagozian, <i>American Physical Society DFD and UCLA</i></li>
        <li>Dr David Standingford, <i>ERCOFTAC</i></li>
    </ul>
    </p>
  </div>

  <div>
    <p class="h4 text-danger line-break-dbl-top">Institutional points of contact</p>
    <p class="line-break-dbl-top">
    <ul class="line-break-dbl-top">
      <li>
      <a href="{{ asset('files/UKFN_instn_PoC_180123.1516953821.pdf') }}">List of points of contact</a>
      </li>
    </ul>
    </p>
  </div>
</section>

<section class="page-header">
<h3>Documents</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top">Minutes of meetings</p>
    <p class="line-break-dbl-top">
    <ul>
      <li>
        Executive Committee meeting, Friday 5 January 2018:
        [<a href="{{ asset('files/Agenda_050118_EC_Meeting.1516953872.pdf') }}">Agenda_050118_EC_Meeting.pdf</a>],
        [<a href="{{ asset('files/Minutes_050108_EC_Meeting.1516954009.pdf') }}">Minutes_050108_EC_Meeting.pdf</a>]
      </li>
      <li>
        Advisory Board meeting, Monday 27 November 2017:
        [<a href="{{ asset('files/meetings/Agenda_271117_AB_meeting.pdf') }}">Agenda_271117_AB_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_271117_AB_meeting.pdf') }}">Minutes_271117_AB_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 22 September 2017:
        [<a href="{{ asset('files/meetings/Agenda_220917_EC_meeting.pdf') }}">Agenda_220917_EC_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_220917_EC_meeting.pdf') }}">Minutes_220917_EC_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 30 June 2017:
        [<a href="{{ asset('files/meetings/Agenda_300617_EC_meeting.pdf') }}">Agenda_300617_EC_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_300617_EC_meeting.pdf') }}">Minutes_300617_EC_meeting.pdf</a>]
      </li>
      <li>
        Advisory Board meeting, Wednesday 29 March 2017:
        [<a href="{{ asset('files/meetings/Agenda_290317_AB_meeting.pdf') }}">Agenda_290317_AB_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_290317_AB_meeting.pdf') }}">Minutes_290317_AB_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Thursday 23 March 2017:
        [<a href="{{ asset('files/meetings/Agenda_230317_EC_meeting.pdf') }}">Agenda_230317_EC_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_230317_EC_meeting.pdf') }}">Minutes_230317_EC_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 11th November 2016:
        [<a href="{{ asset('files/meetings/Minutes_111116_EC_meeting.pdf') }}">Minutes_111116_EC_meeting.pdf</a>]
      </li>
      <li>
        Advisory Board meeting, Wednesday 21st September 2016:
        [<a href="{{ asset('files/meetings/Agenda_210916_AB_meeting.pdf') }}">Agenda_210916_AB_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_210916_AB_meeting.pdf') }}">Minutes_210916_AB_meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 9th September 2016:
        [<a href="{{ asset('files/meetings/Agenda_090916_EC_meeting.pdf') }}">Agenda_090916_EC_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_090916_EC_meeting.pdf') }}">Minutes_090916_EC_meeting.pdf</a>]
      </li>
    </ul>
    </p>
  </div>
@if($totalListEmails)
  <div>
    <p class="h4 text-danger line-break-dbl-top">List of emails sent to mailing list</p>
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
@endif
@if($totalPublicEmails)
  <div>
    <p class="h4 text-danger line-break-dbl-top">List of emails sent to all points of contact</p>
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
@endif
</section>

<section class="page-header">
<h3>Reference</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top">Communications</p>
    <ul class="line-break-dbl-top">
      <li>
        <a href="{{ asset('files/UKFN_comms_161024.pdf') }}">
          User guide to communications via the UKFN website
        </a>
      </li>
    </ul>
  </div>

  <div>
    <p class="h4 text-danger line-break-dbl-top">Set of values</p>
    <p class="line-break-dbl-top">
    <ul class="line-break-dbl-top">
      <li>
     <a href="{{ asset('files/UKFN_set_of_values_170110.pdf') }}">Set of values underpinning the running of the UK Fluids Network</a>
      </li>
    </ul>
    </p>
  </div>

  <div>
    <p class="h4 text-danger line-break-dbl-top">Proposal documents</p>
    <p class="line-break-dbl-top">
    <ul>
      <li><a href="{{ asset('files/UKFN_CfS_151020.pdf') }}">Case for Support</a></li>
      <li><a href="{{ asset('files/UKFN_CfS_Gantt_151102.pdf') }}">Workplan</a></li>
      <li><a href="{{ asset('files/UKFN_PtI__151020.pdf') }}">Pathways to Impact</a></li>
      <li><a href="{{ asset('files/UKFN_JoR_151020.pdf') }}">Justification of Resources</a></li>
    </ul>
    </p>
  </div>

  <div>
    <p class="h4 text-danger line-break-dbl-top">Grants on the Web</p>
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
@endsection
