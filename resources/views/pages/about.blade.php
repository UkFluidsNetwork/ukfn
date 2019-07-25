@extends('layouts.master')
@section('content')
<style>
    .titleless {
        margin-top: 2.85em;
    }
    div:target {
        padding-top: 60px;
        margint-top: -60px;
    }
</style>

<div class="well responsive">
  <p>
    Fluid mechanics underpins many established and emerging UK industries as
    well as critical societal issues such as air pollution,
    energy consumption, climate science, biology and medicine.
    Fluid mechanics is particularly strong in the UK, with world-class
    activity at several dozen institutions, involving hundreds of
    scientists and engineers. These institutions and individuals need to work
    together in order to benefit from the recent trend towards funding
    a small number of large grants. If you have any questions or suggestions,
    please {{ Html::link('/contact', 'contact us') }}.
  </p>
  <div id="well-col-1">
    The aims of the UK Fluids Network are to:
    <ul>
        <li>
           develop cross-institution bottom-up research programs and proposals;
        </li>
        <li>
          promote links with researchers and organisations in Europe and beyond;
        </li>
        <li>
          provide resources to the research community worldwide;
        </li>
        <li>
           act as a broker between UK academics and industry.
        </li>
    </ul>
  </div>
  <div id="well-col-2">
    The UKFN funds:
    <ul>
        <li>Special Interest Groups (SIGs);</li>
        <li>Short Research Visits (SRVs);</li>
        <li>
            a website containing resources for all fluid mechanics researchers.
        </li>
    </ul>
  </div>
  <div id="well-col-3">
    We encourage you to join the network and to play a part by:
    <ul>
        <li>signing up for the monthly newsletter</li>
        <li>
           registering your expertise in our searchable database of researchers;
        </li>
        <li>joining a Special Interest Group by emailing the SIG leader;</li>
        <li>contributing talks or researcher resources.</li>
    </ul>
  </div>
</div>

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

<div id="competition"></div>

<section class="page-header">
    <h3>Competitions</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top"><span class="label label-new label-ukfn-blue pull-left margin-right">
          New
      </span> Photo and Video Competition #6: Complex Fluids
    </p>
    <p>
        The UK Fluids Network presents a new competition, open to all UK-based fluids researchers, for the best new photo and video in Fluid Mechanics on the theme <b>‘Complex Fluids’</b>.
    </p>
    <p>How to enter:</p>
    <ul>
      <li>You must be a UK-based fluid mechanics researcher, i.e. at a university, research institute, or company</li>
      <li>Email photos directly to <a href="mailto:competition@fluids.ac.uk">competition@fluids.ac.uk</a>. Submit videos by giving a link to a suitable data-sharing website, e.g. Dropbox.</li>
      <li>
        In both cases, the covering email must contain the following information:
        <ol type="a">
          <li>Name and affiliation</li>
          <li>Title (max 10 words)</li>
          <li>Description, including whether (for photos) the image is a composite or has been enhanced (max 50 words)</li>
          <li>Keywords (max 5)</li>
          <li>A statement granting non-exclusive use of the media:
            <p>
“I have checked with my [supervisor/manager/sponsor] __________________ that I have permission to enter the proposed photo(s)/video(s) in the competition and give the UK Fluids Network the right to publish them on its website and elsewhere.”
            </p>
          </li>
          <li>Whether the photo/video has won other competitions</li>
          <li>Any due acknowledgements</li>
        </ol>
      </li>
    </ul>
    <p>
        <b>The closing date for entries is 31 July 2019.</b>
    </p>
  </div>
  <div>
    <p class="h4 text-danger line-break-dbl-top">UK Fluids Network Thesis Prize</p>
    <p>
      <b>2019 Thesis Prize</b><br><br>
      Winner:<br>
      Adrien Lefauve (University of Cambridge): 'Waves and turbulence in sustained stratified shear flows'<br><br>
      Runners-up:<br>
      Paweł Baj (Imperial College London): 'Experimental investigation of wake development and mixing behind a multi-scale array of bars'<br>
      Matthew Arran (University of Cambridge): 'Avalanching on dunes and its effects: Size statistics, stratification, & seismic surveys'
    </p>
    <br>
    <p>
      <b>2018 Thesis Prize</b><br><br>
      Winner:<br>
      Yi Man (University of Cambridge): ‘Swimming at low Reynolds number: slip boundaries and interacting filaments’<br><br>
      Runners-up:<br>
      Rowan Brackston (Imperial College London): ‘Feedback control of three-dimensional bluff body wakes for efficient drag reduction’<br>
      Simeng Chen (University of Liverpool): ‘An experimental investigation of drop impact phenomena with complex fluids on heated and soft surfaces’<br>
    </p>
  </div>
  <div>
    <p class="h4 text-danger line-break-dbl-top">Photo and Video Competition Archive</p>
    <ul>
        <li>
            #5: Instability:
            [<a href="{{ asset('files/06_Naresh_Sampara_Farday_v2_1024w.1543871153.png') }}">Winner Photo</a>],
            [<a href="https://upload.sms.cam.ac.uk/media/2877076/embed">Winner Video</a>]
        </li>
        <li>
            #4: Open Competition (no theme):
            [<a href="{{ asset('files/williams_2-up.1562826471.jpg') }}">Winner Photo</a>],
            [<a href="https://upload.sms.cam.ac.uk/media/2803180/embed">Winner Video</a>]
        </li>
        <li>
            #3: "The invisible made visible: uncovering hidden patterns, trends and structures":
            [<a href="{{ asset('files/08_Photo_180331.1522825653.png') }}">Winner Photo</a>],
            [<a href="https://upload.sms.cam.ac.uk/media/2718159/embed">Winner Video</a>]
        </li>
        <li>
            #2: "The interface between solid and fluid mechanics":
            [<a href="{{ asset('files/14_Cuttle_truncated.1523960594.png') }}">Winner Photo</a>],
            [<a href="https://upload.sms.cam.ac.uk/media/2618474/embed">Winner Video</a>]
        </li>
        <li>
            #1: Open Competition (no theme):
            [<a href="{{ asset('pictures/competition/3-double-diffusive_instabilit.jpg') }}">Winner Photo</a>],
            [<a href="https://sms.cam.ac.uk/media/2532068/embed">Winner Video</a>]
        </li>
    </ul>
  </div>
</section>

<section class="page-header">
<h3>Documents</h3>
  <div>
    <p class="h4 text-danger line-break-dbl-top">Minutes of meetings</p>
    <p class="line-break-dbl-top">
    <ul>
      <li>
        Executive Committee meeting, Thursday 17 January 2019:
        [<a href="{{ asset('files/meetings/Agenda_170119_EC_meeting.1549448885.pdf') }}">Agenda_170119_EC_meeting.pdf</a>],
        [<a href="{{ asset('files/meetings/Minutes_170119_EC_Meeting.1549448895.pdf') }}">Minutes_170119_EC_Meeting.pdf</a>]
      </li>
      <li>
        Executive Committee meeting, Friday 1 May 2018:
        [<a href="{{ asset('files/Agenda_010518_EC_Meeting.1543492837.pdf') }}">Agenda_010518_EC_Meeting.pdf</a>],
        [<a href="{{ asset('files/Minutes_010518_EC_Meeting.1543492854.pdf') }}">Minutes_010518_EC_Meeting.pdf</a>]
      </li>
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
