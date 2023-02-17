@extends('layouts.sidebar.elearning.app')

@section('title','Nilai Rapot')

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
            <h4 class="page-title">Materi - {{ $raport->title }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('raport.index') }}">Nilai Rapot</a></li>
                @if ($uac_admin || $uac_subordinate->count() > 0)
                <li class="breadcrumb-item"><a href="{{ route('raport.by_user',$user->nik) }}">Rapot {{ $user->name }}</a></li>
                @endif
                <li class="breadcrumb-item active">Materi - {{ $raport->title }}</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="row">
    <div class="col-lg-12">
        <div class="card-box">
           
            <div class="card-body">
                @if ($uac_admin || $uac_subordinate->count() > 0)
                <div class="row">
                    <div class="col-md-4">
                        <p class="small hint-text m-0"><b>Nama</b>
                        </p><p class="font-montserrat bold"><i class="fa fa-user"></i>&nbsp;&nbsp;{{ $user->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small hint-text m-0"><b>Posisi</b>
                        </p><p class="font-montserrat bold"><i class="fa fa-suitcase"></i>&nbsp;&nbsp;{{ $user->position['name'] }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="small hint-text m-0"><b>Divisi</b>
                        </p><p class="font-montserrat bold"><i class="fa fa-building"></i>&nbsp;&nbsp;{{ $user->division['name'] }}</p>
                    </div>
                </div>
                @endif
                
                
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <!-- <th>#</th>
                        <th class="text-center">Ujian</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Bobot Jam</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($raport->collection as $r)
                        @if (count($r->raport) > 0)
                            <tr class="table-primary">
                                <td colspan="6" style="vertical-align:middle">{{ $r->title }}</td>
                            </tr>
                            @foreach ($r->raport as $y)
                            <tr>
                                <th scope="row"><small>Jadwal Ujian</small>@if ($y->schedule_collection['is_active'] == 0) <span class='badge badge-danger'><small>Jadwal dihapus</small></span> @endif<br>{{ date('d F Y H:i',strtotime($y->schedule_collection['date_start'])) }} - {{ date('d F Y H:i',strtotime($y->schedule_collection['date_end'])) }}
                                    <br>
                                    <small>Waktu Mulai</small><br>
                                    @if (!empty($y->start_at)) {{ date('d F Y H:i',strtotime($y->start_at)) }} @else - @endif<br>
                                    <small>Waktu Selesai</small><br>
                                    @if (!empty($y->finish_at)) {{ date('d F Y H:i',strtotime($y->finish_at)) }} @else - @endif
                                </th>
								<td class="text-center" style="vertical-align:middle;text-align:center;"><small>Nilai Minimum</small><br><b>{{ $r->minimum_score }}</b></td>
                                <td class="text-center" style="vertical-align:middle;text-align:center;"><small>Nilai Diperoleh</small><br><b>{{ $y->score }}</b></td>
                                <td class="text-center" style="vertical-align:middle;text-align:center;"><small>Total Jam</small><br><b>{{ $y->hours }}</b></td>
								<td class="text-center" width="20%" style="vertical-align:middle;text-align:center;"><small>Status Kelulusan</small><br>
									<b>
									@if ($y->status != 0 && $y->score >= $r->minimum_score) 
										Lulus
									@elseif  ($y->status != 0 && $y->score < $r->minimum_score) 
										Tidak Lulus
									@elseif ($y->status == 0 && empty($y->start_at))
										Belum mengerjakan ujian
									@elseif ($y->status == 0 && !empty($y->start_at))
										Belum menyelesaikan ujian
									@endif
									</b>
								</td>
								@if (!empty($y->start_at) && empty($y->finish_at))
								<td style="vertical-align:middle;text-align:center;width:10%"><a href="{{ route('exam.result',$y->schedule_id) }}" class="btn btn-sm btn-primary">Proses Nilai</a></td>
								@endif
                            </tr>
                            @endforeach
                        @endif
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
                <h4 class="modal-title text-white">Hapus Materi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="data-form">
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

        $("#md_del").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            var desc = $(e.relatedTarget).data('desc');
            $("#data_materi").html("["+id+"] "+desc);
            $('#data-form').attr('action', window.location.origin+"/okm/question/"+id);
        })
    </script>
@stop
