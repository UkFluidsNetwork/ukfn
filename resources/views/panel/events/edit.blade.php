@extends('layouts.admin')

@section('head')
<script src="{{ asset('/js/moment.js')}}"></script>
<link href="{{ asset('css/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>

<script type="text/javascript">
    $(function () {
        $('#event_start').datetimepicker();
        $('#event_end').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
    });
</script>

@endsection

@section('admincontent')

<h2 class='line-break'>Edit: {{ $event->title }}</h2>

{!! Form::model($event, [
'method' => 'PATCH',
'action' => ['EventsController@update', $event->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('title', $event->title, ['class' => 'form-control','placeholder' => 'The header of the event']) !!}
    @if ($errors->has('title'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('subtitle') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('subtitle', 'Subtitle:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('subtitle', $event->subtitle, ['class' => 'form-control','placeholder' => 'To appear next to the date']) !!}
    @if ($errors->has('subtitle'))
    <span class="text-danger">
      <span>{{ $errors->first('title') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
    {!! Form::textarea('description', $event->description, ['class' => 'form-control','placeholder' => 'The body of the event']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('start') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('', 'Start DateTime:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
        <div class='input-group date' id='event_start'>
            {!! Form::text('start', $event->start, ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD HH:mm', 'placeholder' => 'The date and time the event takes place (yyyy-mm-dd h:m:s)']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    @if ($errors->has('start'))
    <span class="text-danger">
      <span>{{ $errors->first('start') }}</span>
    </span>
    @endif
  </div>
</div>
<div class='form-group {{ $errors->has('end') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('', 'End DateTime:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
        <div class='input-group date' id='event_end'>
            {!! Form::text('end', $event->end, ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD HH:mm', 'placeholder' => 'If date range']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    @if ($errors->has('end'))
    <span class="text-danger">
      <span>{{ $errors->first('end') }}</span>
    </span>
    @endif
  </div>
</div>
<div class=' col-lg-offset-2 col-lg-8'>
  <div class='form-group line-break-dbl-top'>
    {!! Form::submit('Save', ['class' => 'btn btn-default btn-lg2']) !!}
  </div>    
</div>
{!! Form::close() !!}

@endsection
