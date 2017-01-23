@extends('layouts.master')
@section('content')

@if ($sig->url)
<h3 class="text-danger line-break">{{ $sig->name }}{{ Html::link($sig->url, 'Visit page ', ['class'=> 'btn btn-default btn-lg text-uppercase pull-right', 'target' => '_blank']) }}</h3>
@else
<h3 class="text-danger line-break">{{ $sig->name }}</h3>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <ul class="nav nav-tabs nav-justified">
                <li id="sig-home-tab" role="presentation" class="sig-tab active"><a href="javascript:switchTab('sig-home');">Home</a></li>
                <li id="sig-members-tab" role="presentation" class="sig-tab"><a href="javascript:switchTab('sig-members');">Members</a></li>
            </ul>
            <div id="sig-members-page" class="sig-page hidden">
                @if (!empty($sig->users))
                <div class="bs-callout bs-callout-info">
                    <p>
                        @foreach ($sig->users as $member)
                        @if ($member->url)
                        {{ Html::link($member->url, $member->name . " " . $member->surname) }}
                        @else
                        {{ $member->name }} {{ $member->surname }} 
                        @endif
                        (<i>{{ $member->institutions[0]->name }}</i>):
                        {{ Html::link('mailto:' . $member->email, $member->email) }}<br>
                        @endforeach
                    </p>
                </div>
                @endif
            </div>
            <div id="sig-home-page" class="sig-page">
                <img style="width: 100%; margin-top: 20px;" src="/pictures/sig/{{ $sig->smallimage }}" class="thumb" alt="@{{ $sig->smallimage }}">
                <div class="bs-callout bs-callout-info">
                    <h4>Description</h4>
                    <p>
                        {{ $sig->description }}
                    </p>
                </div>
                @if (!empty($sig->leader) || !empty($sig->coleader))
                <div class="bs-callout bs-callout-info">
                    <h4>Key personnel</h4>
                    <p class="small"><i>L = leader; C = co-leader</i></p>
                    <p>
                        @if (!empty($sig->leader))
                        <b>[L]</b> {{ $sig->leader[0]->name }} {{ $sig->leader[0]->surname }} 
                        (<i>{{ $sig->leader[0]->institutions[0]->name }}</i>):
                        {{ Html::link('mailto:' . $sig->leader[0]->email, $sig->leader[0]->email) }}
                        <br>
                        @endif
                        @if (!empty($sig->coleaders))
                        @foreach ($sig->coleaders as $coleader)
                        <b>[C]</b> {{ $coleader->name }} {{ $coleader->surname }} 
                        (<i>{{ $coleader->institutions[0]->name }}</i>): 
                        {{ Html::link('mailto:' . $coleader->email, $coleader->email) }}<br>
                        @endforeach
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            @if (!empty($tweets))
            <h2>Tweets</h2>
            @foreach ($tweets as $key => $tweet)
            <div class="line-break-dbl"></div>
            <section class="page-header">
                <div class="line-break">
                    <div class="text-primary">
                        <strong class="panel-title">{{ $tweet['user'] }}</strong>
                    </div>
                    <div class="text-muted">{{ $tweet['date'] }}</div>
                </div>
                <p class="line-break">{!! $tweet['text'] !!}</p>
                <a href="{{ $tweet['link'] }}" target="_blank">View tweet</a>
            </section>
            @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    $(function () {
        var page = '<?php echo $page; ?>';
        if (page !== '') {
            switchTab('sig-<?php echo $page ?>');
        }
    });

    function switchTab(id) {
        $('.sig-page').addClass('hidden');
        $('.sig-tab').removeClass('active');
        $('#' + id + '-page').removeClass('hidden');
        $('#' + id + '-tab').addClass('active');
    }
</script>
@endsection
