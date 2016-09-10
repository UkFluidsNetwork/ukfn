@extends('layouts.master')
@section('content')

    <ol class="breadcrumb">
    @foreach($bread as $key => $path)
    @if($key < $breadCount - 1)
        <li>{{ Html::link($path['path'], $path['label']) }}</li>
    @else
    <li class='active'>{{ $path['label'] }}</li>
    @endif
    @endforeach
    </ol>
      
          

    <div class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-2">
                @include('admin.menu')
            </div>
            <div class="col-lg-10">
                @yield('admincontent')
            </div>
        </div>
    </div>
    
@endsection