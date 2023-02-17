@extends('layouts.sidebar.hris.app')

@section('title','HRIS')

@section('brand','HRIS')

@section('breadcrumb')
    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left">
                <i class="dripicons-menu"></i>
            </button>
        </li>
        <li>
            <div class="page-title-box">
                <h4 class="page-title">HR Management </h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">MIG-IS</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </li>
    </ul>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
                <div class="card-header">
                    <h5>Welcome <i>{{ Auth::user()->name }}</i> </h5>
                </div>
            <div class="card-body">
                <div class="col-sm-3 col-xl-3">
                <a href="{{ route('MealAllowance.index') }}">
				    <div class="card-box widget-flat border-custom text-white" style="background-color:#008B84;">
						<i class="fa fa-money"></i>
						<h4 class="m-b-8">UANG MAKAN</h4>
						<p class="text-uppercase m-b-5 font-10 font-300">Uang Makan Karyawan</p>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
