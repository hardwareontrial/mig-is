@extends('layouts.topbar.app')

@section('title','Create BPO')

@section('brand','Manage Users SAP')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sap_bpo.index') }}">Users BPO</a></li>
                        <li class="breadcrumb-item active">Create Users BPO</li>
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
                    <h4 class="text-center">Create Users BPO SAP</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('sap_bpo.store') }}" method="POST">
            @csrf
                <div class="form-group row">
                    <label for="" class="col-lg-3 col-form-label"> 
                        Username MIG-IS
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="user_id" id="" class="form-control select2">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Username SAP
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="sap_user_id" id="" class="form-control select2">
                                @foreach($sap_users as $sap_user)
                                <option value="{{$sap_user->id}}">{{$sap_user->username}}</option>
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
