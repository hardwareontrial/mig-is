@extends('layouts.sidebar.elearning.app')

@section('title','Ubah Materi')

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
            <h4 class="page-title">Ubah Materi </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Master Materi</a></li>
                <li class="breadcrumb-item active">Ubah Materi</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        Form Ubah Materi
    </div>
    <div class="card-body">
            <form action="{{ route('material.update',$material->id) }}" method="POST">
            @method('PUT')
            @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Judul Materi
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="title" value="@if (!empty($material->title)){{$material->title}} @endif" placeholder="Masukkan judul materi" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Departemen
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-building"></i>
                                </span>
                            </div>
                            <select class="form-control select2" name="division_id" style="width: 60%;" data-placeholder="Pilih Departemen"
                                required>
                                <option></option>
                                @foreach ($divisions as $r)
                                <option value="{{ $r->id }}" {{ !empty($selected_division) && $selected_division == $r->id ? 'selected':'' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Tingkat Kesulitan
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-suitcase"></i>
                                </span>
                            </div>
                            <select class="form-control select2" style="width: 40%;" name="level" data-placeholder="Pilih tingkat kesulitan"
                                required>
                                <option></option>
                                <option value="Beginner" {{ !empty($material->level) && $material->level == 'Beginner' ? 'selected':'' }} >Beginner</option>
                                <option value="Intermediate" {{ !empty($material->level) && $material->level == 'Intermediate' ? 'selected':'' }}>Intermediate</option>
                                <option value="Advanced" {{ !empty($material->level) && $material->level == 'Advanced' ? 'selected':'' }}>Advanced</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Bobot Materi
                    </label>
                    <div class="col-lg-4">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" id="example-input1-group1"
                                name="hours" value="{{ $material->hours }}" placeholder="Bobot materi" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Jam
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Sinopsis
                    </label>
                    <div class="col-lg-9">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <textarea id="elm1" name="sinopsis">{!! $material->sinopsis !!}</textarea>
                        </div>
                    </div>
                </div>
				@if(Auth::user()->hasAnyPermission([1,24,38]))
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-alt-primary">Simpan</button>
                    </div>
                </div>
				@endif
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
