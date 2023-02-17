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
                        <li class="breadcrumb-item">
                            <a href="{{ route('sap_pro_manag.index') }}">
                                SAP Project Manager
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Edit Project Manager</li>
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
                    <span class="text-md-center"><h4>Edit Project Manager</h4></span>
                </div>
            </div>                   
        </div>
        <div class="card-body">            
            <form action="{{ route('sap_pro_manag.update', $users_pro_manag->id) }}" method="POST">
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
                                @foreach($users as $user)
                                <option value="{{$user->id}}" 
                                    {{($users_pro_manag->user_id == $user->id)?'selected':''}}>
                                    {{$user->name}}
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
                        <a type="button" class="btn btn-danger" href="{{route('sap_pro_manag.index')}}">
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