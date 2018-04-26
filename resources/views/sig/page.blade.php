@extends('layouts.master')
@section('content')

<div class="container-fluid nopadding-left">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div id="sig-image" class="carousel"  style="height: auto">
                <div class="carousel-inner">
                    <div class="item active" style="height: 370px">
                        @if ($sig->bigimage)
                            {{ Html::image(
                                "/pictures/sig/" . $sig->bigimage,
                                $sig->bigimage,
                                ['class' => 'sig-big-image']) }}
                        @elseif ($sig->smallimage)
                            {{ Html::image(
                                "/pictures/sig/" . $sig->smallimage,
                                $sig->smallimage,
                                ['class' => 'sig-big-image']) }}
                        @endif
                    </div>
                </div>
                <a title="Previous SIG" class="left carousel-control"
                   href="{{$prevSigPath}}">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a title="Next SIG" class="right carousel-control"
                   href="{{$nextSigPath}}">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
                <a title="SIG map" class="up carousel-control"
                    href="{{$mapSigPath}}">
                    <span class="glyphicon glyphicon-chevron-up"></span>
                    <span class="sr-only">SIG map</span>
                </a>
            </div>
        </div>
    </div>
</div>
<h2 id="sig-name">{{ $sig->name }}</h2>
<div class="container-fluid nopadding-left">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="sig-page">
                <div class="bs-callout bs-callout-danger">
                    <h4>Description</h4>
                    <p>
                        {{ $sig->description }}
                    </p>
                </div>

                @if ($sig->mailinglist)
                <div class="bs-callout bs-callout-danger" id="sig-subscription">
                    <h4>Join SIG Mailing list</h4>
                    <p>
                      {!! Form::open(['url' => 'subscribe-sig#sig-name']) !!}
                      <div class="input-group">
                        <input type="text" hidden="hidden" id="sig_id"
                               name="sig_id"
                               value="{{ $sig->id }}">
                        <label for="subscribe-sig-email"
                               class="sr-only">Subscribe</label>
                        <input type="text"
                               id="subscribe-sig-email"
                               name="subscribe-sig-email"
                               class="form-control"
                               placeholder="your@email.com">
                        <span class="input-group-btn">
                          <button class="btn btn-default"
                                  type="submit">Subscribe</button>
                        </span>
                      </div>
                        @if ($errors->has('subscribe-sig-email'))

                        <span class="display-block text-danger line-break-top">
                         <span>{{ $errors->first('subscribe-sig-email') }}</span>
                        </span>
                        @endif
                        @if (Session::has('sig_subscription_signup_ok'))

                        <strong class="display-block text-success
                                       line-break-top">
                            {{ Session::get('sig_subscription_signup_ok') }}
                        </strong>
                        @endif
                     {!! Form::close() !!}
                    </p>
                </div>
                @endif

                @if (!empty($sig->users) && !$sig->isExternal())
                <div class="bs-callout bs-callout-danger">
                    <h4>Members</h4>
                    <p class="small">
                      <i>L = leader; C = co-leader; * = Other key personnel</i>
                    </p>
                    <p>
                      <table>
                        @foreach ($sig->users as $member)
                        <tr>
                          <td>
                          @if ($member->isLeaderOfSig($sig->id))
                            <b>[L]</b>&nbsp;
                          @elseif ($member->isColeaderOfSig($sig->id))
                            <b>[C]</b>&nbsp;
                          @elseif ($member->isKeyPersonnelOfSig($sig->id))
                            <b>[*]</b>&nbsp;
                          @endif
                          </td>
                          <td>
                          @if ($member->url)
                          {{ Html::link($member->url,
                                    $member->name . " " . $member->surname) }}
                          @else
                          {{ $member->name }} {{ $member->surname }} 
                          @endif
                          @if (isset($member->institutions[0])
                               && ($member->isLeaderOfSig($sig->id)
                                || $member->isColeaderOfSig($sig->id)
                                || $member->isKeyPersonnelOfSig($sig->id)))
                          (<i>{{ $member->institutions[0]->name }}</i>):
                          {{ Html::link('mailto:' . $member->email,
                                        $member->email) }}
                          @elseif (isset($member->institutions[0]))
                          (<i>{{ $member->institutions[0]->name }}</i>)
                          @endif
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </p>
                </div>
                @endif
                @if ($sig->url)
                <div class="bs-callout bs-callout-danger">
                    <h4>External website</h4>
                    <p>
                        {{ Html::link($sig->url, $sig->url,
                                      ['class'=> '', 'target' => '_blank']) }}
                    </p>
                </div>
                @endif
                @if ($sig->activeBoxes)
                @foreach ($sig->activeBoxes as $box)
                <div class="bs-callout bs-callout-danger">
                    <h4>{{ $box->title }}</h4>
                    {!! $box->content !!}
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="bs-callout bs-callout-info">
                    <h4>
                        Tweets
                        <small class="text-muted pull-right">
                            {{ "@" . $sig->twitterurl}}
                        </small>
                    </h4>
                    @include('pages.tweets')
                </div>
        </div>
    </div>
</div>
@endsection
