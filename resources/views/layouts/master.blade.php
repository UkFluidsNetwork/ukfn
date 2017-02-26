<!DOCTYPE html>
<html>
    <head>
        {!! SEO::generate() !!}
        <!-- For The jQuerry to work on IE 11 -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/vendor/selectize.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/vendor/selectize.bootstrap3.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
        <script src="{{ asset('js/vendor/angular/angular.min.js')}}"></script>
        <script src="{{ asset('js/vendor/angular-messages/angular-messages.min.js')}}"></script>
        <script src="{{ asset('js/vendor/ngstorage/ngStorage.min.js')}}"></script>
        <script src="{{ asset('js/vendor/ngmap/build/scripts/ng-map.min.js')}}"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/analytics.js')}}"></script>
        <script src="{{ asset('js/main.js')}}"></script>
        <script src="{{ asset('js/angApp.js')}}"></script>
        <script src="{{ asset('js/angCtrl.js')}}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js')}}"></script>
        <script src="{{ asset('js/vendor/selectize.min.js')}}"></script>
        <script src="{{ asset('/js/vendor/angular-selectize2/dist/selectize.js')}}"></script>
        <script src="{{ asset('js/vendor/angularjs-dropdown-multiselect.min.js')}}"></script>
        <script src="{{ asset('js/vendor/moment/moment.js')}}"></script>
        <script src="{{ asset('/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
                
        <!-- favicon -->
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('pictures/favicon/ms-icon-144x144.png?v=2') }}">
        <meta name="theme-color" content="#ffffff">
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('pictures/favicon/apple-icon-57x57.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('pictures/favicon/apple-icon-60x60.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('pictures/favicon/apple-icon-72x72.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('pictures/favicon/apple-icon-76x76.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('pictures/favicon/apple-icon-114x114.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('pictures/favicon/apple-icon-120x120.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('pictures/favicon/apple-icon-144x144.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('pictures/favicon/apple-icon-152x152.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('pictures/favicon/apple-icon-180x180.png?v=2') }}">
        <link rel="icon" type="image.png" sizes="192x192"  href="{{ asset('pictures/favicon/android-icon-192x192.png?v=2') }}">
        <link rel="icon" type="image.png" sizes="32x32" href="{{ asset('pictures/favicon/favicon-32x32.png?v=2') }}">
        <link rel="icon" type="image.png" sizes="96x96" href="{{ asset('pictures/favicon/favicon-96x96.png?v=2') }}">
        <link rel="icon" type="image.png" sizes="16x16" href="{{ asset('pictures/favicon/favicon-16x16.png?v=2') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <!-- end of favicon -->
    </head>
    <body ng-app="ukfn"> 
        <!-- TOP NAV - START -->
        <div data-spy="affix" data-offset-top="40">
            <nav class="navbar navbar-default navbar-custom" id="top-nav">
                <div class="container-fluid col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12" >
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-bar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ URL::to('/')}}">
                            <img src="{{ asset('pictures/logo.png') }}" class="logo">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="top-nav-bar">
                        <ul class="nav navbar-nav">
                            <li class="{{ Request::is('sig*') ? 'active' : '' }}">
                                {{ Html::link('/sig', 'SIG') }}
                            </li>
                            <li class="{{ Request::is('srv*') ? 'active' : '' }}">
                                {{ Html::link('/srv', 'SRV') }}
                            </li>
                            <li class="{{ Request::is('talks*') ? 'active' : '' }}">
                                {{ Html::link('/talks', 'Talks') }}
                            </li>
                            <li class="{{ Request::is('admin*') ? 'active' : '' }}">
                                {{ Html::link('/admin', 'Admin') }}
                            </li>
                            <li class="{{ Request::is('contact') ? 'active' : '' }}">
                                {{ Html::link('/contact', 'Contact') }}
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if(Auth::user())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">{{ Auth::user()->name }} {{ Auth::user()->surname }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->group_id == 1)
                                    <li>
                                        <a href='{{ URL::to('/panel') }}'>
                                            <span class="glyphicon glyphicon-wrench margin-right"></span>
                                            Admin Panel
                                        </a>
                                    </li>
                                    @elseif(Auth::user()->sigLeader())
                                    <li>
                                        <a href='{{ URL::to('/panel/sig/edit/'.Auth::user()->sigLeader()[0]) }}'>
                                            <span class="glyphicon glyphicon-wrench margin-right"></span>
                                            Manage SIG
                                        </a>
                                    </li>
                                    @endif
                                    <li>
                                        <a href='{{ URL::to('/myaccount') }}'>
                                            <span class="glyphicon glyphicon-user margin-right"></span>
                                            My Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::to('/logout') }}">
                                            <span class="glyphicon glyphicon-log-out margin-right"></span>
                                            Logout
                                        </a>
                                    </li>
                                </ul>                                
                            </li>

                            @else
                            <li class="{{ Request::is('register') ? 'active' : '' }}">
                                <a href="{{ URL::to('/register') }}">Register</a>
                            </li>
                            <li class="{{ Request::is('login') ? 'active' : '' }}">
                                <a href="{{ URL::to('/login') }}">Login</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- TOP NAV - END -->
        <!-- MAIN CONTENT - START -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12">
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- MAIN CONTENT - END -->
        <!-- SUBSCRIPTION - START -->
        <div class="container-fluid signup" id="subscription-sign-up-form">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12">
                    {!! Form::open(['url' => 'signup#subscription-sign-up-form']) !!}
                    <div class="row">
                        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 col-xs-12 line-break ">
                            <span class='display-block h3 text-danger text-uppercase'>Sign up to our mailing list</span>
                            <span class='display-block line-break'>for information on jobs, events and news in UK fluids</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-offset-3 col-lg-4 col-md-offset-2 col-md-6 col-sm-offset-1 col-sm-8 col-xs-12">
                            <div class='form-group {{ $errors->has('subscription-email') ? ' has-error line-break-dbl' : '' }} input-group-lg'>
                                {!! Form::label('subscription-email', 'Subscribe :', ['class' => 'sr-only']) !!}
                                {!! Form::text('subscription-email', null, ['class' => 'form-control','placeholder' => 'your@email.com']) !!}
                                @if ($errors->has('subscription-email'))

                                <span class="display-block text-danger line-break-top">
                                    <span>{{ $errors->first('subscription-email') }}</span>
                                </span>
                                @endif
                                @if (Session::has('subscription_signup_ok'))

                                <strong class="display-block text-success line-break-top">
                                    {{ Session::get('subscription_signup_ok') }}
                                </strong>
                                @endif

                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 btn-group col-sm-2 col-xs-12 input-group-lg">
                            <input type="submit" class="btn btn-lg btn-default text-uppercase btn-signup" name="submit-subscribe" value="Subscribe">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- SUBSCRIPTION - END -->
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
