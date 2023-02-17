@extends('layouts.sidebar.elearning.app')

@section('title','Buat Jadwal Ujian Baru')

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
            <h4 class="page-title">Buat Jadwal Ujian Baru </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('schedule.index') }}">Jadwal Ujian</a></li>
                <li class="breadcrumb-item active">Buat Jadwal Ujian Baru</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        Form Jadwal Ujian Baru
    </div>
        <div class="card-body">
        <form action="{{ route('schedule.store') }}" method="POST">
            @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Soal
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-book"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="collection_id" style="width: 90%;" autocomplete="off" data-placeholder="Pilih soal ujian"
                                required>
                                <option></option>
                                @foreach ($collections as $r)
                                <option value="{{ $r->id }}">{{ $r->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
				<div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Keterangan
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-o"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="description" value="" placeholder="Keterangan tambahan" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Tanggal & Waktu Mulai
                    </label>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="text" name="date_start" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_start" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <input id="timepicker_start" name="time_start" type="text" autocomplete="off" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Tanggal & Waktu Selesai
                    </label>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="text" name="date_end" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_end" required>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                            </div>
                            <input id="timepicker_end" name="time_end" type="text" autocomplete="off" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Peserta
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-users"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="exam_participants[]" style="width: 90%;" multiple="multiple" multiple autocomplete="off" data-placeholder="Pilih peserta ujian"
                                required>
                                <option></option>
                                <option value="all">Semua</option>
								<option value="manager">Semua Manager</option>
                                <option value="spv">Semua Supervisor</option>
                                <option value="staff">Semua Staff</option>
                                <optgroup label="Berdasarkan Departement">
                                @foreach ($divisions as $r)
                                <option value="d-{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                                <optgroup label="Berdasarkan Posisi">
                                @foreach ($positions as $r)
                                <option value="p-{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                                <optgroup label="Berdasarkan Nama">
                                @foreach ($users as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
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
