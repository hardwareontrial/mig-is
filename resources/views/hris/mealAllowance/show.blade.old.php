 @extends('layouts.sidebar.hris.app')

@section('title','HRIS')

@section('brand','HRIS')

@section('breadcrumb')
    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left">
                <i class="dripicons-menu"></i>
            </button>
        </li>
        <li>
            <div class="page-title-box">
                <h4 class="page-title">Detail Tunjangan Uang Makan </h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Menu Utama</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('MealAllowance.index') }}">Tunjangan Uang Makan</a></li>
                    <li class="breadcrumb-item active">Detail </li>
                </ol>
            </div>
        </li>
    </ul>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <h5>
                                Periode :   
                                {{Date('d-m-Y', strtotime($data_master->periode_start))}} 
                                    - 
                                {{Date('d-m-Y', strtotime($data_master->periode_end))}}
                            </h5>
                        </div>
                        @if(Auth::user()->nik!='666')
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <a type="button" href="{{route('MealAllowance.print', $data_master->id)}}" class="btn btn-success float-right">
                                    <i class="fa fa-print"></i> Cetak
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(Auth::user()->nik == '666')
                    <form action="" method="GET" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user-o"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" 
                                        placeholder="Nik / Nama Karyawan"
                                        name="keyword">
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="">
                                <th>No</th>
                                <th>date</th>
                                <th>Karyawan</th>
                                <th>Uang Makan</th>
                                <th>Lembur</th>
                                <th>Jam</th>
                                <th>Uang Makan Lembur</th>
                                <th>Jumlah</th>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($data_detail as $data)
                                    <tr>
                                        <td scope="row">{{ ($data_detail->currentpage()-1) * $data_detail->perpage() + $no }}</td>
                                        <td>{{Date('d-m-Y', strtotime($data->date))}}</td>
                                        <td>
                                            <span class="text-muted"><small><i>NIK : </i></small></span>
                                            <span><small>{{$data->nik}}</small></span>
                                            <br>
                                            <span>{{$data->user->name}}</span>
                                        </td> 
                                        <td>{{$data->meal_allowance_val}}</td>
                                        <td>{{$data->overtime_val}}</td>
                                        <td>{{$data->overtime_hour}}</td>
                                        <td>{{$data->meal_overtime_val}}</td>
                                        <td>{{$data->meal_allowance_val + $data->overtime_val 
                                              + $data->overtime_hour + $data->meal_overtime_val}}</td>
                                    </tr>
                                    @php $no++; @endphp
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
                <div class="card-footer"> 
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-start">
                            {{$data_detail->appends(Request::only('keyword'))->links()}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@stop