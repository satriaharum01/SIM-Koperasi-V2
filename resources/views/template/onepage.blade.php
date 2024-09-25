<!DOCTYPE html>
<html lang="en">
	<head>
    	<!-- 
    	Boxer Template
    	http://www.templatemo.com/tm-446-boxer
    	-->
		<meta charset="utf-8">
		<title>{{env('APP_NAME')}} - {{$title}}</title>
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link href="{{ asset('landing/login/img/logo.png') }}" rel="icon">
        @include('template/onepagecss')
        @yield('css')
		
	</head>
	<body>
        <!-- Validator -->
<?php

use Illuminate\Support\Facades\Auth;

if (isset($validation)) : ?>
    <div class="alert alert-danger alert-error"><?= $validation->listErrors() ?></div>
<?php endif; ?>

		<!-- start preloader -->
		<div class="preloader">
			<div class="sk-spinner sk-spinner-rotating-plane"></div>
    	 </div>
		<!-- end preloader -->
		<!-- start navigation -->
		<nav class="navbar navbar-default navbar-fixed-top templatemo-nav nav-image" role="navigation">
			<div class="container">
                    <div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-6">
                            <h5 class="text-right"><i class="fa fa-map-marker"></i> <span class="mx-2"> Jl.Pelabuhan Pangkalan Susu</span></h5>
						</div>
						<div class="col-md-4">
                            <h6>Selamat Datang, {{Auth::user()->name}}</h6>
                        </div>
					</div>
                    <div class="row">
						<div class="col-md-8"></div>
						<div class="col-md-4">
                            <h4><i class="fa fa-phone"></i> <span class="mx-2"> 061 - 40404940</span> </h4>
						</div>
					</div>
				<div class="navbar-header ">
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
						<span class="icon icon-bar"></span>
					</button>
					<a href="#" class="navbar-brand flex-navbar">
                        <img style="width:auto; height:50px;" src="{{ asset('landing/login/img/logo.png') }}" alt="logo">
                        <span class="mx-4">
                        {{env('APP_NAME')}}</span>
                    </a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right text-uppercase">
						<li><a href="{{url('nasabah/dashboard')}}" class="{{ (request()->is('nasabah/dashboard')) ? 'current' : '' }}">Home</a></li>
						<li><a href="{{url('nasabah/pinjaman')}}" class="{{ (request()->is('nasabah/pinjaman')) ? 'current' : '' }}{{ (request()->is('nasabah/pinjaman/*')) ? 'current' : '' }}">Pinjaman</a></li>
						<li><a href="{{url('nasabah/pembayaran')}}" class="{{ (request()->is('nasabah/pembayaran')) ? 'current' : '' }}">Pembayaran</a></li>
						<li><a href="{{url('nasabah/simpanan')}}" class="{{ (request()->is('nasabah/simpanan')) ? 'current' : '' }}">Simpanan</a></li>
						<li><a href="{{url('nasabah/profil')}}" class="{{ (request()->is('nasabah/profil')) ? 'current' : '' }}">Profile</a></li>
						<li><a href="#" data-toggle="modal" data-target="#logoutModal">Logout</a></li>
					</ul>
				</div>
			</div>
            
			<div class="overlay-white"></div>
		</nav>
		<!-- end navigation -->
		@yield('content')
		<footer>
			<div class="container">
				<div class="row justify-content-center">
					<p>Copyright © <?=date('Y')?> SIM Koperasi </p>
				</div>
			</div>
		</footer>
		<!-- end footer -->
		
    	<!-- Logout Modal-->
    	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	    <div class="modal-dialog" role="document">
    	        <div class="modal-content">
    	            <div class="modal-header flex-row">
    	                <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
    	                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
    	                    <span aria-hidden="true">×</span>
    	                </button>
    	            </div>
    	            <div class="modal-body text-center">Pilih "Logout" Untuk Mengakhiri Sesi.</div>
    	            <div class="modal-footer d-flex justify-content-end">
    	                <button class="btn btn-danger mx-2" type="button" data-dismiss="modal">Cancel</button>
    	                <form id="logout-form" action="{{ route('logout') }}" method="POST">
    	                    @csrf
    	                </form>
    	                <a class="btn btn-primary" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    	            </div>
    	        </div>
    	    </div>
    	</div>
		@include('template/onepagejs')
        @yield('js')
	</body>
</html>