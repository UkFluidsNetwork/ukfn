@extends('layouts.master')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-0">
      <div class="panel panel-default">
        <div class="panel-heading">Register</div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('title_id') ? ' has-error' : '' }}">
              <label for="title_id" class="col-md-4 control-label">Title</label>

              <div class="col-md-6">
                <select id="title_id" type="text" class="form-control" name="title_id" value="{{ old('title_id') }}">
                  @foreach($titles as $title)
                  <option value='{{ $title->id }}'>{{ $title->name }}</option>
                  @endforeach
                </select>

                @if ($errors->has('title_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('title_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="form-group{{ $errors->has('title_id') ? ' has-error' : '' }}">
              <label for="title_id" class="col-md-4 control-label">Title</label>

              <div class="col-md-6">
                <select id="disciplines" type="text" class="form-control" name="disciplines" value="{{ old('disciplines') }}">
                  @foreach($subDisciplines as $discipline)
                  <option value='{{ $discipline->id }}'>{{ $discipline->name }}</option>
                  @endforeach
                </select>

                @if ($errors->has('disciplines'))
                <span class="help-block">
                  <strong>{{ $errors->first('disciplines') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
              <label for="surname" class="col-md-4 control-label">Surname</label>

              <div class="col-md-6">
                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}">

                @if ($errors->has('surname'))
                <span class="help-block">
                  <strong>{{ $errors->first('surname') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
              <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-btn fa-user"></i> Register
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
