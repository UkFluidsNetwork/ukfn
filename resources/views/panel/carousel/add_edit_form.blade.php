@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
@endsection

<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>

	{!! Form::label('name', 'Title:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class='col-lg-8'>
        {!! Form::text('name', $carousel->name, ['class' => 'form-control',
                'placeholder' => 'The title of the entry']) !!}

        @if ($errors->has('name'))
        <span class="text-danger">
            <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('author')
    ? ' has-error line-break-dbl' : '' }}'>

	{!! Form::label('author', 'Author:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class='col-lg-8'>
        {!! Form::text('author', $carousel->author, ['class' => 'form-control',
                'placeholder' => 'The author of the entry']) !!}

        @if ($errors->has('author'))
        <span class="text-danger">
            <span>{{ $errors->first('author') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('description')
    ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('description', 'Description:',
  ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class='col-lg-8'>
      {!! Form::textarea('description', $carousel->description,
      ['class' => 'form-control',
      'placeholder' => 'The description of the resource']) !!}
    @if ($errors->has('description'))
    <span class="text-danger">
      <span>{{ $errors->first('description') }}</span>
    </span>
    @endif
  </div>
</div>

<div class="form-group {{ $errors->has('file_id') ? ' has-error' : ''}}">
    <label for="file_id" class="control-label col-lg-2 text-left">
        File
    </label>
    <div class=' col-lg-8'>
        <select id="file_id" type="text"
                class="form-control multi plugin-optgroup_columns"
                name="file_id" placeholder="File">
            @foreach($files as $file)
            @if ($file->id == $carousel->file_id)
            <option selected value='{{ $file->id}}'>{{ $file->name}}</option>
            @else
            <option value='{{ $file->id}}'>{{ $file->name}}</option>
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
    $('#file_id').selectize({
        delimiter: ',',
        persist: false
    });
</script>