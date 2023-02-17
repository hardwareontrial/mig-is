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
            <h4 class="page-title">Rapot {{ $user->name }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('raport.index') }}">Nilai Rapot</a></li>
                <li class="breadcrumb-item active">Rapot {{ $user->name }}</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card m-b-10">
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
                    <a href="{{ route('raport.by_user',$user->nik) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </form>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</div>

<div class="profile-user-box card-box bg-custom">
    <div class="row">
        <div class="col-sm-6">
            <span class="float-left mr-3"><img src="@if (!empty($user->photo)) {{ url('storage/'.$user->photo) }} @else {{ asset('backend/assets/images/users/avatar-1.jpg') }} @endif" alt="" class="thumb-lg rounded-circle"></span>
            <div class="media-body text-white">
                <h4 class="mt-1 mb-1 font-18 m-t-">{{ $user->name }}</h4>
                <span class="font-13 text-light">{{ $user->position['name'] }}</span><br>
                <span class="font-13 text-light">{{ $user->division['name'] }}</span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="text-right">
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($materials as $r)
    <div class="col-lg-6">
        <a href="{{ route('raport.detail',['nik'=>$user->nik,'material_id'=>$r->id]) }}">
            <div class="card m-b-10 text-white bg-primary">
                <div class="card-body">
                    <h4>{{ $r->title }}</h4>
                    <span class="badge badge-light m-b-10">{{ $r->level }}</span>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="small hint-text m-0"><b>Bobot Jam Minimum</b>
                            </p><p class="font-montserrat bold"><i class="fa fa-book"></i>&nbsp;&nbsp;{{ $r->hours }} Jam</p>
                        </div>
                        <div class="col-md-6">
                            <p class="small hint-text m-0"><b>Bobot Jam yang didapat</b>
                            </p><p class="font-montserrat bold"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;
                            <?php $hours = 0; ?>
                            @foreach ($r->collection as $x)
                                @foreach ($x->raport as $y)
                                    <?php $hours += $y->hours ?>
                                @endforeach
                            @endforeach 
                            {{  $hours }} Jam</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @empty
    @endforelse
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
