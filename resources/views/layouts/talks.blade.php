@extends('layouts.master')
@section('content')

    <div class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                @yield('talkscontent')
            </div>
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1">
                @if (Request::is('talks/all'))
                    @include('talks.filterMenu')
                @else
                    @include('talks.menu')
                @endif
            </div>
        </div>
    </div>
@endsection