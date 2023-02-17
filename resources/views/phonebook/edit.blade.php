@extends('layouts.topbar.app')
@section('title', 'Phone Book')
@section('content') 
@php
    if($data){
        $id = $data['id'];
        $perusahaanName = $data['nama_perusahaan'];
        $perusahaanAddress = $data['alamat_perusahaan'];
        $perusahaanCity = $data['kota_perusahaan'];
        $perusahaanPhone = $data['telp_perusahaan'];
        $perusahaanFax = $data['fax_perusahaan'];
        $perusahaanKet = $data['ket_perusahaan'];
        $personName = $data['nama_person'];
        $personAlamat = $data['alamat_person'];
        $personCity = $data['kota_person'];
        $personPhone = $data['telp_person'];
        $personFax = $data['fax_person'];
        $personMobile = $data['hp_person'];
        $personKet = $data['ket_person'];        
    }
@endphp
    <div class='container-fluid'>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('phonebook.index')}}">Phone book</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Contact Information</h4>
                </div>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-10'>
                <div class="card">                    
                    <form method='POST' action="{{route('phonebook.update', $id)}}">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h5>Edit Contact Information</h5>
                        </div>
                        <div class="card-body">                                                                     
                            <ul class="nav nav-tabs tabs-bordered nav-justified">
                                <li class="nav-item">
                                    <a href="#perusahaan" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <i class="fa fa fa-tag mr-2"></i> Perusahaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#person" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="fa fa-user mr-2"></i >Person
                                    </a>
                                </li>
                            </ul>                                       
                            <div class="tab-content">                                
                                <div id='perusahaan' class='tab-pane active'>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Nama Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-id-card-o" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='perusahaanName' 
                                                value="{{$perusahaanName}}" required>
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Alamat Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-building-o" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <textarea class='form-control' name='perusahaanAddress'>{{$perusahaanAddress}}</textarea>
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Kota Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-marker" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='perusahaanCity'
                                                value="{{$perusahaanCity}}">
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Telp Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-phone" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='perusahaanTelp'
                                                value="{{$perusahaanPhone}}">
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Fax Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-fax" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='perusahaanFax' 
                                            value="{{$perusahaanFax}}">
                                        </div>
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Keterangan Perusahaan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-exclamation" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <textarea class='form-control' name='perusahaanKet'>{{$perusahaanKet}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id='person' class='tab-pane'>
                                    <div class=" form-group row">
                                        <label class="col-md-3 col-form-label text-right">Nama </label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-male" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='personName' 
                                                value="{{$personName}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Alamat</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-building-o" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <textarea class='form-control' name='personAddress'>{{$personAlamat}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Kota</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-marker" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='personCity'
                                            value="{{$personCity}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Telp</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-phone" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='personPhone'
                                                value="{{$personPhone}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Fax</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-fax" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='personFax'
                                                value="{{$personFax}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Handphone</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-mobile-phone" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <input class='form-control' name='personHp'
                                                value="{{$personMobile}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label text-right">Keterangan</label>
                                        <div class='input-group col-md-6 mb-2'>
                                            <div class='input-group-prepend'>
                                                <span class="input-group-text">
                                                    <i class="fa fa-exclamation" style='width:20px;'></i>
                                                </span>
                                            </div>
                                            <textarea class='form-control' name='personKet'>{{$personKet}}</textarea>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-primary mb-2 mr-2">
                                    <i class="fa fa-save"></i>
                                    <span>Save</span>                                                                        
                                </button>                                            
                                <button class='btn btn-outline-danger mb-2 mr-2' onclick="window.history.back()">
                                    <i class="fa fa-level-up"></i>
                                    <span>Cancel</span>                                                                                   
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection