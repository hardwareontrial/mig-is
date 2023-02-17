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
                        <li class="breadcrumb-item"><a href="{{ route('sap_it.index') }}">Users SAP IT index</a></li>
                        <li class="breadcrumb-item active">Create Users IT SAP</li>
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
                    <span class="text-md-center"><h4>Create SAP IT User</h4></span>
                </div>
            </div>                   
        </div>
        <div class="card-body">
            <form action="{{ route('sap_it.store') }}" method="POST">
                @csrf                
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        User
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="users" id="" class="form-control select2">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">
                                    {{$user->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Type
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-asterisk" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="type_users" id="" class="form-control select2">
                                <option value="Basis">
                                    Basis
                                </option>                                
                                <option value="Master Data">
                                    Master Data
                                </option>
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
                        <a type="button" class="btn btn-danger" href="{{route('sap_it.index')}}">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>    
<!-- END Page Content -->

@stop
