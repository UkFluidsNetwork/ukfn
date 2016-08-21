<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

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
                            UK Fluids Network
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
                            <li><a href="#">Directory</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">SIGs <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="index.php?page=sig-overview">Overview</a></li>
                                    <li><a href="#">SIG1</a></li>
                                    <li><a href="#">SIG2</a></li>
                                    <li><a href="#">SIG3</a></li>
                                    <li><a href="#">SIG4</a></li>
                                    <li><a href="#">Interesting flow</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Talks</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Resources <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Overview</a></li>
                                    <li><a href="#">Tips and Tricks</a></li>
                                    <li><a href="#">Courses</a></li>
                                    <li><a href="#">Clips and pictures</a></li>
                                    <li><a href="#">Discussion board</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Media</a></li>
                            <li><a href="#">Admin</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><span class="glyphicon glyphicon-user submenu-icons"></span> Register</a></li>
                                    <li><a href="#"><span class="glyphicon glyphicon-log-in submenu-icons"></span> Login</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="nav navbar-nav navbar-right navbar-form" role="search"> 
                            <div class="input-group">
                                <label class='sr-only' for='search-term'>Search :</label>
                                <input type="text" class="form-control" placeholder="Search..." name="search-term" id="search-nav" required="required">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        
        <div class="container-fluid" id="main-content">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-8 col-md-12">  
