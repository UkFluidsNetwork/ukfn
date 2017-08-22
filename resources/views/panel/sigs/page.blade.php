@extends('layouts.admin')
@section('head')
<script type="text/javascript"
        src="/ckeditor/ckeditor.js"></script>
<script>
  var box_count = <?php echo $box_count; ?>;
  function add_box() {
      box_count++;
      var id = 'box-' + box_count;
      var add = '<div id="' + id + '-container" class="box-container">'
                + '<textarea id="' + id + '"></textarea></div>';
      $('#boxes').append(add);
      CKEDITOR.replace(id);
  };
</script>
<style>
#new-box {
    margin-bottom: 1em;
}
.box-container {
    margin-bottom: 1em;
}
</style>
@endsection
@section('admincontent')

<h2 class='line-break'>Edit SIG page content</h2>

<a id="new-box" class="btn btn-default" onclick="add_box()">
    Add Box
</a>

{!! Form::model($sig, [
'method' => 'POST',
'action' => ['SigsController@', $sig->id],
'class' => 'form-horizontal'
]) !!}


<div id="boxes">

</div>

@endsection
