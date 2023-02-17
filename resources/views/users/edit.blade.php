@extends('layouts.topbar.app')

@section('title','Edit User')

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
                    <h4>Edit Account</h4>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('users.show',$user->id) }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-eye"></i> </a>
                </div>
            </div>
        </div>
        <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Fullname
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="name" value="{{ $user->name }}" placeholder="Input fullname">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Email
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="email" value="{{ $user->email }}" placeholder="Input email">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Positions
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-suitcase"></i>
                                </span>
                            </div>
                            <select class="form-control select2" style="width: 60%;" name="position_id" data-placeholder="Select positions"
                                required>
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($positions as $r)
                                <option value="{{ $r->id }}"  {{ $user->position_id == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Role
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-film"></i>
                                </span>
                            </div>
                            <select class="form-control select2" name="roles" style="width: 40%;" data-placeholder="Select role"
                                required>
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($roles as $r)
                                <option value="{{ $r->id }}"  {{ $user->roles->contains($r->id) ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Account Status
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user-o"></i>
                                </span>
                            </div>
                            <select class="form-control select2" name="is_active" style="width: 40%;" data-placeholder="Select role"
                                required>
                                <option value="1"  {{ $user->is_active == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0"  {{ $user->is_active == '0' ? 'selected' : '' }}>Deactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- END Page Content -->

@stop
