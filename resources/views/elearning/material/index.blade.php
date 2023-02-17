@extends('layouts.sidebar.elearning.app')

@section('title','Master Materi')

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
            <h4 class="page-title">Master Materi </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Master Materi</li>
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
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <a href="{{ route('material.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </form>
            </div>
            <div class="col-sm-6">
                @if(Auth::user()->can('create material okm') || Auth::user()->can('admin all') 
								|| Auth::user()->can('admin okm'))
                <a href="{{ route('material.create') }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div id="accordion" role="tablist" aria-multiselectable="true">
            @forelse ($materials as $r)
            <div class="card">
                <div class="card-headerv2" role="tab" id="accordion_h1">
                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_m{{ $r->id }}" aria-expanded="true" aria-controls="accordion_q1"><label for="" class="badge badge-pill badge-primary">{{ $r->division['name'] }}</label> {{ $r->title }}</a><div class="text-muted"><i class="fa fa-line-chart"></i>&nbsp;{{ $r->level }} &nbsp; <i class="fa fa-file-o"></i>&nbsp;{{ date('d-m-Y H:i',strtotime($r->created_at)) }} &nbsp; <i class="fa fa-user"></i>&nbsp; {{ $r->creator->name }} </div>
                </div>
                <div id="accordion_m{{ $r->id }}" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion">
                    <div class="card-body">
                        {!! $r->sinopsis !!}
                        <hr>
                        <div class="form-group row">
                            <div class="col-lg-7">
								@if(Auth::user()->hasAnyPermission([1,24,29]))
                                <a href="{{ route('material.show',$r->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
								@endif
                                @if(Auth::user()->hasAnyPermission([1,24,38]))
									@if ($r->created_by == Auth::user()->id)
                                <a href="{{ route('material.edit',$r->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
									@endif
                                @endif
                                </a>
                                @if(Auth::user()->hasAnyPermission([1,24,35]))
									@if ($r->created_by == Auth::user()->id)
                                <button type="button" data-toggle="modal" data-id="{{ $r->id }}" data-desc="{{ $r->title }}" data-target="#md_del_material" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
									@endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="form-group row">
                <div class="col-lg-12">
                    <p align="center">Data masih kosong</p>
                </div>
            </div>
            @endforelse
        </div>
        <hr>
        {{ $materials->links() }}
    </div>
</div>

</div>
<!-- END Page Content -->
@stop

@section('modal')

<div class="modal fade" id="md_del_material" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white">Hapus Materi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="material-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus data materi <span id="data_materi"></span> ?
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

        $("#md_del_material").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');
            $("#data_materi").html("["+id+"] "+desc);
            $('#material-form').attr('action', "{{ url('/') }}/okm/material/"+id);
        })
    </script>
@stop
