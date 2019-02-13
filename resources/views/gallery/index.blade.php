@extends('layouts.master')

@section('head')
<script type="text/javascript" src="{{ asset('js/vendor/jquery.easing.1.3.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/vendor/jquery.mousewheel.min.js') }}"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link href="{{ elixir('css/gallery.css') }}" rel="stylesheet" type="text/css">
<style>
    #main-content {
        height: 100% !important;
    }
    #top-nav {
        z-index: 10 !important;
    }
    .col-lg-8, .col-lg-offset-2, .col-md-12, .col-sm-12, .col-xs-12 {
        width: 100%;
        margin-left: 0px;
    }
</style>
@endsection

@section('content')
@include ('flash.success')

<div id="outer_container">
<div id="customScrollBox">
  <div class="container">
      <div class="content" style="height: 100%">
            <div id="toolbar"></div><div class="clear"></div>
            @foreach ($files as $file)
            @if ($file->filetype->shortname == 'Photo')
            <a href="{{ $file->path }}/{{ $file->name }}" class="thumb_link">
                <span class="selected"></span>
                <img src="{{ $file->path }}/{{ $file->name }}" title="{{ $file->name }}"
                     alt="{{ $file->name }}" class="thumb" />
            </a>
            @elseif ($file->filetype->shortname == 'Video')
            <a href="{{ $file->path }}" class="thumb_link">
                <span class="selected play-layer"></span>
                <img src="{{ $file->getThumbnail() }}" title="{{ $file->name }}"
                     alt="{{ $file->name }}" class="thumb" />
            </a>
            @endif
            @endforeach
            <p class="clear"></p>
        </div>
  </div>
</div>
</div>
<div id="bg">
    <div class="embed-responsive embed-responsive-4by3">
      <iframe class="embed-responsive-item" src="https://fluids.ac.uk{{ $files->first()->path }}/{{ $files->first()->name }}"
       allowfullscreen="" id="bgimg"> </iframe>
   </div>
  <div id="preloader"><img src="/pictures/ajax-loader_dark.gif" width="32" height="32" align="absmiddle" />Loading...</div>
    <div id="arrow_indicator" title="Open images thumbnails"><img src="/pictures/sw_arrow_indicator.png" width="50" height="50" alt="Open images thumbnails" /></div>
    <div id="nextimage_tip">Next</div>

</div>


<script>
  //set default view mode
  $defaultViewMode="fit"; //full (fullscreen background), fit (fit to window), original (no scale)
  //cache vars
  $bg=$("#bg");
  $bgimg=$("#bg #bgimg");
  $preloader=$("#preloader");
  $outer_container=$("#outer_container");
  $outer_container_a=$("#outer_container a.thumb_link");
  $toolbar=$("#toolbar");
  $nextimage_tip=$("#nextimage_tip");

