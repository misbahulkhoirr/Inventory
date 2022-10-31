<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="_token" id="token" value="{{csrf_token()}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="{{ config('app.name', 'Laravel') }}" />
    <!-- Favicon icon -->
    <!-- <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon"> -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    
    @stack('css')
    
    
</head>
<body class="">
	<!-- [ Pre-loader ] start -->
	<!-- <div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div> -->
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	@include('components.nav')
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	@include('components.header')
	<!-- [ Header ] end -->
	
	

    @yield('content')

    <!-- Required Js -->
    <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/ripple.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
	<!-- <script src="{{asset('assets/js/menu-setting.min.js')}}"></script> -->

    @stack('js')

</body>
</html>
