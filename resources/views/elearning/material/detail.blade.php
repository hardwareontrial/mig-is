@extends('layouts.sidebar.elearning.app')

@section('title','Detail Materi')

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
            <h4 class="page-title">{{ $material->title }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('material.index') }}">Master Materi</a></li>
                <li class="breadcrumb-item active">{{ $material->title }}</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

    <div class="card m-b-30">
        <div class="card-header">
            Info
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="small hint-text m-0"><b>Departemen</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-building"></i>&nbsp;&nbsp;{{ $division }}</p>
                </div>
                <div class="col-md-3">
                    <p class="small hint-text m-0"><b>Level</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;{{ $material->level }}</p>
                </div>
                <div class="col-md-3">
                    <p class="small hint-text m-0"><b>Bobot Materi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{ $material->hours }} Jam</p>
                </div>
                <div class="col-md-3" hidden>
                    <p class="small hint-text m-0"><b>Dilihat</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-eye"></i>&nbsp;&nbsp;{{ $material->view_count }} x dilihat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-header">
            Sinopsis
        </div>
        <div class="card-body">
            {!! $material->sinopsis !!}
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6">
                    <h5>File Materi</h5>
                </div>
                <div class="col-sm-6">
                @if(Auth::user()->hasAnyPermission([1,24,31]))
					@if ($material->created_by == Auth::user()->id)
                <button type="button" data-toggle="modal" data-target="#md_new_file" class="btn btn-icon waves-effect waves-light btn-primary  float-right"><i class="fa fa-upload"></i>&nbsp;Upload</button>
					@endif
                @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-center" style="width: 15%;">Download</th>
                    <th class="text-center" style="width: 100px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($content as $r)
                    <tr>
                        <td>{{ $r->description }}</td>
                        <td class="text-center">
                            <i class="fa fa-download"></i> {{ $r->download_count }} x
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
								@if(Auth::user()->hasAnyPermission([1,24,29]))
                                <a href="{{ route('material.download',$r->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Download">
                                    <i class="fa fa-download"></i>
                                </a>
								@endif
                                @if(Auth::user()->hasAnyPermission([1,24,38]))
									@if ($material->created_by == Auth::user()->id)
                                <button type="button" data-toggle="modal" data-target="#md_edit_file" data-id="{{ $r->id }}" data-desc="{{ $r->description }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </button>
									@endif
                                @endif
                                @if(Auth::user()->hasAnyPermission([1,24,35]))
									@if ($material->created_by == Auth::user()->id)
                                <button type="button" data-toggle="modal" data-target="#md_del_file" data-id="{{ $r->id }}" data-desc="{{ $r->description }}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
									@endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->
@stop

@section('modal')
<div class="modal fade" id="md_new_file" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Upload Materi Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('material.store_content') }}" enctype="multipart/form-data">
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-book"></i>
                                    </span>
                                </div>
                                <input type="hidden" name="material_id" value="{{ $material->id }}">
                                <input type="text" class="form-control" id="description" name="description" placeholder="Deskripsi File"
                                autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
								<input type="file" name="filepath" class="filestyle" data-btnClass="btn-light" required>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_edit_file" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Ubah File Materi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="file-form">
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-book"></i>
                                    </span>
                                </div>
                                <input type="hidden" name="material_id" value="{{ $material->id }}">
                                <input type="text" class="form-control" id="_description" name="description" placeholder="Deskripsi File"
                                autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="custom-file">
								<input type="file" name="filepath" class="filestyle" data-btnClass="btn-light">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_del_file" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white">Hapus File Materi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="file-del-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus data file materi <span id="file_material"></span> ?
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
@stop

@section('script')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $("#md_edit_file").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');

            $("#_description").val(desc);
            $('#file-form').attr('action', "{{ url('/') }}/okm/material/update_content/"+id);
        })

        $("#md_del_file").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');

            $("#file_material").html("["+id+"] "+desc);
            $('#file-del-form').attr('action', "{{ url('/') }}/okm/material/destroy_content/"+id);
        })
    </script>
@stop
