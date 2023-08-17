<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ get_favicon() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">   
    <link rel="stylesheet" href="{{  url(mix('css/vendor.css')) }}">
    <link rel="stylesheet" href="{{  url(mix('css/app.css')) }}">
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/jquery-ui/jquery-ui.css')}}">
		
		<!-- Bootstrap Core CSS -->
   
	
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap-extend.css')}}">
	
	
	
	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/bootstrap-switch/switch.css')}}">
    <!-- theme style -->
	<link rel="stylesheet" href="{{URL::asset('css/master_style.css')}}">
	
	
	<link rel="stylesheet" href="{{URL::asset('css/skins/_all-skins.css')}}">    
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
         @include('notification_bell') 
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img class="mr-2 staff-profile-image-small" src="{{ get_avatar_small_thumbnail(auth()->user()->photo) }}"> {{ auth()->user()->first_name }}</a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01" style="min-width: 300px; font-size: 14px;">
               @if(auth()->user()->is_administrator)
               <h6 class="dropdown-header text-center">@lang('form.create_new')</h6>
               <div class="row" style="margin-left: 0px; margin-right: 0px;">
                  <div class="col-md-6">
                     <a href="{{ route('add_invoice_page') }}" class="dropdown-item">@lang('form.invoice')</a>
                     <a href="{{ route('add_estimate_page') }}" class="dropdown-item">@lang('form.estimate')</a>
                     <a href="{{ route('add_proposal_page') }}" class="dropdown-item">@lang('form.proposal')</a>
                     <a href="{{ route('add_expense_page') }}" class="dropdown-item">@lang('form.expense')</a>
                     <a href="{{ route('add_vendor_page') }}" class="dropdown-item">@lang('form.vendor')</a>
                  </div>
                  <div class="col-md-6">
                     <a href="{{ route('add_task_page') }}" class="dropdown-item">@lang('form.task')</a>
                     <a href="{{ route('add_ticket_page') }}" class="dropdown-item">@lang('form.ticket')</a>
                     <a href="{{ route('add_projects') }}" class="dropdown-item">@lang('form.project')</a>
                     <a href="{{ route('add_customer_page') }}" class="dropdown-item">@lang('form.customer')</a>
                     <a href="{{ route('add_lead_page') }}" class="dropdown-item">@lang('form.lead')</a>
                  </div>
               </div>
               <hr>
               @endif
               <a class="dropdown-item" href="{{ route('member_profile', auth()->user()->id) }}">@lang('form.my_account')</a>
               <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> @lang('form.logout')</a>
               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
               </form>
            </div>
         </li>
      </ul>
      </div>
    </nav>
  </header>
  
      <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
		
      
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">
         <li>
          <a href="{{url('/home')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
         
		  
        </li>
		<li>
          <a href="{{ route('projects_list') }}">
            <i class="fa fa-bars"></i>
            <span>Projects</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>

        </li>
		<li>
          <a href="{{url('/administrator/fermentations')}}">
            <i class="fa fa-bars"></i>
            <span>CVs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>

        </li>
		<li>
          <a href="{{url('/administrator/fermentations')}}">
            <i class="fa fa-bars"></i>
            <span>Partners</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>

        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-bars"></i>
            <span>RCMRD Documents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="{{url('/administrator/profile')}}"><i class="mdi mdi-dots-horizontal"></i>RCMRD Profile</a></li>
			<li><a href="{{url('/administrator/profile')}}"><i class="mdi mdi-dots-horizontal"></i>Business Permit</a></li>

          </ul>
        </li>
		<li>
          <a href="{{url('/administrator/user-list')}}">
            <i class="fa fa-bars"></i>
            <span>Staff</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-bars"></i>
            <span>Account</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="{{url('/administrator/profile')}}"><i class="mdi mdi-dots-horizontal"></i>Profile</a></li>
			<li><a href="{{url('/administrator/profile')}}"><i class="mdi mdi-dots-horizontal"></i>Projects Assigned</a></li>
			<li><a href="{{url('/administrator/edit-password')}}"><i class="mdi mdi-dots-horizontal"></i>Change Password</a></li>

          </ul>
        </li>
            
      </ul>
    </section>
	  
	<div class="sidebar-footer">
		<!-- item-->
		<a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="link" data-toggle="tooltip" title="" data-original-title="Logout" aria-describedby="tooltip995664"><i class="fa fa-power-off"></i></a>
	<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
	
	</div>
  </aside>
    

   <!-- Sidebar Holder -->
   <!--@include('layouts.menu')-->
   <!-- Page Content Holder -->
   
   @yield('contents')
   
   
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
<script type="text/javascript">

 <?php $pusher = get_pusher_api_info(); ?>

    global_config = {
        csrf_token                      : "{{ csrf_token() }}",
        url_get_unread_notifications    : "{{ route('get_unread_notifications') }}", 
        lang_no_record_found            : "{{ __('form.no_record_found') }}",
        url_global_search               : "{{ route('global_search') }}",
        url_upload_attachment           : "{{ route('upload_attachment') }}",
        url_delete_temporary_attachment : "{{ route('delete_temporary_attachment')}}",
        txt_delete_confirm_title        : "{{ __('form.delete_confirm_title') }}",
        txt_delete_confirm_text         : "{{ __('form.delete_confirm_text') }}",
        txt_btn_cancel                  : "{{ __('form.btn_cancel') }}",
        txt_yes                         : "{{ __('form.yes') }}",        
        is_pusher_enable                : {{ (is_pusher_enable()) ?  'true' : 'false' }},
        url_patch_note                  : "{{ route('patch_note') }}",
        url_delete_note                 : "{{ route('delete_note') }}"

    };

    <?php if(is_pusher_enable()) {?>

        global_config.pusher_log_status = {{ ( App::environment('local') || App::environment('development') ) ? 'true' : 'false' }};
        global_config.pusher_app_key    = '{{ $pusher->app_key }}';
        global_config.pusher_cluster    = "{{ ($pusher->app_cluster) ? $pusher->app_cluster : 'mt1' }}";
        global_config.pusher_channel    = 'chanel_{{ auth()->user()->id }}';

    <?php } ?>    

