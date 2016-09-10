@extends('layouts.master')
@section('content')

    <ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li class='active'>Admin</li>
    </ol>

    <div class="container-fluid nopadding">
        <div class="row">
            <div class="col-lg-2">
                @include('admin.menu')
            </div>
            <div class="col-lg-8">
                <h1>Welcome to the admin page</h1>
                <p>
                    You can blah blah Mebrillo
                </p>
            </div>
        </div>
    </div>
    
@endsection