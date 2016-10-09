@extends('layouts.master')
@section('content')

    <div class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                @yield('talkscontent')
            </div>
            <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1">
                @include('talks.menu')
            </div>
        </div>
    </div>
@endsection