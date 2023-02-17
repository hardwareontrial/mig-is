@extends('layouts.topbar.app')

@section('title','Manage User SAP')

@section('brand','Manage User SAP')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sap_bpo.index') }}">Manage Users BPO</a></li>
                        <li class="breadcrumb-item active">Detail User BPO</li>
                    </ol>
                </div>
                <h4 class="page-title">&nbsp;</h4>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">        
            <div class="form-inline">                
                <div class="col-xs-1 col-sm-1 col-md-4 col-lg-4">
                    <button onclick="window.history.back();" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </div>
                <div class="col-sm-4">
                    <span class="text-md-center"><h4>Detail User BPO SAP</h4></span>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('sap_bpo.edit', $bpo->id) }}" class="btn btn-sm btn-icon waves-effect waves-light btn-outline-warning float-right"> 
                        <i class="fa fa-edit"></i> 
                        Edit Data
                    </a>
                </div>                
            </div>                   
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email">
                    <i class="fa fa-user"></i>
                    &nbsp;SAP Username
                </label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: {{ $bpo->user_sap['username'] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email">
                    <i class="fa fa-address-card"></i>
                    &nbsp;SAP BPO User
                </label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: {{ $bpo->user['name'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection