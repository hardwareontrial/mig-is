@extends('layouts.sidebar.elearning.app')

@section('title','Master Soal')

@section('brand','OKM')

@section('breadcrumb')

<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left">
            <i class="dripicons-menu"></i>
        </button>
    </li>
    <li>
        <div class="page-title-box">
            <h4 class="page-title">Master Soal </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Master Soal</li>
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
                    <a href="{{ route('question.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </form>
            </div>
            <div class="col-sm-6">
				@if(Auth::user()->hasAnyPermission([1,24,32]))
                <a href="{{ route('question.create') }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> </a>
				@endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>Judul</th>
                <th class="text-center" style="width: 15%;">Departemen</th>
                <th class="text-center" style="width: 10%;">Level</th>
                <th class="text-center" style="width: 15%;">Jumlah Soal</th>
                <th class="text-center" style="width: 20%;">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($collections as $r)
                <tr>
                    <td>{{ $r->title }}</td>
                    <td class="text-center">{{ $r->material->division->name }}</td>
                    <td class="text-center">{{ $r->material->level }}</td>
                    <td class="text-center">{{ $r->questions_count }}</td>
                    <td class="text-center">
						@if(Auth::user()->hasAnyPermission([1,24,30]))
                        <a href="{{ route('question.show',$r->id) }}" class="btn btn-sm btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
						@endif
						@if(Auth::user()->hasAnyPermission([1,24,39]))
                        <a href="{{ route('question.edit',$r->id) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
						@endif
						@if(Auth::user()->hasAnyPermission([1,24,36]))
                        <button type="button" data-toggle="modal" data-id="{{ $r->id }}" data-desc="{{ $r->title }}" data-target="#md_del" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
						@endif
                        </button>
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
        {{ $collections->links() }}
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
                <h4 class="modal-title text-white">Hapus Soal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="data-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus data soal <span id="data_materi"></span> ?
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

        $("#md_del").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');
            $("#data_materi").html("["+id+"] "+desc);
            $('#data-form').attr('action', "{{ url('/') }}/okm/question/"+id);
        })
    </script>
@stop
