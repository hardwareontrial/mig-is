@extends('layouts.sidebar.edoc.app')

@section('title','Edoc List')

@section('breadcrumb')

<ul class="list-inline menu-left mb-0">
    <li class="float-left">
        <button class="button-menu-mobile open-left">
            <i class="dripicons-menu"></i>
        </button>
    </li>
    <li>
        <div class="page-title-box">
            <h4 class="page-title">Edoc List </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_edoc.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Edoc List</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<!-- Page Content -->
<div class="container-fluid">

    <div class="card" style="margin-top:10px;">
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
                        <a href="{{ route('list.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </form>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('list.create') }}" class="btn btn-icon waves-effect waves-light btn-primary float-right"> <i class="fa fa-plus"></i> </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">ID</th>
                        <th>Title</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Assign To</th>
                        <th class="text-center" style="width: 15%;">Date Start</th>
                        <th class="text-center" style="width: 15%;">Date End</th>
                        <th class="text-center" style="width: 15%;">Privilege</th>
                        <th class="text-center" style="width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($edocs as $r)
                    <tr class="{{ $r->type == 'Urgent' ? 'table-danger' : '' }}">
                        <th class="text-center" scope="row" style="vertical-align: middle;">{{ $r->id }}</th>
                        <td style="vertical-align: middle;">
                            <a href="{{ route('list.show', $r->id) }}">{{ $r->title }}</a> <br>
                            <small>By. @if (Auth::user()->id == $r->user_id) You @else {{ $r->creator->name }}
                                @endif</small>
                        </td>
                        <td class="d-none d-sm-table-cell" style="vertical-align: middle;">
                            @foreach ($r->assign as $s) 
                                @if ($s->division != null)
                                <span class="badge badge-primary">{{ $s->division['name'] }}</span>
                                @elseif ($s->user != null)
                                <span class="badge badge-info">{{ $s->user['name'] }}</span>
                                @endif
                                <br>
                            @endforeach
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            {{ date('d-m-Y H:i', strtotime($r->date_start)) }}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            {{ date('d-m-Y H:i', strtotime($r->date_end)) }}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            {{ $r->privilege }}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            @if ($r->status == 'New')
                            <span class="badge badge-info">New</span>
                            @elseif ($r->status == 'In Process')
                            <span class="badge badge-warning">In Process</span>
                            @elseif ($r->status == 'Complete')
                            <span class="badge badge-success">Complete</span>
                            @elseif ($r->status == 'Pending')
                            <span class="badge badge-danger">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Data is empty</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <hr>
            <div class="float-right">
            </div>
        </div>
    </div>
    <!-- END Hover Table -->

</div>
<!-- END Page Content -->
@stop
