@extends('layouts.member')

@section('head')
<script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
<script src="{{ asset('js/angular.min.js')}}"></script>
<script src="{{ asset('js/angular-messages.min.js')}}"></script>
<script src="{{ asset('js/ngStorage.min.js')}}"></script>
<script src="{{ asset('js/ng-map.min.js')}}"></script>
<script src="{{ asset('js/angApp.js')}}"></script>
<script src="{{ asset('js/selectize.js')}}"></script>
<script src="{{ asset('js/angularjs-dropdown-multiselect.min.js')}}"></script>
@endsection

@section('membercontent')
@include ('flash.success')

<h2 class='line-break'>Academic Details</h2>
<div class="container nopadding">
    <div class="row nopadding">
        <div class='col-lg-8'>
            <form name="registrationForm" class="nopadding form-horizontal line-break-dbl-top" method="post" action="/myaccount/academic">

                {{ csrf_field() }}
                
                <!-- user website input - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('url') ? ' has-error' : ''}}">
                        <label for='url' class ="control-label text-left">Personal website</label>
                        <input type="url" id="surname" name="url" value="{{ $user->url }}" class="form-control"
                               placeholder="Personal website" ng-init="data.url='{{ $user->url }}'">
                        <i class="form-control-feedback glyphicon glyphicon-globe" aria-hidden="true"></i>
                    </div>
                </div>
                <!-- user website input - end -->
                <!-- orcid input - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('orcidid') ? ' has-error' : ''}}">
                        <label for='orcidid' class ="control-label text-left">ORCID iD</label>
                        <input type="orcidid" id="surname" name="orcidid" value="{{ $user->orcidid }}" class="form-control"
                               placeholder="ORCID iD" ng-init="data.orcidid='{{ $user->orcidid }}'">
                        <i class="form-control-feedback glyphicon glyphicon-user" aria-hidden="true"></i>
                    </div>
                </div>
                <!-- orcid website input - end -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left">
                        The following are multi-option lists. You may add missing options by typing them and hitting return.
                    </div>
                </div>
                <!-- institutions input - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('institutions') ? ' has-error' : ''}}">
                        <label for="institutions" class="control-label text-left">Institution</label>
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('disciplines') ? ' has-error' : ''}}">
                        <label for="disciplines" class="control-label text-left">Fluids sub-disciplines</label><br>                  
                        Select the tags from the drop-down list that best represent your research interests
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('applications') ? ' has-error' : ''}}">
                        <label for="applications" class="control-label text-left">Application areas</label><br>
                        Select the tags from the drop-down list that best represent the application areas of your research; you may also add your own (suggested max 40 chars each) 
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('techniques') ? ' has-error' : ''}}">
                        <label for="techniques" class="control-label text-left">Techniques</label><br>
                         Select the tags from the drop-down list that best represent your research techniques (analytical, numerical, experimental); you may also add your own (suggested max 40 chars each) 
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
                <div class="col-lg-8 nopadding">
                    <div class="form-group has-feedback input-icon-left {{ $errors->has('facilities') ? ' has-error' : ''}}">
                        <label for='facilities' class="control-label text-left">Facilities</label><br>
                        Please list any facilities at your institution, such as wind tunnels, rotating tables, etc, for which you are responsible
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
                <!-- Submit button - start -->
                <div class="col-lg-8 nopadding">
                    <div class="form-group line-break-dbl-top">
                        <button type="submit" class="btn btn-success">
                            Save changes
                        </button>
                    </div>
                </div>
                <!-- Submit button - end -->
            </form>
        </div>
    </div>
</div>
<script>    
    $('#institutions').selectize({
        plugins: ['remove_button',],
        delimiter: ',',
        framework: 'bootstrap',
        persist: false,
        create: function(input) {
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
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });

</script>
<style>
    .filter-option {
        margin-left: 22px;
    }

    .form-control-feedback.glyphicon {
        z-index: 10;
    }

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
@stop
