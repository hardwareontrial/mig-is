@extends('layouts.topbar.app')

@section('title','Create User')

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
                    <h4>Create Account</h4>
                </div>
            </div>
        </div>
        <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        NIK
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-id-card"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="nik" value="{{ old('nik') }}" placeholder="Input NIK" required>
                        </div>
                    </div>
                </div>
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
                                name="name" value="{{ old('name') }}" placeholder="Input fullname" required>
							<input type="hidden" class="form-control" id="example-input1-group1"
                                name="password" value="mig123!" placeholder="Input fullname">
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
                                name="email" value="{{ old('email') }}" placeholder="Input email" required>
                        </div>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Department
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-bank"></i>
                                </span>
                            </div>
                            <select class="form-control select2" style="width: 60%;" name="division_id" data-placeholder="Select department" required>
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($divisions as $r)
                                <option value="{{ $r->id }}" @if (old('division_id') == $r->id) selected @endif >{{ $r->name }}</option>
                                @endforeach
                            </select>
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
                            <select class="form-control select2" style="width: 60%;" name="position_id" data-placeholder="Select positions" required>
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($positions as $r)
                                <option value="{{ $r->id }}" @if (old('position_id') == $r->id) selected @endif >{{ $r->name }}</option>
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
                            <select class="form-control select2" name="roles" style="width: 40%;" data-placeholder="Select role" required>
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($roles as $r)
                                <option value="{{ $r->id }}" @if (old('roles') == $r->id) selected @endif>{{ $r->name }}</option>
                                @endforeach
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
