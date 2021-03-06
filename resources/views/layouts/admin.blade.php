@extends('layouts.master')
@section('content')
@include('flash.success')

<ol class="breadcrumb">
    @foreach($bread as $key => $crumb)
    @if($key < $breadCount - 1)

    <li>{{ Html::link($crumb['path'], $crumb['label']) }}</li>
    @else

    <li class='active'>{{ $crumb['label'] }}</li>
    @endif
    @endforeach

</ol>

<div class="container-fluid nopadding">
    <div class="row">
        @if (Auth::user()->isAdmin())

        <div class="col-lg-2 col-md-2">
            @include('panel.menu')
        </div>
        @elseif (Auth::user()->isSigEditor())
        <div class="col-lg-2 col-md-2">
            @include('panel.menu_leader')
        </div>
        @endif
        <div class="col-lg-10 col-md-10">
            @yield('admincontent')
        </div>
    </div>
</div>

@endsection
