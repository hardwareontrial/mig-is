@extends('layouts.topbar.app')

@section('title','Manage User SAP')

@section('brand','Manage User SAP')

@section('content')
<div class="container-fluid">
    
    <div class="card">
        <div class="card-header">
            <div class="row m-b-10">
                <div class="col-sm-12">
                    <a href="{{ route('sap_users.index') }}" class="btn btn-primary waves-light waves-effect">User</a>
                    <a href="{{ route('sap_bpo.index') }}" class="btn btn-outline-primary waves-light waves-effect">BPO</a>
                    <a href="{{ route('sap_fico.index') }}" class="btn btn-outline-primary waves-light waves-effect">FICO Head</a>
                    <a href="{{ route('sap_it.index') }}" class="btn btn-outline-primary waves-light waves-effect">IT</a>
                    <a href="{{ route('sap_pro_manag.index')}}" class="btn btn-outline-primary waves-light waves-effect">Project Manager</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <form class="form-inline" action="{{ url()->current() }}" >
                        <div class="input-group input-group-sm mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-wpforms"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="keyword" value="@if (!empty($keyword)) {{ $keyword }} @endif"
                                placeholder="Search..." autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary mb-2 mr-sm-2 mb-sm-0" title="search">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{ route('sap_users.index') }}" class="btn btn-sm btn-danger" title="clear">
                            <i class="fa fa-eraser"></i>
                        </a>
                    </form>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('sap_users.create') }}" title="create new"
                        class="btn btn-sm btn-icon waves-effect waves-light btn-primary float-right"> 
                        <i class="fa fa-plus"></i> 
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th >Username</th>
                        <th class="text-center" >Type</th>
                        <th class="text-center" >BPO</th>
                        <th class="text-center" style="width: 15%;">Status</th>
                        <th class="text-center" style="width: 15;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $r)
                    <tr>
                        <td>{{ $r->username }}</td>
                        <td align="center">{{ $r->type }}</td>
                        <td align="center">
                            @foreach($bpo as $b)
                                @if($r->sap_user_bpo_id == $b->sap_user_id)
                                    {{$b->username}}
                                @endif
                            @endforeach
                        </td>
                        <td align="center">
							@if ($r->is_active == 1) 
								<label for="" class="badge badge-pill badge-success">Active</label>
							@else
								<label for="" class="badge badge-pill badge-danger">Deactive</label>
							@endif
						</td>
                        <td align="center">
                            <form action="{{route('sap_users.delete', $r->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <a href="{{ route('sap_users.show',$r->id) }}" 
                                    class="btn btn-sm btn-icon btn-primary btn-circle">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('sap_users.edit',$r->id) }}" 
                                    class="btn btn-sm btn-icon btn-warning btn-circle" title="Edit">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>                                                        
                                <button type="submit" class="btn btn-sm btn-icon btn-danger btn-circle" title="delete">                                    
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>                            
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Data is empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

</div>
<!-- END Page Content -->

@stop

@section('modal')

<div class="modal fade modal-fade-in-scale-up modal-primary" id="exampleNiftyFadeScale" aria-hidden="true"
    aria-labelledby="exampleModalTitle" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="fa fa-address-card" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" name="nik" placeholder="NIK" autocomplete="off"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-user" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" name="name" placeholder="Fullname"
                                autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-lock" aria-hidden="true"></span>
                            </span>
                            <select class="form-control" data-plugin="select2" name="positions" required>
                                @foreach ($positions as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-lock" aria-hidden="true"></span>
                            </span>
                            <select class="form-control" data-plugin="select2" name="roles" required>
                                @foreach ($roles as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-envelope" aria-hidden="true"></span>
                            </span>
                            <input type="text" class="form-control" name="email" placeholder="Email Address"
                                autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-lock" aria-hidden="true"></span>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group" hidden>
                        <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon wb-lock" aria-hidden="true"></span>
                            </span>
                            <input type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-popout" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary">
                    <h3 class="block-title">Add New User</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form action="{{ route('users.store') }}" method="post" onsubmit="return false;">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="example-input1-group1"
                                        name="example-input1-group1" placeholder="NIK" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="example-input1-group1"
                                        name="example-input1-group1" placeholder="Username" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="example-input1-group1"
                                        name="example-input1-group1" placeholder="Email Address" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-suitcase"></i>
                                        </span>
                                    </div>
                                    <select class="js-select2 form-control" style="width: 90%;"
                                        data-placeholder="Select positions" required>
                                        <option></option>
                                        <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($positions as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="si si-film"></i>
                                        </span>
                                    </div>
                                    <select class="js-select2 form-control" style="width: 90%;"
                                        data-placeholder="Select role" required>
                                        <option></option>
                                        <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($roles as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Perfect
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
