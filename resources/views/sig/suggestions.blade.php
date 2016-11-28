
<h3 class='line-break'>Building a SIG</h3>
<p>
    The following list gives all the suggestions for SIGs received to date for the second call. 
    Each entry includes contact details, and an asterisk in the title denotes the person is agreeable to leading the SIG. 
    The list from the first call has been archived (see above).
</p>
<p>
    If you are interested in forming a SIG, then this list is a good place to start, 
    and we would encourage those who offered to lead a SIG to take the initiative and start to build it. 
    Your familiarity with the topic will also play a major role in finding suitable participants.
</p>
<p>
    If you have a new idea for a SIG and would like to advertise it then please complete the form below. 
    Don’t forget to check the box if you are willing to lead the SIG. Your suggestion will be appended to the list.
</p>
<p>
    If you would like to be a participant in one of the SIGs already listed, please email the contact directly to express your interest, rather than completing the form.
</p>

<br><br>

<div class="line-break">
    {!! Form::open(['url' => 'sig', 'class' => 'form-horizontal']) !!}
    <div class='form-group {{ $errors->has('suggestion') ? ' has-error line-break-dbl' : '' }}'>
        {!! Form::label('suggestion', 'SIG Title:', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
        <div class='col-lg-8'>
            {!! Form::text('suggestion', null, ['class' => 'form-control input-lg','placeholder' => 'Your suggested SIG Title']) !!}
            @if ($errors->has('suggestion'))
            <span class="text-danger">
                <span>{{ $errors->first('suggestion') }}</span>
            </span>
            @endif
        </div>
    </div>
    <div class="form-group has-feedback">
        {!! Form::label('leader', 'Leader:', ['class' => 'sr-only control-label col-lg-2']) !!}
        <div class="col-lg-8 checkbox nopadding-top">
            <label><input id='leader' name='leader' type="checkbox" value="1"><span class='larger'>Leader</span></label>
        </div>
    </div>
    <div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
        {!! Form::label('name', 'Contact Name:', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
        <div class=' col-lg-8'>
            {!! Form::text('name', null, ['class' => 'form-control input-lg','placeholder' => 'Your name']) !!}
            @if ($errors->has('name'))
            <span class="text-danger">
                <span>{{ $errors->first('name') }}</span>
            </span>
            @endif
        </div>
    </div>
    <div class='form-group {{ $errors->has('institution') ? ' has-error line-break-dbl' : '' }}'>
        {!! Form::label('institution', 'Organisation:', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
        <div class='col-lg-8'>
            {!! Form::text('institution', null, ['class' => 'form-control input-lg','placeholder' => 'Your organisation name']) !!}
            @if ($errors->has('institution'))
            <span class="text-danger">
                <span>{{ $errors->first('institution') }}</span>
            </span>
            @endif
        </div>
    </div>
    <div class='form-group {{ $errors->has('email') ? ' has-error line-break-dbl' : '' }}'>
        {!! Form::label('email', 'Email:', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
        <div class='col-lg-8'>
            {!! Form::text('email', null, ['class' => 'form-control input-lg','placeholder' => 'your@email.com']) !!}
            @if ($errors->has('email'))
            <span class="text-danger">
                <span>{{ $errors->first('email') }}</span>
            </span>
            @endif
        </div>
    </div>
    <div class=' col-lg-offset-2 col-lg-8'>
        <div class='form-group line-break-dbl-top'>
            {!! Form::submit('Submit', ['class' => 'btn btn-success btn-lg text-uppercase']) !!}
        </div>    
    </div>      
    {!! Form::close() !!}
</div>
<!--  List of suggestions -->
<div class="table-responsive pull-left">
    <p>
        Total entries: {{ $totalSuggestions }}
    </p>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Leader</th>
                <th>SIG title</th>
                <th>Contact</th>
                <th>Organisation</th>
                <th>Contact Email</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($allSuggestions))
            @foreach ($allSuggestions as $suggestion)
            <tr>
                <td>{{ $suggestion->id }}</td>
                <td>{{ $suggestion->leader ? 'yes' : '-' }}</td>
                <td>{{ $suggestion->suggestion }}</td>
                <td>{{ $suggestion->name }}</td>
                <td>{{ $suggestion->institution }}</td>
                <td>{{ Html::link('mailto:'.$suggestion->email, $suggestion->email)}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
