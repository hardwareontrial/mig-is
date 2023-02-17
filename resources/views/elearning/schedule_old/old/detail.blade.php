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
            <h4 class="page-title">{{ $schedule->collection['title'] }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('schedule.index') }}">Jadwal Ujian</a></li>
                <li class="breadcrumb-item active">Detail Jadwal</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

    <div class="card m-b-30">
        <div class="card-header">
        Ujian {{ $schedule->collection['title'] }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p class="small hint-text m-0"><b>Materi</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-book"></i>&nbsp;&nbsp;{{ $schedule->collection->material['title'] }}</p>
                </div>
                <div class="col-md-5">
                    <p class="small hint-text m-0"><b>Tanggal mulai - selesai</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{ $schedule->date_start }} - &nbsp;<i class="fa fa-calendar"></i>&nbsp;&nbsp;{{ $schedule->date_end }}</p>
                </div>
                <div class="col-md-2">
                    <p class="small hint-text m-0"><b>Jumlah Peserta</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-users"></i>&nbsp;&nbsp;{{ $participants_all->count() }}</p>
                </div>
                <div class="col-md-2">
                    <p class="small hint-text m-0"><b>Jumlah Soal</b>
                    </p><p class="font-montserrat bold"><i class="fa fa-file"></i>&nbsp;&nbsp;{{ count($questions_count) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Peserta</div>
                <div class="col-md-6">
                @if(Auth::user()->hasAnyPermission([1,24]) || $schedule->created_by == Auth::user()->id)
					@if (date("Y-m-d H:i:s") < $schedule->date_end)
                    <button type="button" data-toggle="modal" data-target="#md_add_participant" class="btn btn-icon waves-effect waves-light btn-primary  float-right"><i class="fa fa-plus"></i></button>
					@endif
                    <a href="{{ route('schedule.export_schedule',$schedule->id) }}" class="btn btn-icon waves-effect waves-light btn-success  float-right">Export Excel</a>
                @endif
                @if (!empty($participant_access))
                    <a href="{{ route('exam.show',$schedule->id) }}" class="btn btn-icon waves-effect waves-light btn-primary float-right" hidden> <i class="fa fa-play"></i> </a>

                    <a href="{{ route('exam.start',['id'=>$schedule->id,'last_page'=>!empty($exam_page_position->page) ? $exam_page_position->page : '1']) }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-play"></i> </a>
                @endif
                </div>
            </div>
        </div>
        <div class="card-body">
			@if(Auth::user()->hasAnyPermission([1,24]) || $schedule->created_by == Auth::user()->id)
			<div class="row m-b-20">
				<div class="col-sm-12">
					<a href="{{ route('schedule.show',['id'=> $schedule->id,'category'=>'all']) }}" class="btn btn-sm {{ Request::segment(5) == 'all' ? 'btn-info' : 'btn-outline-info' }} waves-light waves-effect">Semua ({{ $participants_all->count() }})</a>
					<a href="{{ route('schedule.show',['id'=> $schedule->id,'category'=>'passed']) }}" class="btn btn-sm {{ Request::segment(5) == 'passed' ? 'btn-success' : 'btn-outline-success' }} waves-light waves-effect">Lulus ({{ $participants_passed->count() }})</a>
					<a href="{{ route('schedule.show',['id'=> $schedule->id,'category'=>'not_passed']) }}" class="btn btn-sm {{ Request::segment(5) == 'not_passed' ? 'btn-danger' : 'btn-outline-danger' }} waves-light waves-effect">Tidak Lulus ({{ $participants_not_passed->count() }})</a>
					<a href="{{ route('schedule.show',['id'=> $schedule->id,'category'=>'not_complete']) }}" class="btn btn-sm {{ Request::segment(5) == 'not_complete' ? 'btn-warning' : 'btn-outline-warning' }} waves-light waves-effect">Belum Diselesaikan ({{ $participants_not_complete->count() }})</a>
					<a href="{{ route('schedule.show',['id'=> $schedule->id,'category'=>'not_exam']) }}" class="btn btn-sm {{ Request::segment(5) == 'not_exam' ? 'btn-secondary' : 'btn-outline-secondary' }} waves-light waves-effect">Belum Dikerjakan ({{ $participants_not_exam->count() }})</a>
				</div>
			</div>
			@endif
            <table class="table table-hover table-vcenter">
                <thead>
                    <?php
                        $current_date_time = date("Y-m-d H:i:s"); 
                    ?>
                    <tr>
                        <th class="text-center" style="width: 10%;">NIK</th>
                        <th>Nama</th>
                        <th class="text-center" style="width: 20%;">Departemen</th>
                        @if(Auth::user()->hasAnyPermission([1,24]) || $schedule->created_by == Auth::user()->id)
                        <th class="text-center" style="width: 10%;">Nilai</th>
						<th class="text-center">Status</th>
                        <th class="text-center" style="width: 10%;">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $r)
                    <tr>
                        <td align="center">{{ $r->nik }}</td>
                        <td><label class="badge badge-square badge-primary">{{ $r->user->position['name'] }}</label>&nbsp;{{ $r->user['name'] }}</td>
                        <td align="center">{{ $r->user->division['name'] }}</td>
                        @if(Auth::user()->hasAnyPermission([1,24]) || $schedule->created_by == Auth::user()->id)
                        <td align="center">{{ $r->raport['score'] }}</td>
                        <td align="center">
							@if (!empty($r->raport['start_at']) && $r->raport['status'] == 1 && $r->raport['score'] >= $schedule->collection['minimum_score'])
								Lulus
							@elseif (!empty($r->raport['start_at']) && $r->raport['status'] == 1 && $r->raport['score'] < $schedule->collection['minimum_score'])
								Tidak Lulus
							@elseif (empty($r->raport['start_at']) && $r->raport['status'] == 0)
								Belum dikerjakan
							@elseif (!empty($r->raport['start_at']) && $r->raport['status'] == 0)
								Belum diselesaikan
							@endif
						</td>
						<td align="center">
                            <button class="btn btn-sm btn-danger btn-circle" data-id="{{ $r->id }}" data-desc="{{ '['.$r->nik.'] '.$r->user['name'] }}" data-toggle="modal" data-target="#md_del_participant"><i
                                    class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada peserta</td>
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
<div class="modal fade" id="md_add_participant" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white">Tambah Peserta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('schedule.add_participant',$schedule->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-users"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="exam_participants[]" multiple="multiple" style="width: 90%;" data-placeholder="Pilih peserta" required>
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

<div class="modal fade" id="md_del_participant" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white">Hapus Peserta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="data-form">
                @method('DELETE')
                @csrf
                    <div class="form-group row">
                        <div class="col-lg-12">
                            Anda yakin akan menghapus peserta <span id="data_peserta"></span> ?
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

        $("#md_del_participant").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');

            $("#data_peserta").html(desc);
            $('#data-form').attr('action', "{{ url('/') }}/okm/schedule/remove_participant/"+id);
        })
    </script>
@stop
