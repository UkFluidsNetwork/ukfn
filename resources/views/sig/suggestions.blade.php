@include('flash.success')
 
<table class='table'>
  <thead>
    <tr>
      
      <th>Suggestion</th>
      <th></th>
      <th>Name</th>
    </tr>
  </thead>
  
  @foreach ($allSuggestions as $suggestion)
  
  <tr>
    
    <td>{{ $suggestion->suggestion }}</td>
    <td> 
        
    </td>
    <td>{{ Html::link($suggestion->email, $suggestion->name)}} ({{ $suggestion->institution }})</td>
  </tr>
  
  @endforeach
</table>
 

<bR id='suggestion-form'><br><bR><br>

<h3 class='line-break'>SIG suggestions</h3>
<p class='line-break-dbl'>Post your suggestions here</p>
<bR><br>
  <!-- SIG UGESSTIONS FORM - START -->
  {!! Form::open(['url' => 'sig#suggestion-form', 'class' => 'form-horizontal']) !!}
    <div class='form-group {{ $errors->has('name') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('name', 'Name :', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
      <div class=' col-lg-8'>
        {!! Form::text('name', null, ['class' => 'form-control input-lg','placeholder' => 'Your name']) !!}
        @if ($errors->has('name'))
        <span class="text-danger">
          <span>{{ $errors->first('name') }}</span>
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
    <div class='form-group {{ $errors->has('institution') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('institution', 'institution :', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
      <div class='col-lg-8'>
        {!! Form::text('institution', null, ['class' => 'form-control input-lg','placeholder' => 'Your institutuin name']) !!}
        @if ($errors->has('institution'))
        <span class="text-danger">
          <span>{{ $errors->first('institution') }}</span>
        </span>
        @endif
      </div>
    </div>
    <div class='form-group {{ $errors->has('suggestion') ? ' has-error line-break-dbl' : '' }}'>
      {!! Form::label('suggestion', 'suggestion :', ['class' => 'control-label col-lg-2 text-uppercase']) !!}
      <div class='col-lg-8'>
        {!! Form::textarea('suggestion', null, ['class' => 'form-control input-lg','placeholder' => 'Your suggestion...']) !!}
        @if ($errors->has('suggestion'))
        <span class="text-danger">
          <span>{{ $errors->first('suggestion') }}</span>
        </span>
        @endif
      </div>
    </div>
    <div class=' col-lg-offset-2 col-lg-8'>
      <div class='form-group line-break-dbl-top'>
        {!! Form::submit('Post your suggestion', ['class' => 'btn btn-default btn-lg text-uppercase']) !!}
      </div>    
    </div>      
  {!! Form::close() !!}
  <!-- SIG UGESSTIONS FORM - END -->
  
  <bR><br>
