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
                        <li class="breadcrumb-item"><a href="{{ route('sap_users.index') }}">SAP IT Users</a></li>
                        <li class="breadcrumb-item active">Edit SAP IT User </li>
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
                    <span class="text-md-center"><h4>Edit SAP IT User</h4></span>
                </div>
                <!-- <div class="col-sm-4">
                    <a href="{{ route('sap_users.show',$users_it->id) }}" class="btn btn-sm btn-icon waves-effect waves-light btn-primary float-right"> 
                        <i class="fa fa-eye"></i> 
                    </a>
                </div>                 -->
            </div>                   
        </div>
        <div class="card-body">
            <form action="{{ route('sap_it.update', $users_it->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">
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
                                @foreach($users_web as $user_web)
                                <option value="{{$user_web->id}}" 
                                    {{($users_it->user_id == $user_web->id)?'selected':''}}>
                                    {{$user_web->name}}
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
                                <option value="Basis" 
                                    {{($users_it->type == 'Basis')?'selected':''}}>
                                    Basis
                                </option>
                                {{$users_it->user_type}}
                                <option value="Master Data"
                                    {{($users_it->type == 'Master Data')?'selected':''}}>
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
@endsection