<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>NetCafe Omboy</title>


<!--MOBILE VIEW-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

<!--FONTS-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


<!--CSS-->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/component.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/flexslider.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/menu.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('frontend/css/responsive.css') }}">

<!--JS-->
<script src="{{ URL::asset('frontend/js/modernizr.custom.js') }}"></script>
<script src="{{ URL::asset('frontend/js/responsive-nav.js') }}"></script>



<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>

<!-- Paste this code after body tag -->
 <div class="se-pre-con"></div>
 <!-- Ends -->

 @include('frontend/layouts.header')

 @yield('content')
<!--BANNER-->

 @include('frontend/layouts.footer')

<!--JS-->
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="{{ URL::asset('frontend/js/classie.js') }}"></script>
<script src="{{ URL::asset('frontend/js/uisearch.js') }}"></script>
<script src="{{ URL::asset('frontend/js/jquery.flexslider.js') }}"></script>
<script src="{{ URL::asset('frontend/js/script.js') }}"></script>
<script src="{{ URL::asset('frontend/js/fastclick.js') }}"></script>
<script src="{{ URL::asset('frontend/js/scroll.js') }}"></script>
<script src="{{ URL::asset('frontend/js/fixed-responsive-nav.js') }}"></script>
<script src="{{ URL::asset('frontend/js/waypoints.min.js') }}"></script>

</body>
</html>