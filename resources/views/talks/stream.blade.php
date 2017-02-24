@extends('layouts.master')
@section('content')


  <script type="text/javascript" src="//sms.cam.ac.uk/mediaplayer/jwplayer.js"></script>
  <script type="text/javascript">jwplayer.key="NNXEsEAdRYJ6hNlTY5m43FsKNDixOpQA881GiROWssE=";</script> 

<div id="streamer">Loading the player ...</div>

<script type="text/javascript">
    jwplayer("streamer").setup({
        "file": "rtmp://live1.sms.cam.ac.uk:1935/ENG/live",
        "autostart": true,
        "aspectratio": "16:9",
        "width": "100%",
    });
</script> 
            
@endsection
