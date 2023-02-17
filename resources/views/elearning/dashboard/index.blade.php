@extends('layouts.sidebar.elearning.app')

@section('title','Beranda OKM')

@section('brand','Liquid CO2 Manufacture')

@section('breadcrumb')

<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left">
            <i class="dripicons-menu"></i>
        </button>
    </li>
    <li>
        <div class="page-title-box">
            <h4 class="page-title">Beranda </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Menu Utama</a></li>
                <li class="breadcrumb-item active">Beranda</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')

<div class="container-fluid">

	<div class="row text-center" hidden>
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('helpdesk.index') }}">
                <div class="card-box widget-flat border-success bg-success text-white">
                    <i class="fi-play"></i>
                    <h3 class="m-b-10">7 </h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">
						Ujian Sedang Berlangsung<br>
						<span class="badge badge-warning"> 5 Belum Diselesaikan</span>&nbsp;<span class="badge badge-danger"> 5 Belum Dikerjakan</span>
					</p>
                </div>
            </a>
        </div>
		<div class="col-sm-6 col-xl-4">
            <a href="{{ route('helpdesk.index') }}">
                <div class="card-box widget-flat border-primary bg-primary text-white">
                    <i class="fi-clock"></i>
                    <h3 class="m-b-10">3</h3>
                    <p class="text-uppercase m-b-5 font-13 font-600"><br>Jadwal Ujian Akan Datang</p>
                </div>
            </a>
        </div>
		<div class="col-sm-6 col-xl-4">
            <a href="{{ route('helpdesk.index') }}">
                <div class="card-box widget-flat border-secondary bg-secondary text-white">
                    <i class="fi-check"></i>
                    <h3 class="m-b-10">1 </h3>
                    <p class="text-uppercase m-b-5 font-13 font-600">
						Jadwal Ujian Selesai<br>
						<span class="badge badge-warning"> 5 Belum Diselesaikan</span>&nbsp;<span class="badge badge-danger"> 5 Belum Dikerjakan</span>
					</p>
                </div>
            </a>
        </div>
	</div>
	
	<div class="row text-center" hidden>
		<div class="col-lg-6">
			<div class="card-box">
				<h4 class="header-title">Pie Chart</h4>

				<div id="pie-chart">
					<div id="pie-chart-container" class="flot-chart mt-5" style="height: 350px;">
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

@stop
