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
                <h4 class="page-title">Dashboard </h4>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                
                </div>
            </div>
        </div>
    </div>
</div>

@stop