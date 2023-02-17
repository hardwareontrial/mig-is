@extends('layouts.sidebar.elearning.app')

@section('title','Ubah Informasi Soal')

@section('brand','Manage User')

@section('breadcrumb')

<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left">
            <i class="dripicons-menu"></i>
        </button>
    </li>
    <li>
        <div class="page-title-box">
            <h4 class="page-title">Ubah Infromasi Soal </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('question.index') }}">Master Soal</a></li>
                <li class="breadcrumb-item active">Ubah Infromasi Soal</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        Form Soal
    </div>
        <div class="card-body">
            <form action="{{ route('question.update',$question->id) }}" method="POST">
            @method('PUT')
            @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Judul
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-o"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="title" value="{{ $question->title }}" placeholder="Masukkan judul soal" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Materi
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-book"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="material_id" style="width: 90%;" data-placeholder="Pilih materi"
                                required>
                                <option></option>
                                @foreach ($materials as $r)
                                <option value="{{ $r->id }}" {{ $question->material_id == $r->id ? 'selected' : '' }}>{{ $r->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Nilai Minimum
                    </label>
                    <div class="col-lg-4">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-arrow-circle-o-down"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" id="example-input1-group1"
                                name="minimum_score" value="{{ $question->minimum_score }}" placeholder="Masukkan nilai minimum" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Durasi
                    </label>
                    <div class="col-lg-4">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" id="example-input1-group1"
                                name="duration" value="{{ $question->duration }}" placeholder="Masukkan bobot jam" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Menit
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
    if($("#elm1").length > 0){
        tinymce.init({
            selector: "textarea#elm1",
            theme: "modern",
            height:300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    }
</script>
@stop
