@extends('layouts.sidebar.hris.app')

@section('title','HRIS - Import Uang Makan')

@section('brand','HRIS - Import Uang Makan')
@section('script')
<script>
    $('#btnAddNotes').on('click',function(){
        var xhtml = "";
        var duplicate = $(".inpNote").find(".input-group").clone();
        xhtml += "<div class='row form-group'>";
        xhtml += "<label class='col-md-3 col-sm-12 col-xs-12'></label>";
        xhtml += "<div class='col-md-6 col-sm-12 col-xs-12'>";
        xhtml += "<div class='input-group'>";
        xhtml += duplicate.html();
        xhtml += "</div>";
        xhtml += "</div>";
        xhtml += "</div>";
        $("#insert").append(xhtml);
    });
</script>
@stop

@section('breadcrumb')
    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left">
                <i class="dripicons-menu"></i>
            </button>
        </li>
        <li>
            <div class="page-title-box">
                <h4 class="page-title">Import Data </h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Menu Utama</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('MealAllowance.index') }}">Tunjangan Uang Makan</a></li>
                    <li class="breadcrumb-item active">Import Data Uang Makan</li>
                </ol>
            </div>
        </li>
    </ul>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="form-inline row">
                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                        <h5>Import Data Uang Makan</h5>
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-xs-12 justify-content-end">
                        <a href="{{route('MealAllowance.download')}}" class="btn btn-success">
                            <i class="fa fa-download"></i>
                            <span>Template</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('MealAllowance.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row form-group">
                        <label for="periode" class="col-md-3 col-sm-12 col-xs-12">
                            Periode
                        </label>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-o"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control col-md-6" name="date_periode_start" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-o"></i>
                                    </span>
                                </div>
                                <input type="date" class="form-control col-md-6" name="date_periode_end" required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="file-upload" class="col-md-3 col-sm-12 col-xs-12">
                            File <br>
                            <p>
                                <i style="color:red;">*</i>
                                <small><i>xls only</i></small>
                            </p>
                        </label>
                        <div class="col-md-6 col-sm-12 col-xs-12">    
                            <input type="file" name="import_file" class="filestyle" data-btnClass="btn-light" required>
                        </div>
                    </div>
                    <div class="row form-group inpNote">
                        <label for="" class="col-md-3 col-sm-12 col-xs-12">Note</label>
                        <div class="col-md-6 col-sm-10 col-xs-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" title="Note For All">
                                        <i class="fa fa-info" style="width:20px;"></i>
                                    </span>
                                </div>
                                <input type="text" name="note[]" id="note" class="form-control"></input>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                            <button type="button" class="btn btn-primary" id="btnAddNotes"> 
                                <span class="fa fa-plus"></span>
                            </button>
                        </div>
                    </div>
                    <div id="insert"></div>
                    <div class="row form-group">
                        <label for="" class="col-md-3 col-sm-10 col-xs-10">Quotes</label>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" title="Note For All">
                                        <i class="fa fa-quote-left" style="width:20px;"></i>
                                    </span>
                                </div>
                                <textarea name="quotes" id="quotes" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group ">
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-primary col-2">
                                <i class="fa fa-save"></i>
                                <span>Save</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop