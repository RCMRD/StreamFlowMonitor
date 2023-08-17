@extends('layouts.sisibo-master')
@section('title')
	<title>Settings</title>
@endsection
@section('css')

 
@endsection

@section('content')
<div class="content-wrapper">
<section class="content">

    @include('setup.menu')

    @yield('setting_page')
	
	</section>
    <!-- /.content -->
  </div>

@endsection

@section('onPageJs')

    @yield('innerPageJS')


@endsection