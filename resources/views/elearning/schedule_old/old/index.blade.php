@extends('layouts.sidebar.elearning.app')

@section('title','Jadwal Ujian')

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
            <h4 class="page-title">Jadwal Ujian </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Jadwal Ujian</li>
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
                    <a href="{{ route('schedule.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </form>
            </div>
            <div class="col-sm-6">
            @if(Auth::user()->hasAnyPermission([1,24,33]))
                <a href="{{ route('schedule.create') }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> </a>
            @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row m-b-20">
            <div class="col-sm-12 text-right">
				<a href="{{ route('schedule.index','all') }}" class="btn btn-sm {{ Request::url() == url('/okm/schedules/all') || Request::url() == url('/okm/schedules')? 'btn-info' : 'btn-outline-info' }} waves-light waves-effect">Semua</a>
				<a href="{{ route('schedule.index','now') }}" class="btn btn-sm {{ Request::url() == url('/okm/schedules/now') ? 'btn-success' : 'btn-outline-success' }} waves-light waves-effect">Sedang Berlangsung</a>
				<a href="{{ route('schedule.index','upcomming') }}" class="btn btn-sm {{ Request::url() == url('/okm/schedules/upcomming') ? 'btn-primary' : 'btn-outline-primary' }} waves-light waves-effect">Akan Datang</a>
                <a href="{{ route('schedule.index','done') }}" class="btn btn-sm {{ Request::url() == url('/okm/schedules/done') ? 'btn-secondary' : 'btn-outline-secondary' }} waves-light waves-effect">Selesai</a>
            </div>
        </div>
        <table class="table table-hover table-vcenter">
            <thead>
                <tr>
                    <th>Ujian</th>
                    <th class="text-center" style="width: 20%;">Tanggal</th>
                    <th class="text-center" style="width: 10%;">Durasi</th>
                    <th class="text-center" style="width: 15%;">Status</th>
                    <th class="text-center" style="width: 15%;">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $current_date_time = date("Y-m-d H:i:s"); 
            ?>
                @forelse ($schedules as $r)
                <tr class="@if ($current_date_time >= $r->date_start && $current_date_time <= $r->date_end) table-success @elseif ($current_date_time > $r->date_end) table-active @elseif ($current_date_time <= $r->date_start) @endif">
                <div valign="middle">
                    <td style="vertical-align: middle;">{{ $r->collection['title'] }}<b>@if (!empty($r->description)) <br> {{ strtoupper($r->description) }} @endif</b><br><small>Dibuat oleh <b>{{ $r->creator['name'] }}</b></small></td>
                    <td style="vertical-align: middle;" align="center">
						<small>Mulai</small><br>
						{{ $r->date_start }}<br>
						<small>Selesai</small><br>
						{{ $r->date_end }}
					</td>
                    <td style="vertical-align: middle;" align="center">{{ $r->collection['duration'] }} menit</td>
                    <td style="vertical-align: middle;" align="center">
						<i>
					@if ($r->raport['status'] == 0 && empty($r->raport['start_at']) && empty($r->raport['finish_at']) && $r->created_by != Auth::user()->id)
					<span class='badge badge-warning'>Belum dikerjakan</span> 
					@elseif ($r->raport['status'] == 0 && !empty($r->raport['start_at']) && empty($r->raport['finish_at']) && $r->created_by != Auth::user()->id) 
					<span class='badge badge-info'>Belum diselesaikan</span> 
					@elseif ($r->raport['status'] == 1 && !empty($r->raport['start_at']) && !empty($r->raport['finish_at']) && $r->created_by != Auth::user()->id)
					<span class='badge badge-success'>Sudah dikerjakan</span> 
					@elseif ($r->created_by == Auth::user()->id)
					<span class='badge badge-primary'>Admin</span> 
					@endif
						</i>
					</td>
                    <td style="vertical-align: middle;" align="center">
                        <a href="{{ route('schedule.show',['id'=>$r->id,'category'=>'']) }}" class="btn btn-sm btn-primary btn-circle"><i
                                class="fa fa-eye" aria-hidden="true"></i></a>
                        
                        @if ($uac_delete && $current_date_time <= $r->date_start)
                        <button data-toggle="modal" data-target="#md_del" data-id="{{ $r->id }}" data-desc="{{ $r->collection['title'] }} <br> {{ $r->date_start }} - {{ $r->date_end }}" class="btn btn-sm btn-danger btn-circle"><i
                                class="fa fa-trash" aria-hidden="true"></i></button>
                        @endif
                    </td>
                </div>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada jadwal</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $schedules->links() }}
    </div>
</div>

</div>
<!-- END Page Content -->
@stop

@section('modal')

<div class="modal fade" id="md_del" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white">Hapus Jadwal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="data-form">
                    @method('DELETE')
                    @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                Anda yakin akan menghapus data jadwal <span id="data_materi"></span> ?
                            </div>
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
            $('#data-form').attr('action', "{{ url('/') }}/okm/schedule/"+id);
        })
    </script>
@stop
