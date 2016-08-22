<!DOCTYPE html>
<html>
  <head>
      <title>UK Fluids Network</title>
      <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
      <script src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
      <script src="{{ asset('js/bootstrap.min.js')}}"></script>
  </head>
  <body>
    <div class="container-fluid" id="top-content">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-12">
          <div class="row">
            <div class="col-lg-4 col-md-2 col-sm-1 col-xs-1">
              <img src="pictures/logo.png" class="logo">
                </div>
              <div class="col-lg-8 col-md-10 col-sm-11 col-xs-10 text-right h1 text-uppercase text-muted">
                
              </div>  
            </div>
          </div>
      </div>
    </div>
    <div  data-spy="affix" data-offset-top="150">
      <nav class="navbar navbar-default navbar-custom" id="top-nav">
        <div class="container-fluid col-lg-offset-2 col-lg-8 col-md-12" >
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
              <li><a href="sig">Home</a></li>
              <li><a href="sig">SIG</a></li>
              <li><a href="srv">SRV</a></li>
              <li><a href="contact">Contact Us</a></li>
              <li><a href="#"></a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <div class="container-fluid" id="main-content">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8 col-md-12">  
          @yield('content')
        </div>
      </div>
    </div>    
    <div class="container-fluid signup">
      <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
          <form method="post" class="">
            <div class="row">
              <div class="col-lg-offset-3 col-lg-6 h3 line-break text-danger text-uppercase">
                Sign up to our newsletter
              </div>
            </div>
            <div class="row">
              <div class="col-lg-offset-3 col-lg-4 form-group input-group-lg">
                <label class="sr-only" for="subscribe">Subsribe :</label>
                <input type="email" class="form-control" name="subscribe" placeholder="your@email.com" required="required">
              </div>
                <div class="col-lg-2 btn-group input-group-lg">
                  <input type="submit" class="btn btn-lg btn-default text-uppercase btn-signup" name="submit-subscribe" value="Subscribe">
                </div>            
            </div>
          </form>
        </div>
      </div>
    </div>    
    <footer class="container-fluid">
      <div class="row">
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
      </div>
      <div class="row">
        <div class="col-lg-12 text-center">
          <p class="footer-credits">
            &copy; 2016 ukfluids.net
          </p>
          <p class="footer-credits">
            Designed by 
            <a href="http://arias.re" class="footer-color" target="_blank">arias.re</a> & 
            <a href="https://barczyk.net" class="footer-color" target="_blank" title="barczyk.net website">barczyk.net</a>
          </p>
        </div>
      </div>
    </footer>
  </body>
</html>