@extends('layouts.admin')
@section('admincontent')

    <h2 class='line-break'>Edit RSS Feed: {{ $aggregator->name }}</h2>

    {!! Form::model($aggregator, [
    'method' => 'PATCH',
    'action' => ['AggregatorsController@update', $aggregator->id],
    'class' => 'form-horizontal'
    ]) !!}
    <div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('name', 'Name:', ['class' => 'control-label col-lg-2 text-left']) !!}
      <div class=' col-lg-8'>
        {!! Form::text('name', $aggregator->name, ['class' => 'form-control','placeholder' => 'The name of aggregator']) !!}
        @if ($errors->has('name'))
        <span class="text-danger">
          <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
      </div>
    </div>
    <div class='form-group {{ $errors->has('longname') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('longname', 'Long Name:', ['class' => 'control-label col-lg-2 text-left']) !!}
      <div class=' col-lg-8'>
        {!! Form::text('longname', $aggregator->longname, ['class' => 'form-control','placeholder' => 'The long name of aggregator']) !!}
        @if ($errors->has('longname'))
        <span class="text-danger">
          <span>{{ $errors->first('longname') }}</span>
        </span>
        @endif
      </div>
    </div>
    <div class=' col-lg-offset-2 col-lg-8'>
      <div class='form-group line-break-dbl-top'>
        {!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
      </div>    
    </div>
    {!! Form::close() !!}
@endsection