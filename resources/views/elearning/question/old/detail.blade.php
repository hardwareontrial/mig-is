@extends('layouts.sidebar.elearning.app')

@section('title','Detail Master Soal')

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
            <h4 class="page-title">{{ $collection->title }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('question.index') }}">Master Soal</a></li>
                <li class="breadcrumb-item active">{{ $collection->title }}</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

    <div class="card m-b-30">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Info</h5>
                </div>
                <div class="col-sm-6">
					@if(Auth::user()->hasAnyPermission([1,24,39]))
                    <a href="{{ route('question.edit',$collection->id) }}" class="btn btn-icon waves-effect waves-light btn-warning  float-right"><i class="fa fa-edit"></i></a>
					@endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Materi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-file-o"></i>&nbsp;&nbsp;{{ $collection->material->title }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Departemen</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-building"></i>&nbsp;&nbsp;{{ $collection->material->division->name }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Tingkatan</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;{{ $collection->material->level }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Jumlah Soal</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-th-list"></i>&nbsp;&nbsp;{{ $collection->questions_count }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Nilai Minimum</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-arrow-circle-o-down"></i>&nbsp;&nbsp;{{ $collection->minimum_score }}</p>
                </div>
                <div class="col-md-4">
                    <p class="small hint-text m-0"><b>Durasi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $collection->duration }} Menit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>Daftar Pertanyaan</h5>
                </div>
                <div class="col-sm-6">
				@if(Auth::user()->hasAnyPermission([1,24,32]))
                <button type="button" data-toggle="modal" data-target="#md_new_content" class="btn btn-icon waves-effect waves-light btn-primary  float-right"><i class="fa fa-plus"></i></button>
				@endif
				@if(Auth::user()->hasAnyPermission([1,24,32]))
				<button type="button" data-toggle="modal" data-target="#md_import" class="btn btn-icon waves-effect waves-light btn-success  float-right" style="margin-right:10px;"><i class="mdi mdi-import"></i></button>&nbsp;
				@endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-vcenter" hidden>
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 5%;">#</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Pertanyaan</th>
                        <th colspan="4" class="text-center">Jawaban</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 5%;">Aksi</th>
                    </tr>
                    <tr>
                        <td class="text-center" style="width: 15%;">1</td>
                        <td class="text-center" style="width: 15%;">2</td>
                        <td class="text-center" style="width: 15%;">3</td>
                        <td class="text-center" style="width: 15%;">4</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1; ?>
                    @forelse($contents as $r)
                    <tr>
                        <th class="table-primary text-center">{{ $n }}</th>
                        <td class="table-primary" >{{ $r->question }}</td>
                        @forelse($r->answers as $a)
                        <td class="text-center">@if ($a->answer_key == 1) 
							<i class="fa fa-check"></i>&nbsp;&nbsp;<b><i>{{ $a->answer }}</b></i> @else {{ $a->answer }} @endif
						</td>
                        @empty
                        <td colspan="4" class="text-center">Tidak ada data</td>
                        @endforelse
                        <td class="text-center">
                            <div class="btn-group">
								@if(Auth::user()->hasAnyPermission([1,24,39]))
                                <a href="{{ route('question.edit_content',$r->id) }}" class="btn btn-sm btn-warning" data-qid="{{ $r->id }}" data-question="{{ $r->question }}" <?php $no = 1 ?> @foreach($r->answers as $a) data-answer-id{{$no}}={{$a->id}} data-answer{{$no}}={{$a->answer}} data-answer-key{{$no}}={{$a->answer_key}} <?php $no++ ?>  @endforeach data-target="#md_edit_content" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
								@endif
                                <button type="button" data-toggle="modal" data-target="#md_del_content" data-qid="{{ $r->id }}" data-question="{{ $r->question }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php $n++; ?>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
			
			<table class="table table-bordered table-vcenter">
                <thead>
                    <tr>
                        <th style="vertical-align : middle;text-align:center; width: 5%;">#</th>
                        <th style="vertical-align : middle;text-align:center;">Pertanyaan</th>
                        <th colspan="2" class="text-center">Jawaban</th>
                        <th style="vertical-align : middle;text-align:center; width: 5%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $n = 1; ?>
                    @forelse($contents as $r)
                    <tr>
                        <th rowspan="5" class="text-center" style="vertical-align : middle;text-align:center;">{{ $n }}</th>
                        <td rowspan="5" class="" style="vertical-align:middle;width:30%;">{{ $r->question }}</td>
						<?php $p = 1; ?>
                        @forelse($r->answers as $a)
                        <tr class="text-center">
							<td style="vertical-align:middle;width:10%;" class="@if ($a->answer_key == 1)  table-success @endif">Pilihan {{ $p }}</td>
							<td style="vertical-align:middle;width:30%;" class="@if ($a->answer_key == 1)  table-success @endif">
								@if ($a->answer_key == 1) 
								<i class="fa fa-check"></i>&nbsp;&nbsp;<b><i>{{ $a->answer }}</b></i> @else {{ $a->answer }}
								@endif
							</td>
							@if ($p == 1)
							<td class="text-center" style="vertical-align : middle;text-align:center;" rowspan="5">
								<div class="btn-group">
									@if(Auth::user()->hasAnyPermission([1,24,39]))
									<a href="{{ route('question.edit_content',$r->id) }}" class="btn btn-sm btn-warning" data-qid="{{ $r->id }}" data-question="{{ $r->question }}" <?php $no = 1 ?> @foreach($r->answers as $a) data-answer-id{{$no}}={{$a->id}} data-answer{{$no}}={{$a->answer}} data-answer-key{{$no}}={{$a->answer_key}} <?php $no++ ?>  @endforeach data-target="#md_edit_content" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit">
										<i class="fa fa-pencil"></i>
									</a>
									@endif
									@if(Auth::user()->hasAnyPermission([1,24,36]))
									<button type="button" data-toggle="modal" data-target="#md_del_content" data-qid="{{ $r->id }}" data-question="{{ $r->question }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
										<i class="fa fa-times"></i>
									</button>
									@endif
								</div>
							</td>
							@endif
							<?php $p++; ?>
						</tr>
                        @empty
                        <td colspan="4" class="text-center">Tidak ada data</td>
                        @endforelse
                        
                    </tr>
                    <?php $n++; ?>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
			
        </div>
    </div>
