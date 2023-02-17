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
            <h4 class="page-title">Nilai Rapot </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Nilai Rapot</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">
	@role('Admin|Admin OKM')
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
						<a href="{{ route('raport.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
					</form>
				</div>
				<div class="col-sm-6">
				</div>
			</div>
		</div>
	</div>
	@endrole
    <div class="row text-center">
        @role('Admin|Admin OKM')
            @forelse ($user as $r)
            <div class="col-lg-4">
                <div class="text-center card-box">
                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="@if (!empty($r->photo)) {{  url('storage/'.$r->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5">{{ $r->name }}</h4>
                            <p class="text-muted">{{ $r->position['name'] }} <span> | </span> <span> <a href="#" class="text-pink">{{ $r->division['name'] }}</a> </span></p>
                        </div>

                        <a href="{{ route('raport.by_user',$r->nik) }}" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Lihat Rapot</a>
                    </div>
                </div>
            </div>
            @empty
            @endforelse
        @endrole
		<!-- MANAGER -->
		@if (!empty($uac_manager) && $uac_manager)
            <div class="col-lg-4" hidden>
                <div class="text-center card-box">
                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="@if (!empty(Auth::user()->photo)) {{ url('storage/'.Auth::user()->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5">Anda</h4>
                            <p class="text-muted">{{ Auth::user()->position['name'] }} <span> | </span> <span> <a href="#" class="text-pink">{{ Auth::user()->division['name'] }}</a> </span></p>
                        </div>

                        <a href="{{ route('raport.by_user',Auth::user()->nik) }}" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Lihat Rapot</a>
                    </div>
                </div>
            </div>
            @forelse ($user->division_subordinates as $r)
            <div class="col-lg-4">
                <div class="text-center card-box">
                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="@if (!empty($r->photo)) {{  url('storage/'.$r->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5">{{ $r->name }}</h4>
                            <p class="text-muted">{{ $r->position['name'] }} <span> | </span> <span> <a href="#" class="text-pink">{{ $r->division['name'] }}</a> </span></p>
                        </div>

                        <a href="{{ route('raport.by_user',$r->nik) }}" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Lihat Rapot</a>
                    </div>
                </div>
            </div>
            @empty
            -
            @endforelse
        @endif
	
		<!-- SUPERVISOR -->
        @if ($uac_subordinate->count() > 0)
            <div class="col-lg-4">
                <div class="text-center card-box">
                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="@if (!empty(Auth::user()->photo)) {{ url('storage/'.Auth::user()->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5">Anda</h4>
                            <p class="text-muted">{{ Auth::user()->position['name'] }} <span> | </span> <span> <a href="#" class="text-pink">{{ Auth::user()->division['name'] }}</a> </span></p>
                        </div>

                        <a href="{{ route('raport.by_user',Auth::user()->nik) }}" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Lihat Rapot</a>
                    </div>
                </div>
            </div>
            @forelse ($user->subordinates as $r)
            <div class="col-lg-4">
                <div class="text-center card-box">
                    <div class="member-card pt-2 pb-2">
                        <div class="thumb-lg member-thumb m-b-10 mx-auto">
                            <img src="@if (!empty($r->user['photo'])) {{  url('storage/'.$r->user['photo']) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" class="rounded-circle img-thumbnail" alt="profile-image">
                        </div>

                        <div class="">
                            <h4 class="m-b-5">{{ $r->user['name'] }}</h4>
                            <p class="text-muted">{{ $r->user->position['name'] }} <span> | </span> <span> <a href="#" class="text-pink">{{ $r->user->division['name'] }}</a> </span></p>
                        </div>

                        <a href="{{ route('raport.by_user',$r->user['nik']) }}" class="btn btn-primary m-t-20 btn-rounded btn-bordered waves-effect w-md waves-light">Lihat Rapot</a>
                    </div>
                </div>
            </div>
            @empty
            -
            @endforelse
        @endif
    </div>
	@role('Admin|Admin OKM')
	{{ $user->links() }}
	@endrole
</div>
<!-- END Page Content -->
@stop

@section('modal')

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
