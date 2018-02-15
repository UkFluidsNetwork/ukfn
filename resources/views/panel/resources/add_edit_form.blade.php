@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
@endsection

{!! Form::hidden('user_id', Auth::user()->id) !!}


<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>

	{!! Form::label('name', 'Title:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class='col-lg-8'>
        {!! Form::text('name', $resource->name, ['class' => 'form-control',
                'placeholder' => 'The title of the resource']) !!}

        @if ($errors->has('name'))
        <span class="text-danger">
            <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
    </div>
</div>

@if (Auth::user()->isAdmin())
<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
      {!! Form::textarea('description', $resource->description,
      ['class' => 'form-control',
      'placeholder' => 'The description of the resource']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>
@endif

<div class="form-group {{ $errors->has('disciplines') ? ' has-error' : ''}}">
    <label for="disciplines" class="control-label col-lg-2 text-left">Fluids sub-disciplines</label>
    <div class=' col-lg-8'>
        <select id="disciplines" type="text" class="tags form-control multi plugin-optgroup_columns" name="disciplines[]" placeholder="Fluids sub-disciplines" multiple>
            @foreach($subDisciplines as $key => $discipline)
            @if ($curDisciplinesCategory !== $discipline->category)
            <optgroup label="{{$discipline->category}}">
                {{$curDisciplinesCategory = $discipline->category}}
                @endif
                <option {{ in_array($discipline->id, $resourceTags) ? 'selected' : '' }} value='{{ $discipline->id}}'>{{ $discipline->name}}</option>
                @if ($discipline === end($subDisciplines)) || ($curDisciplinesCategory !== $subDisciplines[$key+1]->category)
            </optgroup>
            @endif
            @endforeach
        </select>
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