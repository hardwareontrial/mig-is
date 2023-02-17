@extends('layouts.topbar.app')

@section('title','Create Users SAP')

@section('brand','Manage Users SAP')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sap_users.index') }}">Users SAP</a></li>
                        <li class="breadcrumb-item active">Create Users SAP</li>
                    </ol>
                </div>
                <h4 class="page-title">&nbsp;</h4>
            </div>
        </div>
    </div>

    <div class="card m-b-20">
        <div class="card-header">
            <div class="form-inline">
                <div class="col-md-1">
                    <button onclick="window.history.back();" class="btn btn-outline-danger">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-10 col-xs-10">
                    <h4 class="text-center">Create Users SAP</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('sap_users.store') }}" method="POST">
            @csrf
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Username SAP
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card" style="width:20px;"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="username" value="{{ old('username') }}" placeholder="Input Username" 
                                required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-3 col-form-label">
                        Type Users SAP
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-search" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="sap_type" id="" class="form-control select2">
                                <option value="Professional">Profesional</option>
                                <option value="Functional">Functional</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-xs-2 col-sm-2 col-md-3">BPO of Users SAP</label>
                    <div class="col-xs-10 col-sm-10 col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user" style="width:20px;"></i>
                                </span>
                            </div>                        
                            <select name="bpo_id" id="" class="form-control select2" data-placeholder="Select BPO Of Users SAP">
                                @foreach($bpo as $r)
                                <option value="{{$r->id}}">{{$r->username}}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                             Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- END Page Content -->

@stop