</div>
<!-- END Page Content -->
@stop

@section('modal')
<div class="modal fade" id="md_new_content" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Pertanyaan Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('question.store_content') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Pertanyaan
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-o"></i>
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="example-input1-group1"
                                name="collection_id" value="{{ $collection->id }}" required>
                            <input type="text" class="form-control" id="question"
                                name="question" value="" placeholder="Masukkan pertanyaan" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 1
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>1</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="a" value="" placeholder="Masukkan Pilihan Jawaban 1" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 2
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>2</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="b" value="" placeholder="Masukkan Pilihan Jawaban 2" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 3
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>3</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="c" value="" placeholder="Masukkan Pilihan Jawaban 3" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 4
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>4</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="d" value="" placeholder="Masukkan Pilihan Jawaban 4" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Kunci Jawaban
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="answer_key" style="width: 60%;" data-placeholder="Pilih kunci jawaban"
                                required>
                                <option></option>
                                <option value="a">Jawaban 1</option>
                                <option value="b">Jawaban 2</option>
                                <option value="c">Jawaban 3</option>
                                <option value="d">Jawaban 4</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_del_content" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white">Hapus Pertanyaan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="content-del-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus pertanyaan berikut ini<span id="content_id"></span> ?
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Ya
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_import" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title text-white">Import Pertanyaan Dari Excel</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('question.import_content',$collection->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label">
                        File Excel
                    </label>
                    <div class="col-lg-7">
                        <input type="file" name="import_file" class="filestyle" data-btnClass="btn-light" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $("#md_del_content").on("show.bs.modal", function(e) {
            var id =  $(e.relatedTarget).data('qid');
            var question =  $(e.relatedTarget).data('question');

            $("#content_id").html("<i><br>["+id+"] "+question+"</i>");
            $('#content-del-form').attr('action', "{{ url('/') }}/okm/question/destroy_content/"+id);
        })
    </script>
@stop
