@extends('layouts.sidebar.edoc.app')

@section('title','Form')

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
            <h4 class="page-title">Master Form </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_edoc.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Master Form</li>
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
            <div class="col-sm-6">
                <form class="form-inline" action="{{ url()->current() }}" >
                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-wpforms"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="keyword" value="@if (!empty($keyword)) {{ $keyword }} @endif"
                            placeholder="Search..." autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2 mr-sm-2 mb-sm-0"><i class="fa fa-search"></i></button>
                    <a href="{{ route('form.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </form>
            </div>
            <div class="col-sm-6">
			@if(Auth::user()->hasAnyPermission([1,7,17]))
                <a href="{{ route('form.create') }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> </a>
			@endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table mb-0">
            <thead>
            <tr>
                <th style="width: 11%;">ID</th>
                <th>Judul</th>
                <th class="text-center" style="width: 10%;">Revisi</th>
                <th class="text-center" style="width: 10%;">Status</th>
                <th class="text-center">Last Update</th>
                <th class="text-center" style="width: 20%;">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($forms as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->title }}</td>
                    <td class="text-center">{{ $r->revisi }}</td>
                    <td class="text-center">
                    @if(Auth::user()->hasAnyPermission([1,7,18]))
                        @if($r->status == 'Active') 
                        <a href="{{ route('form.status', ['id' => $r->id, 'status' => 'Deactive']) }}" class="btn btn-success waves-effect waves-light btn-sm">Active</a>
                        @else  
                        <a href="{{ route('form.status', ['id' => $r->id, 'status' => 'Active']) }}" class="btn btn-danger waves-effect waves-light btn-sm">Deactive</a>
                        @endif
					@else
						@if($r->status == 'Active') 
                        <span class="badge badge-success">Active</span>
                        @else  
                        <span class="badge badge-danger">Deactive</span>
                        @endif
					@endif
                    </td>
                    <td class="text-center">{{ $r->updated_at }}</td>
                    <td class="text-center">
						@if(Auth::user()->hasAnyPermission([1,7,18]))
                        <a href="{{ route('form.download', $r->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-download"></i>
                        </a>
                        <button data-toggle="modal" data-id="{{ $r->id }}" data-desc="{{ $r->title }}" data-filepath="{{ $r->filepath }}" data-rev="{{ $r->revisi }}" data-jenis="{{ $r->jenis }}" data-type="DOC" data-target="#md_edit_file" class="btn btn-sm btn-warning">
                            <i class="fa fa-upload"></i>
                        </button>
                        <button data-toggle="modal" data-id="{{ $r->id }}" data-desc="{{ $r->title }}" data-target="#md_del" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
						@elseif(Auth::user()->hasAnyPermission([16]))
							@if($r->status == 'Active')
                                <a href="{{ route('form.download', $r->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-download"></i>
                                </a>
								<a href="{{ route('list.create', ['id' => $r->id, 'doc_type' => $r->jenis, 'iso_type' => 'Form']) }}" class="btn btn-sm btn-warning">
									<i class="fa fa-edit"></i>
								</a>
							@elseif($r->status == 'Deactive')
                                <button href="#" class="btn btn-sm btn-primary" disabled>
									<i class="fa fa-download"></i>
								</button>
								<button href="#" class="btn btn-sm btn-warning" disabled>
									<i class="fa fa-edit"></i>
								</button>
							@endif
						@endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <hr>
        {{ $forms->links() }}
    </div>
</div>

</div>
<!-- END Page Content -->
@stop

@section('modal')

<div class="modal fade" id="md_del" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white">Hapus Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="data-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus form <span id="data_iso"></span> ?
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

<div class="modal fade" id="md_edit_file" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white title-ubah-file">Ubah File Form </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('form.update_file') }}" enctype="multipart/form-data" id="file-form">
                @csrf
                    <input type="hidden" name="id_document" id="id_document">
                    <input type="hidden" name="rev_number" id="rev_number">
                    <input type="hidden" name="old_filepath_modal" id="old_filepath_modal">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="custom-file">
								<input type="file" name="new_filepath_modal" class="filestyle" data-btnClass="btn-light">
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
            $("#data_iso").html("["+id+"] "+desc);
            $('#data-form').attr('action', "{{ url('/') }}/edoc/form/"+id);
        })

        $("#md_edit_file").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');
            var filepath = $(e.relatedTarget).data('filepath');
            var type = $(e.relatedTarget).data('type');
            var jenis = $(e.relatedTarget).data('jenis');
            var rev = $(e.relatedTarget).data('rev');
            
            $("#id_document").val(null);
            $("#old_filepath_modal").val(null);
            $("#rev_number").val(null);

            $(".title-ubah-file").html("Ubah File : " + desc);
            $("#id_document").val(id);
            $("#old_filepath_modal").val(filepath);
            $("#rev_number").val(rev);

            //$('#file-form').attr('action', "{{ url('/') }}/edoc/document/update_file/");
        })
    </script>
@stop
