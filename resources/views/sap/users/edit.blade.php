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
                        <li class="breadcrumb-item"><a href="{{ route('sap_users.index') }}">SAP Users</a></li>
                        <li class="breadcrumb-item active">Edit SAP User Account</li>
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
                    <span class="text-md-center"><h4>Edit SAP User Account</h4></span>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('sap_users.show',$SapUser->id) }}" class="btn btn-sm btn-icon waves-effect waves-light btn-primary float-right"> 
                        <i class="fa fa-eye"></i> 
                    </a>
                </div>                
            </div>                   
        </div>
        <div class="card-body">
            <form action="{{ route('sap_users.update', $SapUser->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
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
                                name="username" value="{{ $SapUser->username }}" placeholder="Input Username" 
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
                            <select name="sap_type" class="form-control select2">
                                <option value="Professional" {{($SapUser->type == 'Professional')? 'selected':'' }}>Profesional</option>
                                <option value="Functional" {{($SapUser->type == 'Functional')? 'selected':'' }}>Functional</option>
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
                                <option value="{{$r->id}}"
                                    {{ ($has_bpo == $r->sap_user_id) ?'selected':''}}>
                                    {{$r->username}}
                                </option>
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
                        <a type="button" class="btn btn-danger" href="{{route('sap_users.index')}}">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection