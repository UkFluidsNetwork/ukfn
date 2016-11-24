@extends('layouts.admin')
@section('admincontent')

<h2 class='line-break'>Edit: {{ $user->name }} {{ $user->surname }}</h2>

{!! Form::model($user, [
'method' => 'PATCH',
'action' => ['UsersController@update', $user->id],
'class' => 'form-horizontal'
]) !!}
<div class='form-group {{ $errors->has('group_id') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('group_id', 'Access group:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::select('group_id', $groups, $user->group_id, ['class' => 'selectpicker show-tick']) !!}
        @if ($errors->has('group_id'))
        <span class="text-danger">
            <span>{{ $errors->first('group_id ') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('title_id') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('title_id', 'Title:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::select('title_id', $titles, $user->title_id, ['class' => 'selectpicker show-tick']) !!}
        @if ($errors->has('title_id'))
        <span class="text-danger">
            <span>{{ $errors->first('title_id') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('name', 'Name:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('name', $user->name, ['class' => 'form-control','placeholder' => 'The name of the user']) !!}
        @if ($errors->has('name'))
        <span class="text-danger">
            <span>{{ $errors->first('name') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('surname') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('surname', 'Surname:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('surname', $user->surname, ['class' => 'form-control','placeholder' => 'The surname of the user']) !!}
        @if ($errors->has('surname'))
        <span class="text-danger">
            <span>{{ $errors->first('surname') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('email', 'Email:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('email', $user->email, ['class' => 'form-control','placeholder' => 'The email of the user']) !!}
        @if ($errors->has('email'))
        <span class="text-danger">
            <span>{{ $errors->first('email') }}</span>
        </span>
        @endif
    </div>
</div>
<!-- institutions input - start -->
<div class="form-group {{ $errors->has('institutions') ? ' has-error' : ''}}">
    <label for="institutions" class="control-label col-lg-2  text-left">Institution</label>
    <div class=' col-lg-8'>
        <select id="institutions" type="text" class="form-control multi" name="institutions[]"
                placeholder="Institution" multiple>
            @foreach($institutions as $institution)
            <option {{ in_array($institution->id, $userInstitutions) ? 'selected' : '' }} value='{{ $institution->id}}'>{{ $institution->name}}</option>
            @endforeach
        </select>
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
                <option {{ in_array($discipline->id, $userTags) ? 'selected' : '' }} value='{{ $discipline->id}}'>{{ $discipline->name}}</option>
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
                <option {{ in_array($application->id, $userTags) ? 'selected' : '' }} value='{{ $application->id}}'>{{ $application->name}}</option>
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
            <option {{ in_array($technique->id, $userTags) ? 'selected' : '' }} value='{{ $technique->id}}'>{{ $technique->name}}</option>
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
            <option {{ in_array($facility->id, $userTags) ? 'selected' : '' }} value='{{ $facility->id}}'>{{ $facility->name}}</option>
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
<div class='form-group {{ $errors->has('orcidid') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('orcidid', 'ORCID iD:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('orcidid', $user->orcidid, ['class' => 'form-control','placeholder' => 'The ORCID iD of the user']) !!}
        @if ($errors->has('orcidid'))
        <span class="text-danger">
            <span>{{ $errors->first('orcidid') }}</span>
        </span>
        @endif
    </div>
</div>
<div class='form-group {{ $errors->has('url') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('url', 'Website:', ['class' => 'control-label col-lg-2 text-left']) !!}
    <div class=' col-lg-8'>
        {!! Form::text('url', $user->url, ['class' => 'form-control','placeholder' => 'The personal website of the user']) !!}
        @if ($errors->has('url'))
        <span class="text-danger">
            <span>{{ $errors->first('url') }}</span>
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
<script>
    $('#institutions').selectize({
        plugins: ['remove_button', ],
        delimiter: ',',
        framework: 'bootstrap',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
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
            }
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
@endsection