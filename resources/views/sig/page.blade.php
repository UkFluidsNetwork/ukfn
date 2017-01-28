@extends('layouts.master')
@section('content')

<div id='sig-navigation'>
    @foreach ($navigation as $element)
    <nav aria-label="Page navigation" class="pull-{{ $element['position'] }}">
        <ul class="pagination">
            <li>
                <a href="{{ $element['path'] }}" aria-label="Previous">
                    <span class="glyphicon {{ $element['icon'] }}" aria-hidden="true"></span>
                </a>
            </li>
        </ul>
    </nav>
    @endforeach
</div>

<h2 class="text-danger line-break">
    {{ Html::link('/sig/map/' . $sig->shortname, '', ['class'=> 'text-danger glyphicon glyphicon-map-marker text-no-decoration']) }}
    {{ $sig->name }}
</h2>

<div class="container-fluid nopadding-left">
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
                @if ($sig->bigimage)
                <img style="width: 100%; margin-top: 20px;" src="/pictures/sig/{{ $sig->bigimage }}" class="thumb" alt="@{{ $sig->bigimage }}">
                @elseif ($sig->smallimage)
                <img style="width: 100%; margin-top: 20px;" src="/pictures/sig/{{ $sig->smallimage }}" class="thumb" alt="@{{ $sig->smallimage }}">
                @endif
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
                @if ($sig->url)
                <div class="bs-callout bs-callout-info">
                    <h4>External website</h4>
                    <p>
                        {{ Html::link($sig->url, $sig->url, ['class'=> '', 'target' => '_blank']) }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <h2 class="nomargin-top">Tweets</h2>
            @if (!empty($tweets))
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
            @else
            <div class="text-muted">No tweets to show</div>
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
        if (!id) {
            return;
        }
        $('.sig-page').addClass('hidden');
        $('.sig-tab').removeClass('active');
        $('#' + id + '-page').removeClass('hidden');
        $('#' + id + '-tab').addClass('active');
    }
</script>
@endsection
