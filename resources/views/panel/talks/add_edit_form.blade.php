<div class='form-group {{ $errors->has('title') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('title', 'Title:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>        
        {!! Form::text('title', $talk->title, ['class' => 'form-control','placeholder' => 'Talk title']) !!}
        @if ($errors->has('title'))
        <span class="text-danger">
          <span>{{ $errors->first('title') }}</span>
        </span>
        @endif
    </div>
</div>
    
<div class='form-group {{ $errors->has('speaker') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('speaker', 'Speaker:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('speaker', $talk->speaker, ['class' => 'form-control','placeholder' => 'Speaker']) !!}
        @if ($errors->has('speaker'))
        <span class="text-danger">
          <span>{{ $errors->first('speaker') }}</span>
        </span>
        @endif
    </div>
</div>
    
<div class='form-group {{ $errors->has('venue') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('venue', 'Venue:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('venue', $talk->venue, ['class' => 'form-control','placeholder' => 'Venue']) !!}
        @if ($errors->has('venue'))
        <span class="text-danger">
          <span>{{ $errors->first('venue') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group {{ $errors->has('institution_id') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('institution_id', 'Institution:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::select('institution_id', $institutions, $talk->institution_id, ['class' => 'form-control', 'placeholder' => 'Select institution']) !!}
        @if ($errors->has('institution_id'))
        <span class="text-danger">
          <span>{{ $errors->first('institution_id') }}</span>
        </span>
        @endif
    </div>
</div>  
    
<div class='form-group {{ $errors->has('speakerurl') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('speakerurl', 'Speaker URL:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('speakerurl', $talk->speakerurl, ['class' => 'form-control','placeholder' => 'Speaker URL']) !!}
        @if ($errors->has('speakerurl'))
        <span class="text-danger">
          <span>{{ $errors->first('speakerurl') }}</span>
        </span>
        @endif
    </div>
</div>
    
<div class='form-group {{ $errors->has('organiser') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('organiser', 'Organiser:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('organiser', $talk->organiser, ['class' => 'form-control','placeholder' => 'Organiser']) !!}
        @if ($errors->has('organiser'))
        <span class="text-danger">
          <span>{{ $errors->first('organiser') }}</span>
        </span>
        @endif
    </div>
</div>
    
<div class='form-group {{ $errors->has('aggregator_id') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('aggregator_id', 'RSS Feed:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::select('aggregator_id', $aggregators, $talk->aggregator_id, ['class' => 'form-control', 'placeholder' => 'Select RSS Feed']) !!}
        @if ($errors->has('aggregator_id'))
        <span class="text-danger">
          <span>{{ $errors->first('aggregator_id') }}</span>
        </span>
        @endif
    </div>
</div>    

<div class='form-group {{ $errors->has('start') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('start', 'Start:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        <div class='input-group date' id='talk_start'>
            {!! Form::text('start', $talk->start, ['class' => 'form-control',  'data-date-format' => 'YYYY-MM-DD HH:mm', 'placeholder' => 'Talk start']) !!}
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
    {!! Form::label('end', 'End:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        <div class='input-group date' id='talk_end'>
            {!! Form::text('end', $talk->end, ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD HH:mm', 'placeholder' => 'Talk end']) !!}
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
    
<div class='form-group {{ $errors->has('abstract') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('abstract', 'Abstract:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::textarea('abstract', $talk->abstract, ['class' => 'form-control','placeholder' => 'Abstract']) !!}
        @if ($errors->has('abstract'))
        <span class="text-danger">
          <span>{{ $errors->first('abstract') }}</span>
        </span>
        @endif
    </div>
</div>
    
<div class='form-group'>
    {!! Form::label('teradekip', 'Teradek IP:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('teradekip', $talk->teradekip, ['class' => 'form-control','placeholder' => 'Teradek IP address']) !!}
    </div>
</div>
        
<div class='form-group'>
    {!! Form::label('streamingurl', 'Streaming URL:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('streamingurl', $talk->streamingurl, ['class' => 'form-control','placeholder' => 'Streaming URL']) !!}
    </div>
</div>
    
<div class='form-group'>
    {!! Form::label('recordingurl', 'Recording URL:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        {!! Form::text('recordingurl', $talk->recordingurl, ['class' => 'form-control','placeholder' => 'Recording URL']) !!}
    </div>
</div>
    
<div class='form-group {{ $errors->has('recordinguntil') ? ' has-error line-break-dbl' : '' }}'>
    {!! Form::label('recordinguntil', 'Recording Available Until:', ['class' => 'control-label col-lg-3 text-left']) !!}
    <div class=' col-lg-7'>
        <div class='input-group date' id='recording_until'>
            {!! Form::text('recordinguntil', $talk->recordinguntil, ['class' => 'form-control', 'data-date-format' => 'YYYY-MM-DD', 'placeholder' => 'Display recording until']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('recordinguntil'))
        <span class="text-danger">
          <span>{{ $errors->first('recordinguntil') }}</span>
        </span>
        @endif
    </div>
</div>

<div class='form-group line-break-dbl-top'>
    <div class=' col-lg-offset-3 col-lg-7'>
        {!! Form::submit('Save', ['class' => 'btn btn-default']) !!}
    </div>    
</div>

<!-- date time picker initialisation -->
<script type="text/javascript">
    $(function () {
        $('#talk_start').datetimepicker();
        $('#talk_end').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#talk_start").on("dp.change", function (e) {
            $('#talk_end').data("DateTimePicker").minDate(e.date);
        });
        $("#talk_end").on("dp.change", function (e) {
            $('#talk_start').data("DateTimePicker").maxDate(e.date);
        });
        
        $('#recording_until').datetimepicker();
    });
</script>