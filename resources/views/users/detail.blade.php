@extends('layouts.topbar.app')

@section('title','Detail User')

@section('brand','Manage User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Detail User Account</li>
                    </ol>
                </div>
                <h4 class="page-title">&nbsp;</h4>
            </div>
        </div>
    </div>

    <div class="card m-b-20">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Detail Account</h4>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-pencil"></i> </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-address-card"></i>
                    &nbsp;NIK</label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: {{ $user->nik }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-user"></i>
                    &nbsp;Fullname</label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: {{ $user->name }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-envelope"></i>
                    &nbsp;Email</label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: {{ $user->email }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-suitcase"></i>
                    &nbsp;Positions</label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">: @if (!empty($position)) {{ $position->name }} @else
                        <small>-</small> @endif</div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-film"></i>
                    &nbsp;Role</label>
                <div class="col-lg-7">
                    <div class="form-control-plaintext">:
                        @forelse ($user->getRoleNames() as $role)
                        <span class="badge badge-info"> {{ $role }}</span>
                        @empty
                        -
                        @endforelse
                    </div>
                </div>
            </div>
			<div class="form-group row">
                <label class="col-lg-3 col-form-label" for="example-hf-email"><i class="fa fa-user-o"></i>
                    &nbsp;Account Status</label>
                <div class="col-lg-7">:
					@if ($user->is_active == 1) 
						<label for="" class="badge badge-pill badge-success">Active</label>
					@else
						<label for="" class="badge badge-pill badge-danger">Deactive</label>
					@endif
                </div>
            </div>
			@if ($user->roles->contains(7) || $user->roles->contains(8))
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th >NIK</th>
                        <th class="text-center" >Name</th>
                        <th class="text-center">Position</th>
						@if ($user->roles->contains(8))
                        <th class="text-center">Action</th>
						@endif
                    </tr>
                </thead>
                <tbody>
					@forelse ($subordinate as $r)
                    <tr>
                        <td>{{ $r->nik }}</td>
                        <td class="text-center">{{ $r->name }}</td>
                        <td class="text-center">{{ $r->position['name'] }}</td>
						@if ($user->roles->contains(8))
                        <td class="text-center">-</td>
						@endif
                    </tr>
					@empty
					<tr>
						<td></td>
					</tr>
					@endforelse
                </tbody>
            </table>
			@endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Log Activity</h4>
                </div>
                <div class="col-sm-6">
                    <form class="form-inline float-right" action="{{ url()->current() }}" >
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-wpforms"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="keyword" value="@if (!empty($keyword)) {{ $keyword }} @endif"
                                placeholder="Search..." autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2 mb-sm-0"><i class="fa fa-search"></i></button>
                        <a href="{{ route('users.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th >IP Address</th>
                        <th class="text-center" >Date</th>
                        <th class="text-center">Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>192.168.100.223</td>
                        <td class="text-center">09-11-2019 12:20</td>
                        <td class="text-center">Create new helpdesk</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- END Page Content -->

@stop
