<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" href="{{URL::asset('images/favicon.ico')}}">
	
	@yield('title')
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">   
    <link rel="stylesheet" href="{{  url(mix('css/vendor.css')) }}">
	
	
	   <!-- <link rel="stylesheet" href="{{URL::asset('assets/vendor_components/jquery-ui/jquery-ui.css')}}">-->
		
		<!-- Bootstrap Core CSS -->
   
	
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/bootstrap/dist/css/bootstrap.css')}}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap-extend.css')}}">
	
	
	
	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/bootstrap-switch/switch.css')}}">
	
	<!-- theme style -->
	<link rel="stylesheet" href="{{URL::asset('css/master_style.css')}}">
	
	
	<link rel="stylesheet" href="{{URL::asset('css/skins/_all-skins.css')}}">
	
	 <!-- Vector CSS -->
    <!--<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/jvectormap/lib2/jquery-jvectormap-2.0.2.css')}}">-->
   


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
	
    <style>
.four-boot .dropdown .btn{
    
    overflow: hidden !important;
    white-space: nowrap !important;
    display: block !important;
    text-overflow: ellipsis !important;
}
.toolbar {
    float:left;
}
 .list-group-item  .remove_tmp_attachment{
          float: right !important;
          text-align: right;

        }

        iframe  .panel-heading .panel-title{
          display: none !important;
        }

  
  /* relevant styles */
.img__wrap {
  position: relative;
 
}

.img__description_layer {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(36, 62, 206, 0.6);
  color: #fff;
  visibility: hidden;
  opacity: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 30px;

  /* transition effect. not necessary */
  transition: opacity .2s, visibility .2s;
}

.img__wrap:hover .img__description_layer {
  visibility: visible;
  opacity: 1;
}

.img__description {
  transition: .2s;
  transform: translateY(1em);
}

.img__wrap:hover .img__description {
  transform: translateY(0);
}

.daterangepicker{
    z-index: 1100 !important;
}
.btn{
  border-radius: 2px;

}
</style>
{{ load_extended_files('admin_css') }}
	
	

@yield('css')

</head>
<body class="hold-transition skin-blue dark-sidebar sidebar-mini">

<div class="wrapper">
	
  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">
      <!-- mini logo -->
	  <b class="logo-mini">
		  <span class="light-logo"><img src="{{URL::asset('images/rcmrd2.png')}}" alt="logo"></span>
		  
	  </b>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
	  

      <div class="navbar-custom-menu">
     <ul class="navbar-nav ml-auto">
         

         
      </ul>
      </div>
    </nav>
  </header>
  



	
@yield('content')


<footer class="main-footer">
    <div class="pull-right d-none d-sm-inline-block">
        <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
		  <li class="nav-item">
			<a class="nav-link" href="javascript:void(0)"></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="#"></a>
		  </li>
		</ul>
    </div>
	  &copy; 2020 <a href="https://www.rcmrd.org">RCMRD</a>. All Rights Reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
      


 




</div>
<!-- ./wrapper -->

<script type="text/javascript">


 

</script>
  
<script type="text/javascript" src="{{  url(mix('js/app.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/vendor.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/main.js')) }}"></script>

<script  type="text/javascript" src="{{ asset('vendor/gantt-chart/js/modified_jquery.fn.gantt.min.js') }}"></script>
{{ load_extended_files('admin_js') }}



<!-- @if(is_pusher_enable())
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script> 
@endif  -->
<script  src="{{  url(mix('js/tinymce.js')) }}"></script>


	
	<!-- Slimscroll -->
	<script src="{{URL::asset('assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
	

	

	
	
	<script src="{{URL::asset('js/template.js')}}"></script>
	<script src="{{URL::asset('js/waiting.js')}}"></script>
	
	
	
	
	
	
	

 
@yield('onPageJs')
	
	
</body>
</html>

