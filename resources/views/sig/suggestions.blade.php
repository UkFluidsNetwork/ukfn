
<h3 class='line-break'>Building a SIG</h3>
<p>
  The following list gives all suggestions for SIGs received to date. 
  Each entry includes contact details, and an asterisk in the title denotes the institution/company is potentially willing to lead the SIG.
</p>
<p>
  If you are interested in forming a SIG, then this list is a good place to start, and we would encourage those who offered to lead a 
  SIG to take the initiative and start to build it. Your familiarity with the topic will also play a major role in finding suitable participants.
</p>
<p>
  If you have a new idea for a SIG and would like to advertise it then please complete the form below, 
  and include an asterisk in the title if you would be willing to lead it. Your suggestion will be appended to the list.
</p>
<p>
  Please note that some titles would be too broad for UKFN SIGs, but they nevertheless indicate where interest in those general areas can be found, 
  and are therefore potentially useful for building a SIG. 
</p>

<bR><br>
 
<div class="line-break">
  <!-- SIG SUGGESTIONS FORM - START -->
  {!! Form::open(['url' => 'sig', 'class' => 'form-horizontal']) !!}
    <div class='form-group {{ $errors->has('suggestion') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('suggestion', 'SIG Title :', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
      <div class='col-lg-8'>
        {!! Form::text('suggestion', null, ['class' => 'form-control input-lg','placeholder' => 'Your suggested SIG Title (add * if you intend to lead)']) !!}
        @if ($errors->has('suggestion'))
        <span class="text-danger">
          <span>{{ $errors->first('suggestion') }}</span>
        </span>
        @endif
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
      {!! Form::label('email', 'Email :', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
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
        {!! Form::submit('Submit', ['class' => 'btn btn-default btn-lg text-uppercase']) !!}
      </div>    
    </div>      
  {!! Form::close() !!}
  <!-- SIG SUGGESTIONS FORM - END -->
</div>
<!--  List of suggestions -->
<div class="table-responsive pull-left">
  <table class='table'>
    <thead>
      <tr>
        @if($newCount)
        <th colspan="2">SIG Title</th>
        @else
        <th colspan="2">SIG Title</th>
        @endif
        <th>Contact</th>
        <th>Organisation</th>
        <th>Contact Email Address</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($allSuggestions as $suggestion)
    <tr>
      @if($newCount)
      <td>{!! $suggestion->new !!}</td>
      <td>{{ $suggestion->suggestion }}</td>
      @else
      <td>{!! $suggestion->new !!}{{ $suggestion->suggestion }}</td>
      @endif
      <td>{{ $suggestion->name }}</td>
      <td>{{ $suggestion->institution }}</td>
      <td>{{ Html::link('mailto'.$suggestion->email, $suggestion->email)}}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
