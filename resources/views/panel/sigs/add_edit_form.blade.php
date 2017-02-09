<!-- Sig input - start -->
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }} {{ Auth::user()->group_id !== 1 ? ' hidden' : ''}}'>
	@if (Request::is('panel/sig/edit*'))
	{!! Form::label('name', 'SIG:', ['class' => 'control-label col-lg-2 text-left']) !!}
	@else
	{!! Form::label('name', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
	@endif
    <div class=' col-lg-8'>
        @if (Auth::user()->group_id !== 1)
        {!! Form::hidden('name', $sig->name) !!}
        @else
        {!! Form::text('name', $sig->name, ['class' => 'form-control','placeholder' => 'The name of the sig']) !!}
        @endif
        @if ($errors->has('name'))
        <span class="text-danger">
            <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
    </div>
</div>
<!-- Sig input - end -->
<!-- institutions input - start -->
<div class="form-group {{ $errors->has('institutions') ? ' has-error' : ''}}">
    <label for="institutions" class="control-label col-lg-2  text-left">Institutions</label>
    <div class=' col-lg-8'>
        <select id="institutions" type="text" class="form-control multi" name="institutions[]"
                placeholder="Institution" multiple>
            @foreach($institutions as $institution)
            <option {{ in_array($institution->id, $sigInstitutions) ? 'selected' : '' }} value='{{ $institution->id}}'>{{ $institution->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class='form-group {{ $errors->has('shortname') ? ' has-error line-break-dbl' : '' }}'>
  {!! Form::label('shortname', 'Short name:', ['class' => 'control-label col-lg-2 text-left']) !!}
  <div class=' col-lg-8'>
    {!! Form::text('shortname', $sig->shortname, ['class' => 'form-control','placeholder' => 'The short name of the sig']) !!}
    @if ($errors->has('shortname'))
    <span class="text-danger">
      <span>{{ $errors->first('shortname') }}</span>
    </span>
    @endif
  </div>
</div>
<!-- institutions input - end -->
<!-- sub-disciplines input - start -->
<div class="form-group {{ $errors->has('disciplines') ? ' has-error' : ''}}">
    <label for="disciplines" class="control-label col-lg-2 text-left">Fluids sub-disciplines</label>
    <div class=' col-lg-8'>
        <select id="disciplines" type="text" class="tags form-control multi plugin-optgroup_columns" name="disciplines[]" placeholder="Fluids sub-disciplines" multiple>
            @foreach($subDisciplines as $key => $discipline)
            @if ($curDisciplinesCategory !== $discipline->category)
            <optgroup label="{{$discipline->category}}">
                {{$curDisciplinesCategory = $discipline->category}}
                @endif
                <option {{ in_array($discipline->id, $sigTags) ? 'selected' : '' }} value='{{ $discipline->id}}'>{{ $discipline->name}}</option>
                @if ($discipline === end($subDisciplines)) || ($curDisciplinesCategory !== $subDisciplines[$key+1]->category)
            </optgroup>
            @endif
            @endforeach
        </select>
    </div>
</div>
<!-- sub-disciplines input - end -->
<!-- applications input - start -->
<div class="form-group {{ $errors->has('applications') ? ' has-error' : ''}}">
    <label for="applications" class="control-label col-lg-2 text-left">Application areas</label>
    <div class=' col-lg-8'>
        <select id="applications" type="text" class="tags form-control multi plugin-optgroup_columns" name="applications[]" placeholder="Application areas" multiple>
            @foreach($applicationAreas as $key => $application)
            @if ($curApplicationCategory !== $application->category)
            <optgroup label="{{$application->category}}">
                {{$curApplicationCategory = $application->category}}
                @endif
                <option {{ in_array($application->id, $sigTags) ? 'selected' : '' }} value='{{ $application->id}}'>{{ $application->name}}</option>
                @if ($application === end($applicationAreas)) || ($curApplicationCategory !== $applicationAreas[$key+1]->category)
            </optgroup>
            @endif
            @endforeach
        </select>
    </div>
</div>
<!-- applications input - end -->
<!-- techniques input - start -->
<div class="form-group {{ $errors->has('techniques') ? ' has-error' : ''}}">
    <label for="techniques" class="control-label col-lg-2 text-left">Techniques</label>
    <div class=' col-lg-8'>
        <select id="techniques" type="text" class="tags form-control multi" name="techniques[]"
                placeholder="Techniques" data-create-item="true" data-live-search="true" data-selected-text-format="count > 2" multiple>
            @foreach($techniques as $technique)
            <option {{ in_array($technique->id, $sigTags) ? 'selected' : '' }} value='{{ $technique->id}}'>{{ $technique->name}}</option>
            @endforeach
        </select>
    </div>
</div>
<!-- applications input - end -->
<!-- facilities input - start -->
<div class="form-group {{ $errors->has('facilities') ? ' has-error' : ''}}">
    <label for='facilities' class="control-label col-lg-2 text-left">Facilities</label>
    <div class=' col-lg-8'>
        <select id="facilities" type="text" class="tags form-control multi" name="facilities[]"
                placeholder="Responsible for facilities" data-create-item="true" multiple>
            @foreach($facilities as $facility)
            <option {{ in_array($facility->id, $sigTags) ? 'selected' : '' }} value='{{ $facility->id}}'>{{ $facility->name}}</option>
            @endforeach
        </select>
        @if ($errors->has('facilities'))
        <span class="help-block">
            <strong>{{ $errors->first('facilities')}}</strong>
        </span>
        @endif
    </div>
</div>
<!-- facilities input - end -->
<!-- big image input - start -->
<div class="form-group {{ $errors->has('bigiamge') ? ' has-error' : ''}}">
    <label for='bigimage' class="control-label col-lg-2 text-left">Big image</label>
    <div class=' col-lg-8'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 nopadding'>
            <label class="btn btn-default">
                Select image {!! Form::file('bigimage', ['class' => 'control-label col-lg-2 text-left hide',
                'id' => 'sigbigimage', 'onchange' => 'getFileDetails("sigbigimage")', 'accept' => 'image/*']) !!}
            </label>
        </div>
        <div id="sigbigimage_details" class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            No file selected
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-break-top nosidepadding text-muted">
            Large background image displayed on SIG individual page
        </div>
        @if ($errors->has('bigimage'))
        <span class="help-block">
            <strong>{{ $errors->first('bigimage')}}</strong>
        </span>
        @endif
    </div>
</div>
<!-- big image input - end -->

<!-- small image input - start -->
<div class="form-group {{ $errors->has('smallimage') ? ' has-error' : ''}}">
    <label for='smallimage' class="control-label col-lg-2 text-left">Small image</label>
    <div class=' col-lg-8'>
        <div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 nopadding'>
            <label class="btn btn-default">
                Select image {!! Form::file('smallimage', ['class' => 'control-label col-lg-2 text-left hide',
                'id' => 'sigsmallimage', 'onchange' => 'getFileDetails("sigsmallimage")','accept' => 'image/*']) !!}
            </label>
        </div>
        <div id="sigsmallimage_details" class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            No file selected
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 line-break-top nosidepadding text-muted">
            Small thumbnail displayed on SIG list
        </div>
        @if ($errors->has('smallimage'))
        <span class="help-block">
            <strong>{{ $errors->first('smallimage')}}</strong>
        </span>
        @endif
    </div>
</div>
<!-- small image input - end -->
<!-- twitterurl input - start -->
<div class='form-group {{ $errors->has('twitterurl') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('twitterurl', 'Twitter URL:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('twitterurl', $sig->twitterurl, ['class' => 'form-control','placeholder' => 'Twitter URL']) !!}
        @if ($errors->has('twitterurl'))
        <span class="text-danger">
            <span>{{ $errors->first('twitterurl') }}</span>
        </span>
        @endif
    </div>
</div>
<!-- twitterurl input - end -->
<!-- Description - start -->
<div class='form-group {{ $errors->has('description') ? ' has-error line-break-dbl' : '' }}'>
  	{!! Form::label('description', 'Description:', ['class' => 'control-label col-lg-2 text-left']) !!}
  	<div class='col-lg-8'>
    {!! Form::textarea('description', $sig->description, ['class' => 'form-control','placeholder' => 'The description of the SIG']) !!}
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
<!-- Description - end -->
<script>
    $('#institutions').selectize({
        plugins: ['remove_button' ],
        delimiter: ',',
        framework: 'bootstrap',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            };
        }
    });

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

    /*WHOLO GROUP BOX*/
    .optgroup {
        width : 300px !important;
        height : auto !important;
        padding-bottom: 50px !important;
        float: left !important;
        border: none !important;
    }
    .option {
        /*height: 40px !important;*/
    }
    .optgroup-header {
        font-size:1.5em !important;
    }
</style>