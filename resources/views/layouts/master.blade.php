<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="web_author" content="Javier Arias, javier@arias.re">
        {!! SEO::generate() !!}
        <link href="{{ elixir('css/main.css') }}" rel="stylesheet"
              type="text/css">

        <script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Organization",
          "name": "UK Fluids Network",
          "alternateName": "UKFN",
          "description": "UKFN is a network of academic and industrial research groups, focused on innovative developments and applications in Fluid Mechanics.",
          "url": "https://fluids.ac.uk",
          "logo": "https://fluids.ac.uk/pictures/ukfn-logo-250.png",
          "email": "info@fluids.ac.uk",
          "foundingDate": "2016-09-01",
          "location": {
            "@type": "PostalAddress",
            "addressCountry": "UK"
          },
          "sameAs": [
            "https://twitter.com/UKFluidsNetwork",
            "https://www.facebook.com/UKFluids/"
          ],
          "sponsor": {
            "@type": "Organization",
            "name": "EPSRC",
            "url": "https://www.epsrc.ac.uk/",
            "logo": "https://www.epsrc.ac.uk/epsrc/includes/themes/EPSRC/images/logo.png"
          }
        }
        </script>

        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/analytics.js') }}" async="async"></script>

        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage"
              content="{{ asset('pictures/favicon/ms-icon-144x144.png?v=2') }}">
        <meta name="theme-color" content="#ffffff">
        <link rel="apple-touch-icon" sizes="57x57"
              href="{{ asset('pictures/favicon/apple-icon-57x57.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="60x60"
              href="{{ asset('pictures/favicon/apple-icon-60x60.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="72x72"
              href="{{ asset('pictures/favicon/apple-icon-72x72.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="76x76"
              href="{{ asset('pictures/favicon/apple-icon-76x76.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="114x114"
              href="{{ asset('pictures/favicon/apple-icon-114x114.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="120x120"
              href="{{ asset('pictures/favicon/apple-icon-120x120.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="144x144"
              href="{{ asset('pictures/favicon/apple-icon-144x144.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="152x152"
              href="{{ asset('pictures/favicon/apple-icon-152x152.png?v=2') }}">
        <link rel="apple-touch-icon" sizes="180x180"
              href="{{ asset('pictures/favicon/apple-icon-180x180.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="192x192"
            href="{{ asset('pictures/favicon/android-icon-192x192.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="32x32"
              href="{{ asset('pictures/favicon/favicon-32x32.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="96x96"
              href="{{ asset('pictures/favicon/favicon-96x96.png?v=2') }}">
        <link rel="icon" type="image/png" sizes="16x16"
              href="{{ asset('pictures/favicon/favicon-16x16.png?v=2') }}">
        <link rel="manifest" type="application/json"
              href="{{ asset('/manifest.json') }}">
        @yield('head')
    </head>
    <body>
        <!-- NAVBAR - START -->
        <div id="menu-bar" data-spy="affix" data-offset-top="40">

        @if ($_SERVER['SERVER_NAME'] == "ukfluids.net")
        <div style="width:100%;height:40px;background-color:#1B75BB;color:white;text-align:center;font-size:22px;padding:13px;padding-bottom:45px;">
          The UK Fluids Network has a new address: <a style="color:white;" href="https://fluids.ac.uk">fluids.ac.uk</a>
        </div>
        @endif

            <nav class="navbar navbar-default navbar-custom" id="top-nav">
                <div class="container-fluid col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12" >
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-bar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ URL::to('/')}}">
                            <img src="{{ asset('pictures/ukfn-logo-250.png') }}"
                                 alt="UK Fluids Network logo"
                                 class="logo">
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="top-nav-bar">
                        <ul class="nav navbar-nav">
                            <li class="{{ Request::is('sig*') ? 'active' : '' }}">
                                {{ Html::link('/sig', 'SIG', ['title' => 'Special Interest Groups']) }}
                            </li>
                            <li class="{{ Request::is('srv*') ? 'active' : '' }}">
                                {{ Html::link('/srv', 'SRV', ['title' => 'Short Research Visits']) }}
                            </li>
                            <li class="{{ Request::is('talks*') ? 'active' : '' }}">
                                {{ Html::link('/talks', 'Talks', ['title' => 'Fluids Related Seminars']) }}
                            </li>
                            <li class="{{ Request::is('researcher-resources*') ? 'active' : '' }}">
                                {{ Html::link('/researcher-resources', 'Resources', ['title' => 'Researcher Resources']) }}
                            </li>
                          <li class="{{ Request::is('directory*') ? 'active' : '' }}">
                                {{ Html::link('/directory', 'Directory', ['title' => 'Researchers Directory']) }}
                            </li>
                            <li class="{{ Request::is('competition*') ? 'active' : '' }}">
                                {{ Html::link('/competition', 'Competition', ['title' => 'Photo and video competition']) }}
                            </li>
                            <li class="{{ Request::is('connect*') ? 'active' : '' }}">
                                {{ Html::link('/connect', 'Connect', ['title' => 'Information about the network']) }}
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            @if(Auth::user())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                                   aria-expanded="false">{{ Auth::user()->name }} {{ Auth::user()->surname }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->isAdmin())
                                    <li>
                                        <a href='{{ URL::to('/panel') }}'>
                                            <span class="glyphicon glyphicon-wrench margin-right"></span>
                                            Admin Panel
                                        </a>
                                    </li>
                                    @elseif(Auth::user()->isSigEditor())
                                        @foreach (Auth::user()->editableSigs() as $sig)
                                        <li>
                                            <a href='{{ URL::to('/panel/sig/edit/'.$sig->id) }}'>
                                                <span class="glyphicon glyphicon-wrench margin-right"></span>
                                                Administer {{$sig->shortname}}
                                            </a>
                                        </li>
                                        @endforeach
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
                            <li class="{{ Request::is('login') ? 'active' : '' }}">
                                <a href="{{ URL::to('/login') }}">Login</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- NAVBAR - END -->
        <!-- NOSCRIPT - START -->
        <noscript>
            <div class="alert alert-danger" role="alert">
                This site will not work properly while JavaScript is disabled.
            </div>
        </noscript>
        <!-- NOSCRIPT - END -->
        <!-- MAIN CONTENT - START -->
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 col-xs-12">
                    @if (Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- MAIN CONTENT - END -->
        <!-- FOOTER - START -->
        @include('layouts.footer')
        <!-- FOOTER - END -->
    </body>
</html>
