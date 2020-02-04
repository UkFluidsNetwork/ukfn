@extends('layouts.master')

@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
<script src="{{ asset('js/angular.min.js')}}"></script>
<script src="{{ asset('js/angular-messages.min.js')}}"></script>
<script src="{{ asset('js/ngStorage.min.js')}}"></script>
<script src="{{ asset('js/ng-map.min.js')}}"></script>
<script src="{{ asset('js/angApp.js')}}"></script>
<script src="{{ asset('js/selectize.js')}}"></script>
<script src="{{ asset('js/angularjs-dropdown-multiselect.min.js')}}"></script>
<script src="{{ asset('js/ecCtrl.js')}}"></script>
@endsection

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


@if ($boxes)
@foreach ($boxes as $box)
<section class="page-header">
<div>
    <h3>{{ $box->title }}</h3>
    @if ($box->title == "People")
    <div ng-app="ukfn"
        ng-controller="ecController as ecCtrl"
        ng-init="ecCtrl.initialise();">
      <p class="h4 text-danger line-break-dbl-top">Executive Committee</p>
      <p class="line-break-dbl-top">
      <div class="row" ng-show="ecCtrl.thisMembers.length > 0">
          <div class="col-sm-5 col-md-3" ng-repeat="member in ecCtrl.thisMembers">
            <div class="thumbnail">
              <img src="@{{ member.photo }}" alt="@{{ member.fullname }}">
              <div class="caption">
                <h4 ng-if="member.role">@{{ member.role }}</h4>
                <p ng-class="{'titleless': !member.role }">
                  <a href="@{{ member.homepage }}"
                    target="_blank"
                    ng-if="member.homepage">
                        @{{ member.fullname }}
                  </a>
                    <span ng-if="!member.homepage">@{{ member.fullname }}</span>
                    <br>
                    <i>@{{ member.institutions }}</i>
              </div>
            </div>
          </div>
      </div>
      </p>
    </div>
    @endif
    {!! $box->content !!}
    @if ($box->title == "Documents")
    @if($totalListEmails)
      <div>
        <p class="h4 text-danger line-break-dbl-top">List of emails sent to mailing list</p>
        <p class="line-break-dbl-top">
        <a href="https://lists.fluids.ac.uk/pipermail/all/">Mailman archive</a>
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
    @endif
</div>
</section>
@endforeach
@endif

@endsection
