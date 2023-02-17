@extends('layouts.sidebar.edoc.app')

@section('title','Import Form')

@section('brand','Edoc')

@section('breadcrumb')

<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left">
            <i class="dripicons-menu"></i>
        </button>
    </li>
    <li>
        <div class="page-title-box">
            <h4 class="page-title">Import Form </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_edoc.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('form.index') }}">Master Form</a></li>
                <li class="breadcrumb-item active">Import Form</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <div class="alert bg-primary alert-dismissible text-white">
                    <h4><i class="icon fa fa-info"></i> Format import Form Document</h4>
                    [Divisi][F][Nomor Dokumen][-][Nomor Form][-][R][Revisi Ke][Spasi][Nama Form]<br><br>
                    Contoh:<br>
                    CPLF002-1-R3 LAPORAN PENGECEKAN PERANGKAT
                </div>
            </div>
        </div>
    </div>
    <div class="card-body"> 
        <form action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group row">
                <label class="col-lg-2 col-form-label" for="example-hf-email">
                    Upload File
                </label>
                <div class="col-lg-5">
                    <div class="custom-file">
                        <input type="file" name="file_form" class="filestyle" data-btnClass="btn-light">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-10 ml-auto">
                    <button type="submit" class="btn btn-alt-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
<!-- END Page Content -->
@stop

@section('script')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $("#md_del").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');
            $("#data_materi").html("["+id+"] "+desc);
            $('#data-form').attr('action', "{{ url('/') }}/okm/question/"+id);
        })
    </script>
@stop
