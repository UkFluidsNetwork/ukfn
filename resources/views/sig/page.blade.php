@extends('layouts.master')
@section('content')

<div class="container-fluid nopadding-left">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div id="sig-image" class="carousel">
                <div class="carousel-inner">
                    <div class="item active">
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
                @if (false) <!-- FIXME -->
                    <a title="SIG map" class="up carousel-control"
                       href="{{$mapSigPath}}">
                        <span class="glyphicon glyphicon-chevron-up"></span>
                        <span class="sr-only">SIG map</span>
                    </a>
                @endif
                @if ($sig->url && false) <!-- FIXME -->
                    <a title="Home page" class="down carousel-control"
                       href="{{$sig->url}}">
                        <span class="glyphicon glyphicon-chevron-down"></span>
                        <span class="sr-only">Home page</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
<h2>{{ $sig->name }}</h2>
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
                <div class="bs-callout bs-callout-danger">
                    <h4>Join SIG Mailing list</h4>
                    <p>
                      <div class="input-group">
                        <label for="subscribe-sig-email"
                               class="sr-only">Subscribe</label>
                        <input type="text"
                               id="subscribe-sig-email"
                               class="form-control"
                               placeholder="your@email.com">
                        <span class="input-group-btn">
                          <button class="btn btn-default"
                                  type="button">Subscribe</button>
                        </span>
                      </div>
                    </p>
                </div>
                @if (!empty($sig->users))
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
                          (<i>{{ $member->institutions[0]->name }}</i>):
                          {{ Html::link('mailto:' . $member->email,
                                        $member->email) }}
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
