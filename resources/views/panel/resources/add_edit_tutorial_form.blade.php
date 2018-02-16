@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
<script src="{{ asset('/js/moment.js')}}"></script>
<link href="{{ asset('css/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>

@endsection

{!! Form::hidden('user_id', Auth::user()->id) !!}
{!! Form::hidden('resource_id', $resource->id) !!}

<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>

	{!! Form::label('name', 'Title:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class='col-lg-8'>
        {!! Form::text('name', $tutorial->name, ['class' => 'form-control',
                'placeholder' => 'The title of the tutorial']) !!}

        @if ($errors->has('name'))
        <span class="text-danger">
            <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('author') ? ' has-error line-break-dbl' : '' }}'>

	{!! Form::label('author', 'Author(s):',
  ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class='col-lg-8'>
        {!! Form::text('author', $tutorial->author, ['class' => 'form-control',
                'placeholder' => 'The author(s) of the tutorial']) !!}

        @if ($errors->has('author'))
        <span class="text-danger">
            <span>{{ $errors->first('author') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('date') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('date', 'Year:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
        <div class='input-group date' id='date'>
            {!! Form::text('date', $tutorial->date, ['class' => 'form-control', 'data-date-format' => 'YYYY', 'placeholder' => 'The publication year of the tutorial']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    @if ($errors->has('date'))
    <span class="text-danger">
      <span>{{ $errors->first('date') }}</span>
    </span>
    @endif
  </div>
</div>

<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
      {!! Form::textarea('description', $tutorial->description,
      ['class' => 'form-control',
      'placeholder' => 'The description of the tutorial']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>


<div class=' col-lg-offset-2 col-lg-8'>
  	<div class='form-group line-break-dbl-top'>
    	{!! Form::submit('Save', ['class' => 'btn btn-success btn-lg2']) !!}
  	</div>
</div>

<script>
    $('.tags').selectize({
        plugins: ['remove_button', 'optgroup_columns'],
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            };
        }
    });
</script>
<script type="text/javascript">
    $(function () {
        $('#date').datetimepicker();
    });
</script>
<style>
    .selectize-dropdown-content {
        max-height: 666px !important;
    }

    .optgroup {
        width : 300px !important;
        height : auto !important;
        padding-bottom: 50px !important;
        float: left !important;
        border: none !important;
    }

    .optgroup-header {
        font-size:1.5em !important;
    }
</style>