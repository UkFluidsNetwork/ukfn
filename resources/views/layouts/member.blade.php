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
            <div class="col-lg-12 col-md-12">
                @yield('membercontent')
            </div>
        </div>
    </div>
    
@endsection