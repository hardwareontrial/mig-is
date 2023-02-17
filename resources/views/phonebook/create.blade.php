@extends('layouts.topbar.app')
@section('title', 'Phone Book')
@section('content')    
    <div class='container-fluid'>
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('phonebook.index')}}">Phone book</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create New Information</h4>
                </div>
            </div>
        </div>
        <div class='row justify-content-center'>
            <div class='col-md-10'>
                <div class="card">                    
                    <form method='POST' action="{{route('phonebook.store')}}">
                        @csrf
                        <div class="card-header">
                            <h5>Form Contact Information</h5>
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
                                                placeholder="Nama Perusahaan">
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
                                            <textarea class='form-control' placeholder='Alamat'
                                                name='perusahaanAddress'>
                                            </textarea>
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
                                                placeholder='Kota Perusahaan'>
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
                                                placeholder="Telp perusahaan">
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
                                                placeholder="Fax Perusahaan">
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
                                            <textarea class='form-control' name='perusahaanKet'></textarea>
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
                                                placeholder="Nama Personal">
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
                                            <textarea class='form-control' name='personAddress'></textarea>
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
                                                placeholder="Kota Personal">
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
                                                placeholder="Telp Personal">
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
                                                placeholder="Fax Personal">
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
                                                placeholder="Mobile Personal">
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
                                            <textarea class='form-control' name='personKet'></textarea>
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