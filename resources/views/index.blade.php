<!doctype html>
<html class="no-js" lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head -->
    <!-- SITE TITLE -->
    <title>Go Cool</title>
    <meta name="description" content="Event, Conference  " />
    <meta name="keywords" content="Event, Conference " />
    <meta name="author" content="softnet.co.in" />
    <!-- twitter card starts from here, if you don't need remove this section -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@yourtwitterusername" />
    <meta name="twitter:creator" content="@yourtwitterusername" />
    <meta name="twitter:url" content="http://yourdomain.com/" />
    <meta name="twitter:title" content="Crystal Crown" /> <!-- maximum 140 char -->
    <meta name="twitter:description" content="Crystal Crown " /> <!-- maximum 140 char -->
    <meta name="twitter:image" content="/assets/img/twittercardimg/twittercard-280-150.jpg" />  <!-- when you post this page url in twitter , this image will be shown -->
    <!-- twitter card ends from here -->
    <!-- facebook open graph starts from here, if you don't need then delete open graph related  -->
    <meta property="og:title" content="Your home page title" />
    <meta property="og:url" content="http://your domain here.com" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="Your site name here" />
    <!--meta property="fb:admins" content="" /-->  <!-- use this if you have  -->
    <meta property="og:type" content="website" />
    <meta property="og:image" content="/assets/img/opengraph/fbphoto.jpg" /> <!-- when you post this page url in facebook , this image will be shown -->
    <!-- facebook open graph ends from here -->

    <!--  FAVICON AND TOUCH ICONS -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.png" /> <!-- this icon shows in browser toolbar -->
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="/assets/libs/bootstrap/css/bootstrap.min.css" media="all" />
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="/assets/libs/fontawesome/css/font-awesome.min.css" media="all"/>
    <!-- GOOGLE FONT -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700%7cLato:300,400,700"/>
    <!-- OWL CAROUSEL CSS -->
    <link rel="stylesheet" href="/assets/libs/owlcarousel/owl.carousel.min.css" media="all" />
    <link rel="stylesheet" href="/assets/libs/owlcarousel/owl.theme.default.min.css" media="all" />
    <!-- POPUP-->
    <link rel="stylesheet" href="/assets/libs/maginificpopup/magnific-popup.css" media="all"/>
    <!-- MASTER  STYLESHEET  -->
    <link id="csi-master-style" rel="stylesheet" href="/assets/css/style-default.min.css" media="all" />
    <!-- MODERNIZER CSS  -->
    <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>

	<style>
	.height{
		height:33px;
	}
	</style>
</head>
<body class="page page-template">
<div class="csi-container ">
    <!-- ***  ADD YOUR SITE CONTENT HERE *** -->
    <!--HEADER-->
    <header>
        <div id="csi-header" class="csi-header csi-banner-header">
            <div class="csi-header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <nav class="navbar navbar-default csi-navbar">
                                <div class="csicontainer">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                                data-target=".navbar-collapse">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <div class="csi-logo">
                                            <a href="{{route('index')}}">
                                                <img src="/assets/img/images/logo.png" alt="Logo"/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse navbar-collapse">
                                        <ul class="nav navbar-nav csi-nav">
                                            <li class="dropdown">
                                                <a href="{{route('index')}}" class=" active" role="button" aria-haspopup="true" aria-expanded="false">Home  </a>

                                            </li>
                                            <li class="dropdown">

                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About Us<span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    @foreach($toppage as $t)
                                                    <li><a href="{{ url("page/".$t->seoUrl)}}">{{ $t->pageName}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                            <li><a class="csi-scroll" href="{{route('gallery')}}">Gallery</a></li>
                                            <li><a class="csi-scroll" href="{{route('faq')}}">FAQ</a></li>
                                            <li><a class="csi-scroll" href="{{route('contactus')}}">Contact</a></li>
                                            <!--<li><a class="csi-scroll csi-btn" href="booking.html">Booking</a></li>-->
                                        </ul>
                                    </div>
                                    <!--/.nav-collapse -->
                                </div>
                            </nav>
                        </div>
                    </div>
                    <!--//.ROW-->
                </div>
                <!-- //.CONTAINER -->
            </div>
            <!-- //.INNER-->
        </div>
    </header>
    <!--HEADER END-->
</div>
