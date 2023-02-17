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
                        <li class="breadcrumb-item"><a href="{{ route('sap_bpo.index') }}">User BPO</a></li>
                        <li class="breadcrumb-item active">Edit BPO User SAP</li>
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
                    <span class="text-md-center"><h4>Edit BPO SAP User</h4></span>
                </div>
                <div class="col-sm-4">
                    <a href="{{ route('sap_bpo.show',$bpo->id) }}" class="btn btn-sm btn-icon waves-effect waves-light btn-primary float-right"> 
                        <i class="fa fa-eye"></i> 
                    </a>
                </div>                
            </div>                   
        </div>
        <div class="card-body">
            <form action="{{ route('sap_bpo.update', $bpo->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
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
                                <option value="{{$user->id}}" {{($user->id == $bpo->user_id)?'selected':''}}>
                                    {{$user->name}}
                                </option>                                                                                                        
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
                                <option value="{{$sap_user->id}}" {{ ($sap_user->id == $bpo->sap_user_id)? 'selected':''}}>
                                    {{$sap_user->username}}
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
                        <a type="button" class="btn btn-danger" href="{{route('sap_bpo.index')}}">
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