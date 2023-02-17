@extends('layouts.topbar.app')

@section('title','Main Menu')

@section('brand','Liquid CO2 Manufacture')

@section('content')

<div class="container-fluid">
    <div class="row text-center">
        @if ($helpdesk)
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('helpdesk.index') }}">
                <div class="card-box widget-flat border-custom bg-custom text-white">
                    <i class="fi-menu"></i>
                    <h3 class="m-b-10">Helpdesk</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Sistem Ticketing</p>
                </div>
            </a>
        </div>
        @endif
        @if ($edoc)
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('dashboard_edoc.index') }}">
                <div class="card-box widget-flat border-custom bg-success text-white">
                    <i class="fi-paper"></i>
                    <h3 class="m-b-10">E-Document</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Sistem kontrol dokumen</p>
                </div>
            </a>
        </div>
        @endif
        @if ($okm)
			<div class="col-sm-6 col-xl-3">
				<a href="{{ route('dashboard_okm.index') }}">
					<div class="card-box widget-flat border-custom bg-warning text-white">
						<i class="fa fa-book"></i>
						<h3 class="m-b-10">OKM</h3>
						<p class="text-uppercase m-b-5 font-13 font-600">Sistem e-learning</p>
					</div>
				</a>
			</div>
        @endif
        @if ($asset)
			<div class="col-sm-6 col-xl-3">
				<div class="card-box widget-flat border-custom bg-danger text-white">
					<i class="fa fa-cubes"></i>
					<h3 class="m-b-10">MIG Aset</h3>
					<p class="text-uppercase m-b-5 font-13 font-600">Sistem pendataan aset</p>
				</div>
			</div>
        @endif
			@if($phonebook)
             @if(Auth::user()->nik == '184' || Auth::user()->nik =='019' )
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('phonebook.index') }}">
                        <div class="card-box widget-flat border-custom text-white" 
                            style='background-color:#09deed;'>
                            <i class="fa fa-phone-square"></i>
                            <h3 class="m-b-10">Phone Book</h3>
                            <p class="text-uppercase m-b-5 font-13 font-600">Daftar Telepon Perusahaan</p>
                        </div>
                    </a>
                </div>
            @endif			
        @endif
        @role('Admin')
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('users.index') }}">
                <div class="card-box widget-flat border-custom bg-primary text-white">
                    <i class="fa fa-users"></i>
                    <h3 class="m-b-10">Manage Account</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Konfigurasi akun pengguna</p>
                </div>
            </a>
        </div>
        @endrole
		@role('Admin')
        <div class="col-sm-6 col-xl-3">
            <a href="{{ route('sap_users.index') }}">
                <div class="card-box widget-flat border-custom bg-purple text-white">
                    <i class="fa fa-users"></i>
                    <h3 class="m-b-10">Manage SAP User</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">Konfigurasi akun SAP</p>
                </div>
            </a>
        </div>        
        @endrole
		
		@role('Admin|Admin Delivery|Security Senior Staff|Security Staff|User Staff|User Supervisor')
			@if(Auth::user()->nik == '078'||Auth::user()->nik == '098'||Auth::user()->nik == '083' || 
				Auth::user()->nik == '009'|| Auth::user()->nik == '074' || Auth::user()->nik == '010' || 
				Auth::user()->nik == '022' || Auth::user()->nik == '000' || Auth::user()->nik == '271' ||
				Auth::user()->nik == '218' || Auth::user()->nik == '248' || Auth::user()->nik == '049' ||
                Auth::user()->nik == '247' || Auth::user()->nik == '236' || Auth::user()->nik == '123' || 
                Auth::user()->nik == '158' || Auth::user()->nik == '276')
				<div class="col-sm-6 col-xl-3">
					<a href="{{ route('DN.index') }}">
						<div class="card-box widget-flat border-custom text-white" style="background-color:#87E6FF;">
							<i class="fa fa-truck"></i>
							<h3 class="m-b-10">Surat Jalan</h3>
							<p class="text-uppercase m-b-5 font-13 font-600">Dokumentasi Pengiriman</p>
						</div>
					</a>
				</div>
			@endif
		@endrole
		
		@role('Admin|Admin Hris|Security Senior Staff|Security Staff|User Staff|User Supervisor|User Manager')
			<div class="col-sm-6 col-xl-3">
				<a href="{{ route('hris.dashboard') }}">
					<div class="card-box widget-flat border-custom text-white" style="background-color:#E05519;">
						<i class="fa fa-file-archive-o"></i>
						<h3 class="m-b-10">HR-IS</h3>
						<p class="text-uppercase m-b-5 font-13 font-600">Human Resources Information</p>
					</div>
				</a>
			</div>
        @endrole
    </div>
</div>
@stop
