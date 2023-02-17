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
                <h4 class="page-title">Uang Makan </h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">MIG-IS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hris.dashboard') }}">HRIS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hris.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Index Periode</li>
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
                            <h5> Tabel Periode </h5>
                        </div>
                        @if(Auth::user()->nik=='666' || Auth::user()->nik == '1000')
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <a type="button" href="{{ route('MealAllowance.create') }}" class="btn btn-success float-right">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </a>
                            </div>
                        @endif                        
                    </div>
                </div>
            <div class="card-body">
               <div class="table-responsive">
                    <table class="table table-stripped">
                        <thead>
                            <th>No.</th>
                            <th>Periode</th>
                            <th>Dibuat Oleh</th>
                            <th>Tindakan</th>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                        @foreach($data as $row)
                            <tr>
                                <td>{{ ($data->currentpage()-1) * $data->perpage() + $no}}</td>
                                <td>{{Date('d-m-Y', strtotime($row->periode_start))}} - 
                                    {{Date('d-m-Y', strtotime($row->periode_end))}}</td>
                                <td>{{$row->user['name']}}</td>
                                <td style="width:25%;">
                                    <form action="{{route('MealAllowance.delete', $row->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <!-- <a class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a> -->
                                        <a class="btn btn-sm btn-info" title="Details" href="{{route('MealAllowance.show', $row->id)}}">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        @if(Auth::user()->nik == '666' || Auth::user()->nik == '1000')
                                        <button class="btn btn-sm btn-danger" 
                                            title="Delete" type="submit" 
                                            onclick="return confirm('Ingin Menghapus Data Ini?');"
                                            href="">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a class="btn btn-sm btn-warning" 
                                            title="send to email"
                                            href="{{route('MealAllowance.pushemail', $row->id)}}">
                                            <span class="fa fa-envelope-o"></span>    
                                        </a>
                                        @endif
                                    </form>
                                </td>
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
                        {{ $data->appends(Request::only('keyword'))->links() }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@stop