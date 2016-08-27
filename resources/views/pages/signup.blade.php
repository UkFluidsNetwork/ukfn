@extends('layouts.master')
@section('content')
@include ('flash.success')

Redirect::back();
  <h2 class='line-break'>Thank you!</h2>
  <p>
    Your email has been added to our database.
  </p>
  
  <p>
    You can always unsubscribe by clicking {{ Html::link('/unsubscribe', 'here', ['title'=>'Unsubscribe from our mailing list']) }}.
    
  </p>
  
  <!-- CONTACT US FORM - END -->
@stop