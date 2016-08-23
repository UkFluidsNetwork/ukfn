<!DOCTYPE html>
<html>
  <head>
      <title>UK Fluids Network</title>
      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
      <script src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
      <script src="{{ asset('js/bootstrap.min.js')}}"></script>
      <!-- favicon -->
      <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('pictures/favicon/apple-icon-57x57.png') }}">
      <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('pictures/favicon/apple-icon-60x60.png') }}">
      <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('pictures/favicon/apple-icon-72x72.png') }}">
      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('pictures/favicon/apple-icon-76x76.png') }}">
      <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('pictures/favicon/apple-icon-114x114.png') }}">
      <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('pictures/favicon/apple-icon-120x120.png') }}">
      <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('pictures/favicon/apple-icon-144x144.png') }}">
      <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('pictures/favicon/apple-icon-152x152.png') }}">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pictures/favicon/apple-icon-180x180.png') }}">
      <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('pictures/favicon/android-icon-192x192.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('pictures/favicon/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('pictures/favicon/favicon-96x96.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('pictures/favicon/favicon-16x16.png') }}">
      <link rel="manifest" href="/manifest.json">
      <meta name="msapplication-TileColor" content="#ffffff">
      <meta name="msapplication-TileImage" content="{{ asset('pictures/favicon/ms-icon-144x144.png') }}">
      <meta name="theme-color" content="#ffffff">
      <!-- end of favicon -->
  </head>
  <body>
    <div class="container-fluid" id="top-content">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-lg-4 col-md-2 col-sm-1 col-xs-1">
              <img src="{{ asset('pictures/logo.png') }}" class="logo">
            </div>
            <div class="col-lg-8 col-md-10 col-sm-11 col-xs-11 text-right h1 text-uppercase text-muted">
                
            </div>  
          </div>
        </div>
      </div>
    </div>
    <!-- TOP NAV - START -->
    <div data-spy="affix" data-offset-top="130">
      <nav class="navbar navbar-default navbar-custom" id="top-nav">
        <div class="container-fluid col-lg-offset-2 col-lg-8 col-md-12 col-sm-12 col-xs-12" >
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-bar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
              <span class="glyphicon glyphicon-home"></span>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="top-nav-bar">
            <ul class="nav navbar-nav">
              <li><a href="sig">SIG</a></li>
              <li><a href="srv">SRV</a></li>
              <li><a href="contact">Contact Us</a></li>
              <li><a href="#"></a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <!-- TOP NAV - END -->
    <!-- MAIN CONTENT - START -->
    <div class="container-fluid" id="main-content">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-12 col-sm-12 col-xs-12">
          @yield('content')
        </div>
      </div>
    </div>    
    <!-- MAIN CONTENT - END -->
    <!-- SIGNUP - START -->
    <div class="container-fluid signup">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12">
          <form method="post" class="">
            <div class="row">
              <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12 h3 line-break text-danger text-uppercase">
                Sign up to our newsletter
              </div>
            </div>
            <div class="row">
              <div class="col-lg-offset-3 col-lg-4 col-md-offset-2 col-md-6 col-sm-offset-1 col-sm-8 col-xs-12 form-group input-group-lg">
                <label class="sr-only" for="subscribe">Subscribe :</label>
                <input type="email" class="form-control" name="subscribe" placeholder="your@email.com" required="required">
              </div>
                <div class="col-lg-2 col-md-2 btn-group col-sm-2 col-xs-12 input-group-lg">
                  <input type="submit" class="btn btn-lg btn-default text-uppercase btn-signup" name="submit-subscribe" value="Subscribe">
                </div>            
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- FOOTER - START -->
    <footer class="container-fluid">
      <!--div class="row">
        <div class="col-lg-12">
          <nav>
            <ul class="list-inline text-center">
              <li><a href="/" class="footer-color">Home</a></li>
              <li><a href="sig" class="footer-color">SIG</a></li>
              <li><a href="srv" class="footer-color">SRV</a></li>
              <li><a href="contact" class="footer-color">Contact</a></li>
            </ul>
          </nav>
        </div>
      </div-->
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-12 col-sm-12 col-xs-12 text-center">
          <p class="footer-credits">
            &copy; 2016 ukfluids.net
          </p>
          <p class="footer-credits">
            Designed by 
            <a href="{{ url('http://arias.re') }}" class="footer-color" target="_blank">arias.re</a> & 
            <a href="{{ url('https://barczyk.net') }}" class="footer-color" target="_blank" title="barczyk.net website">barczyk.net</a>
          </p>
        </div>
      </div>
    </footer>
    <!-- FOOTER - END -->
  </body>
</html>