$(window).load(function() {
  $toolbar.data("imageViewMode",$defaultViewMode); //default view mode
  ImageViewMode($toolbar.data("imageViewMode"));
  //cache vars
  $customScrollBox=$("#customScrollBox");
  $customScrollBox_container=$("#customScrollBox .container");

  $customScrollBox.height($customScrollBox_container.height());

  //resize browser window functions
  $(window).resize(function() {
    FullScreenBackground("#bgimg"); //scale bg image
  });

  LargeImageLoad($bgimg);
});

  //loading bg image
  $bgimg.load(function() {
    LargeImageLoad($(this));
  });

  function LargeImageLoad($this){
    $preloader.fadeOut("fast"); //hide preloader
    $this.removeAttr("width").removeAttr("height").css({ width: "", height: "" }); //lose all previous dimensions in order to rescale new image data
    $bg.data("originalImageWidth",$this.width()).data("originalImageHeight",$this.height());
    if($bg.data("newTitle")){
      $this.attr("title",$bg.data("newTitle")); //set new image title attribute
    }
    FullScreenBackground($this); //scale new image
    $bg.data("nextImage",$($outer_container.data("selectedThumb")).next().attr("href")); //get and store next image
    if(typeof itemIndex!="undefined"){
      if(itemIndex==lastItemIndex){ //check if it is the last image
        $bg.data("lastImageReached","Y");
        $bg.data("nextImage",$outer_container_a.first().attr("href")); //get and store next image
      } else {
        $bg.data("lastImageReached","N");
      }
    } else {
      $bg.data("lastImageReached","N");
    }
    $this.fadeIn("slow"); //fadein background image
    if($bg.data("nextImage") || $bg.data("lastImageReached")=="Y"){ //don't close thumbs pane on 1st load
      SlidePanels("close"); //close the left pane
    }
    NextImageTip();
  }

  //slide in/out left pane
  $outer_container.hover(
    function(){ //mouse over
      //SlidePanels("open");
    },
    function(){ //mouse out
      SlidePanels("close");
    }
  );

  $("#arrow_indicator").click(
    function(){ //mouse over
      SlidePanels("open");
    }
  );

  //Clicking on thumbnail changes the background image
  $outer_container_a.click(function(event){
    event.preventDefault();
    var $this=this;
    $bgimg.css("display","none");
    $preloader.fadeIn("fast"); //show preloader
    //style clicked thumbnail
    $outer_container_a.each(function() {
        $(this).children(".selected").css("display","none");
      });
    $(this).children(".selected").css("display","block");
    //get and store next image and selected thumb
    $outer_container.data("selectedThumb",$this);
    $bg.data("nextImage",$(this).next().attr("href"));
    $bg.data("newTitle",$(this).children("img").attr("title")); //get and store new image title attribute
    itemIndex=getIndex($this); //get clicked item index
    lastItemIndex=($outer_container_a.length)-1; //get last item inclick(dex
    $bgimg.attr("src", "").attr("src", $this); //switch image
  });

  //clicking on large image loads the next one
  $bgimg.click(function(event){
    var $this=$(this);
    if($bg.data("nextImage")){ //if next image data is stored
      $this.css("display","none");
      $preloader.fadeIn("fast"); //show preloader
      $($outer_container.data("selectedThumb")).children(".selected").css("display","none"); //deselect thumb
      if($bg.data("lastImageReached")!="Y"){
        $($outer_container.data("selectedThumb")).next().children(".selected").css("display","block"); //select new thumb
      } else {
        $outer_container_a.first().children(".selected").css("display","block"); //select new thumb - first
      }
      //store new selected thumb
      var selThumb=$outer_container.data("selectedThumb");
      if($bg.data("lastImageReached")!="Y"){
        $outer_container.data("selectedThumb",$(selThumb).next());
      } else {
        $outer_container.data("selectedThumb",$outer_container_a.first());
      }
      $bg.data("newTitle",$($outer_container.data("selectedThumb")).children("img").attr("title")); //get and store new image title attribute
      if($bg.data("lastImageReached")!="Y"){
        itemIndex++;
      } else {
        itemIndex=0;
      }
      $this.attr("src", "").attr("src", $bg.data("nextImage")); //switch image
    }
  });

  //function to get element index (fuck you IE!)
  function getIndex(theItem){
    for ( var i = 0, length = $outer_container_a.length; i < length; i++ ) {
      if ( $outer_container_a[i] === theItem ) {
        return i;
      }
    }
  }

  //toolbar (image view mode button) hover
  $toolbar.hover(
    function(){ //mouse over
      $(this).stop().fadeTo("fast",1);
    },
    function(){ //mouse out
      $(this).stop().fadeTo("fast",0.8);
    }
  );
  $toolbar.stop().fadeTo("fast",0.8); //set its original state

  //Clicking on toolbar changes the image view mode
  $toolbar.click(function(event){
    if($toolbar.data("imageViewMode")=="full"){
      ImageViewMode("fit");
    } else if($toolbar.data("imageViewMode")=="fit") {
      ImageViewMode("original");
    } else if($toolbar.data("imageViewMode")=="original"){
      ImageViewMode("full");
    }
  });

  //next image balloon tip
  function NextImageTip(){
    if($bg.data("nextImage")){ //check if this is the first image
      $nextimage_tip.stop().css("right",20).fadeIn("fast").fadeOut(2000,"easeInExpo",function(){$nextimage_tip.css("right",$(window).width());});
    }
  }

  //slide in/out left pane function
  function SlidePanels(action){
    var speed=900;
    var easing="easeInOutExpo";
    if(action=="open"){
      $("#arrow_indicator").fadeTo("fast",0);
      $outer_container.stop().animate({left: 0}, speed,easing);
      $bg.stop().animate({left: 585}, speed,easing);
    } else {
      $outer_container.stop().animate({left: -710}, speed,easing);
      $bg.stop().animate({left: 0}, speed,easing,function(){$("#arrow_indicator").fadeTo("fast",1);});
    }
  }

//Image scale function
function FullScreenBackground(theItem){
  var winWidth=$(window).width();
  var winHeight=$(window).height()+130;
  var imageWidth=$(theItem).width();
  var imageHeight=$(theItem).height();
  if($toolbar.data("imageViewMode")!="original"){ //scale
    $(theItem).removeClass("with_border").removeClass("with_shadow"); //remove extra styles of orininal view mode
    var picHeight = imageHeight / imageWidth;
    var picWidth = imageWidth / imageHeight;
    if($toolbar.data("imageViewMode")!="fit"){ //image view mode: full
      if ((winHeight / winWidth) < picHeight) {
        $(theItem).css("width",winWidth).css("height",picHeight*winWidth);
      } else {
        $(theItem).css("height",winHeight).css("width",picWidth*winHeight);
      };
    } else { //image view mode: fit
      if ((winHeight / winWidth) > picHeight) {
        $(theItem).css("width",winWidth).css("height",picHeight*winWidth);
      } else {
        $(theItem).css("height",winHeight).css("width",picWidth*winHeight);
      };
    }
    //center it
    $(theItem).css("margin-left",((winWidth - $(theItem).width())/2)).css("margin-top",((winHeight - $(theItem).height())/2));
  } else { //no scale
    //add extra styles for orininal view mode
    $(theItem).addClass("with_border").addClass("with_shadow");
    //set original dimensions
    $(theItem).css("width",$bg.data("originalImageWidth")).css("height",$bg.data("originalImageHeight"));
    //center it
    $(theItem).css("margin-left",((winWidth-$(theItem).outerWidth())/2)).css("margin-top",((winHeight-$(theItem).outerHeight())/2));
  }
}

//image view mode function - full or fit
function ImageViewMode(theMode){
  $toolbar.data("imageViewMode", theMode); //store new mode
  FullScreenBackground($bgimg); //scale bg image
  //re-style button
  /*
  if(theMode=="full"){
    $toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> FULL");
  } else if(theMode=="fit") {
    $toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> FIT");
  } else {
    $toolbar.html("<span class='lightgrey'>IMAGE VIEW MODE &rsaquo;</span> ORIGINAL");
  }
  */
}

//preload script images
var images=["/pictures/ajax-loader_dark.gif"];
$.each(images, function(i) {
  images[i] = new Image();
  images[i].src = this;
});
</script>

@endsection