</script>
  
<script type="text/javascript" src="{{  url(mix('js/app.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/vendor.js')) }}"></script>
<script  type="text/javascript" src="{{  url(mix('js/main.js')) }}"></script>
<script  type="text/javascript" src="{{ asset('vendor/gantt-chart/js/modified_jquery.fn.gantt.min.js') }}"></script>
{{ load_extended_files('admin_js') }}
<script type="text/javascript">  

  accounting.settings = <?php echo json_encode(config('constants.money_format')) ?>;

    $(function(){

         <?php if($flash = session('message')) {?>
            $.jGrowl("<?php echo $flash; ?>", { position: 'bottom-right'});
        <?php } ?>

        $('.currency_changed').change(function(){
            $(this)
        });
    });
  


$(document).on('click','.change_task_status',function(e){

        e.preventDefault();

        var url       = $(this).attr("href");
        var name      = $(this).data('name');
        var id        = $(this).data('id');
        var task_id   = $(this).data('task');


        if(url)
        {
          $scope = this;
          $.post(url , { "_token": global_config.csrf_token, task_id : task_id, status_id : id }).done(function( response ) {
                      
              if(response.status == 1)
              {
                $($scope).closest(".dropdown").find(".btn").text(name);
              }
              
          });

        }       

    });

$(document).ready(function() {
  $(document).on('focus', ':input', function() {
    $(this).attr('autocomplete', 'off');
  });
});

</script>


<!-- @if(is_pusher_enable())
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script> 
@endif  -->
<script  src="{{  url(mix('js/tinymce.js')) }}"></script>

<script src="{{URL::asset('assets/vendor_components/jquery-3.3.1/jquery-3.3.1.min.js')}}"></script>
	
	<!-- jQuery UI 1.11.4 -->
	<script src="{{URL::asset('assets/vendor_components/jquery-ui/jquery-ui.js')}}"></script>
	
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
	
	<!-- popper -->
	<script src="{{URL::asset('assets/vendor_components/popper/dist/popper.min.js')}}"></script>
	
	<!-- Bootstrap 4.0-->
	<script src="{{URL::asset('assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<!-- FLOT CHARTS -->
	<script src="{{URL::asset('assets/vendor_components/Flot/jquery.flot.js')}}"></script>
	
	<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
	<script src="{{URL::asset('assets/vendor_components/Flot/jquery.flot.resize.js')}}"></script>
	
	<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
	<script src="{{URL::asset('assets/vendor_components/Flot/jquery.flot.pie.js')}}"></script>
	
	<!-- jQuery Knob Chart -->
	<script src="{{URL::asset('assets/vendor_components/jquery-knob/js/jquery.knob.js')}}"></script>
	
	<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
	<script src="{{URL::asset('assets/vendor_components/Flot/jquery.flot.categories.js')}}"></script>
	
	<!-- ChartJS -->
	<script src="{{URL::asset('assets/vendor_components/chart.js-master/Chart.min.js')}}"></script>
	
	
	
	<!-- Sparkline -->
	<script src="{{URL::asset('assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.js')}}"></script>
	
	
	
	<!-- Slimscroll -->
	<script src="{{URL::asset('assets/vendor_components/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
	
	<!-- FastClick -->
	<script src="{{URL::asset('assets/vendor_components/fastclick/lib/fastclick.js')}}"></script>
	
	<!-- peity -->
	<script src="{{URL::asset('assets/vendor_components/jquery.peity/jquery.peity.js')}}"></script>
	
<script src="{{URL::asset('js/template.js')}}"></script>

@yield('onPageJs')
 

</body>

</html>
