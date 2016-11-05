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
            <div class="col-lg-2 col-md-2">
                @include('panel.membermenu')
            </div>
            <div class="col-lg-10 col-md-10">
                @yield('membercontent')
            </div>
        </div>
    </div>
    
@endsection