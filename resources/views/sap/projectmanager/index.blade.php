@extends('layouts.topbar.app')

@section('title','Manage User SAP')

@section('brand','Manage User')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header"> 
            <div class="row m-b-10">
                <div class="col-sm-12">
                    <a href="{{ route('sap_users.index') }}" class="btn btn-outline-primary waves-light waves-effect">User</a>
                    <a href="{{ route('sap_bpo.index') }}" class="btn btn-outline-primary waves-light waves-effect">BPO</a>
                    <a href="{{ route('sap_fico.index') }}" class="btn btn-outline-primary waves-light waves-effect">FICO Head</a>
                    <a href="{{ route('sap_it.index') }}" class="btn btn-outline-primary waves-light waves-effect">IT</a>
                    <a href="{{ route('sap_pro_manag.index')}}" class="btn btn-primary waves-light waves-effect">Project Manager</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <form class="form-inline" action="{{ url()->current() }}" >
                        <div class="input-group input-group-sm mr-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-wpforms"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="keyword" value="@if (!empty($keyword)) {{ $keyword }} @endif"
                                placeholder="Search..." autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mb-2 mr-sm-2 mb-sm-0">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{ route('sap_users.index') }}" class="btn btn-sm btn-danger">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </form>
                </div>
                <!-- <div class="col-sm-6">
                    <a href="" class="btn btn-sm btn-icon waves-effect waves-light btn-primary float-right"> 
                        <i class="fa fa-plus"></i> 
                    </a>
                </div> -->
            </div>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>Fullname</th>                        
                        <th>action</th>
                    </thead>
                    <tbody>
                        @foreach($users_sap as $user)
                        <tr>
                            <td>{{$user->name}}</td>                            
                            <td>                                
                                <a href="{{route('sap_pro_manag.edit', $user->id)}}" 
                                    class="btn btn-sm btn-warning" title="Edit Data">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-primary" 
                                    href="{{route('sap_pro_manag.show', $user->id)}}" title="Show Data">
                                    <i class="fa fa-eye"></i>
                                </a>                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@stop