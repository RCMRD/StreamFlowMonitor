<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{URL::asset('images/favicon.ico')}}">

    <title>Recover Password</title>
  
	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{URL::asset('assets/vendor_components/bootstrap/dist/css/bootstrap.min.css')}}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{URL::asset('css/bootstrap-extend.css')}}">

	<!-- Theme style -->
	<link rel="stylesheet" href="{{URL::asset('css/master_style2.css')}}">

	<!--  Admin skins -->
	<link rel="stylesheet" href="{{URL::asset('css/skins/_all-skins.css')}}">	

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<style>
	.bg {
  /* The image used */
  background-image: url("/../images/pms_bg4.jpg");

  /* Full height */
  height: 100%; 

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
	
	</style>
	<style> 
.form-control::-webkit-input-placeholder {
  color: #fff;
}
.form-control:-moz-placeholder {
  color: #fff;
}
.form-control::-moz-placeholder {
  color: #fff;
}
.form-control::placeholder {
  color: #fff;
}
.form-control:-ms-input-placeholder {
  color: #fff;
}
</style> 

</head>
<body class="hold-transition login-page bg">
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">
			<div class="col-lg-4 col-md-8 col-12">
				<div class="login-box bg-img rounded" style="background-image:url({{URL::asset('images/gallery/landscape6.jpg')}});" data-overlay="5">
				  <div class="login-box-body pb-20">
				  <center style="padding-top: 10px"> <img src="{{URL::asset('images/rcmrd.jpg')}}" width="70" height="70"/>
					
					<h3 class="text-center">Reset Password</h3>
					@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

					<form method="POST" action="{{ route('password.email') }}" class="form-element text-white">
					{{ csrf_field() }}
					  <div class="form-group has-feedback">
						<input id="email" type="text" class="form-control text-white" name="email" placeholder="Email">
						<span class="ion ion-email form-control-feedback text-white"></span>
						@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
					  </div>      
					  <div class="row">
						<!-- /.col -->
						<div class="col-12 text-center">
						  <button type="submit" class="btn btn-success btn-block text-uppercase" onclick="waitingDialog.show('Please Wait', {dialogSize: 'sm', progressType: 'success'})">Send Password Reset Link</button>
						</div>
						<!-- /.col -->
					  </div>
					</form>

				  </div>
				  <!-- /.login-box-body -->
				</div>
				<!-- /.login-box -->
			
			</div>
		</div>
	</div>


	<!-- jQuery 3 -->
	<script src="{{URL::asset('assets/vendor_components/jquery-3.3.1/jquery-3.3.1.min.js')}}"></script>
	
	<!-- popper -->
	<script src="{{URL::asset('assets/vendor_components/popper/dist/popper.min.js')}}"></script>
	
	<!-- Bootstrap 4.0-->
	<script src="{{URL::asset('assets/vendor_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('js/waiting.js')}}"></script>

</body>
</html>
