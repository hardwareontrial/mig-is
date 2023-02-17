@extends('layouts.topbar.app')

@section('title','Helpdesk')

@section('brand','Helpdesk')

@section('content')
<!-- Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('helpdesk.index','new') }}">
                <div class="card-box tilebox-one bg-primary text-white">
                    <i class="fa fa-file float-right"></i>
                    <h6 class=" text-uppercase mt-0">Total New</h6>
                    <h2 class="" data-plugin="counterup">{{ $total_new->count() }}</h2>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('helpdesk.index','in_process') }}">
                <div class="card-box tilebox-one bg-warning text-white">
                    <i class="fa fa-gears float-right"></i>
                    <h6 class=" text-uppercase mt-0">Total In Process</h6>
                    <h2 class="" data-plugin="counterup">{{ $total_process->count() }}</h2>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('helpdesk.index','complete') }}">
                <div class="card-box tilebox-one bg-success text-white">
                    <i class="fa fa-check float-right"></i>
                    <h6 class=" text-uppercase mt-0">Total Complete</h6>
                    <h2 class="" data-plugin="counterup">{{ $total_complete->count() }}</h2>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="{{ route('helpdesk.index','pending') }}">
                <div class="card-box tilebox-one bg-danger text-white">
                    <i class="fa fa-clock-o float-right"></i>
                    <h6 class=" text-uppercase mt-0">Total Pending</h6>
                    <h2 class="" data-plugin="counterup">{{ $total_pending->count() }}</h2>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('helpdesk.index','assign_new') }}"
                class="btn btn-primary waves-effect waves-light col-md-12">
                    <i class="fa fa-file m-r-5"></i>
                    <span>Total Assign New: {{ $total_assign_new->count() }}</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('helpdesk.index','assign_in_process') }}"
                class="btn btn-warning waves-effect waves-light col-md-12">
                    <i class="fa fa-gears m-r-5"></i>
                    <span>Total Assign In Process: {{ $total_assign_process->count() }}</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('helpdesk.index','assign_complete') }}"
                class="btn btn-success waves-effect waves-light col-md-12">
                <i class="fa fa-check m-r-5"></i>
                <span>Total Assign Complete: {{ $total_assign_complete->count() }}</span>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('helpdesk.index','assign_pending') }}"
                class="btn btn-danger waves-effect waves-light col-md-12">
                    <i class="fa fa-clock-o m-r-5"></i>
                    <span>Total Assign Pending: {{ $total_assign_pending->count() }}</span>
            </a>
        </div>
    </div>
    <div class="card" style="margin-top:10px;">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-8">
                    <form class="form-inline" action="{{ url()->current() }}" >
                        <div class="input-group mb-2 mr-sm-3 mb-sm-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-wpforms"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control mr-sm-1" name="keyword" id="keyword"
                                value="@if (!empty($keyword)) {{ $keyword }} @endif"
                                placeholder="Search..." autocomplete="off"/>
                            <div class="input-group-prepend ">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input class="form-control input-daterange-datepicker mr-sm-1"
                                name="date_search" id="date_search" type="text"
                                value="" />
                            <button type="submit" class="btn btn-primary mr-sm-1">
                                <i class="fa fa-search"></i>
                            </button>
                            <a href="{{ route('helpdesk.index') }}" class="btn btn-info">
                                <span class="fa fa-eraser"></span>
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4">
                    <div class="input-group justify-content-end">
                        <a href="{{ route('helpdesk.export') }}" class="btn btn-success mr-sm-2">
                            <i class="fa fa-file-excel-o"></i>
                            <span>Export Excel</span>
                        </a>
                        <button type="button"
                            class="btn btn-light dropdown-toggle waves-effect btn-primary"
                            data-toggle="dropdown" aria-expanded="false">Buat Baru
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                            <a class="dropdown-item" href="{{ route('helpdesk.create') }}">General</a>
							<a class="dropdown-item" href="{{ route('authorization.create') }}">SAP Authorization</a>
                            <a class="dropdown-item" href="{{ route('config.create')}}">SAP Config</a>
							<a class="dropdown-item" href="{{ route('abap.create')}}">SAP ABAP</a>
							<a class="dropdown-item" href="{{ route('vendor.create') }}">SAP Master Data Vendor</a>
                            <!--<a class="dropdown-item" href="">SAP New Customer</a>
                            <a class="dropdown-item" href="">SAP New Material</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($category != "all")
            <div class="alert alert-primary alert-dismissible @if ($category == 'new' || $category == 'assign_new') bg-primary @elseif ($category == 'in_process' || $category == 'assign_in_process') bg-warning @elseif ($category == 'complete' || $category == 'assign_complete') bg-success @elseif ($category == 'pending' || $category == 'assign_pending') bg-danger @endif text-white border-0 fade show" role="alert">
                <a href="{{ route('helpdesk.index') }}" class="close" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </a>
                @if ($category == 'new') Filter By New Helpdesk
                @elseif ($category == 'in_process') Filter By In Process Helpdesk
                @elseif ($category == 'complete') Filter By Complete Helpdesk
                @elseif ($category == 'pending') Filter By Pending Helpdesk
                @elseif ($category == 'assign_new') Filter By Assign New Helpdesk
                @elseif ($category == 'assign_in_process') Filter By Assign In Process Helpdesk
                @elseif ($category == 'assign_complete') Filter By Assign Complete Helpdesk
                @elseif ($category == 'assign_pending') Filter By Assign Pending Helpdesk
                @endif
            </div>
            @endif
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
                    @forelse ($helpdesks as $r)

                    <tr class="{{ $r->type == 'Urgent' ? 'table-danger' : '' }}">
                        <th class="text-center" scope="row" style="vertical-align: middle;">{{ $r->id }}</th>
                        <td style="vertical-align: middle;">
                            <a href="@if ($r->category == 'General')
                                    {{ route('helpdesk.show', $r->id) }}
                                    @elseif ($r->category == 'SAP Authorization')
                                    {{ route('authorization.show', $r->id) }}
                                    @elseif($r->category == 'SAP Config')
                                    {{ route('config.show', $r->id) }}
                                    @elseif($r->category == 'SAP ABAP')
                                    {{ route('abap.show', $r->id) }}
                                    @elseif($r->category == 'SAP Master Data Vendor')
                                    {{ route('vendor.show', $r->id) }}
                                    @endif">
                                    [{{strtoupper($r->category)}}] - {{ $r->title }}
                            </a> <br>
                            <small>By. @if (Auth::user()->id == $r->creator_id) You @else {{ $r->creator->name }}
                                @endif</small>
                        </td>
                        <td class="d-none d-sm-table-cell" style="vertical-align: middle;">
                            @foreach ($r->assign as $s)
                                @if ($s->division != null)
                                <span class="badge badge-primary">{{ $s->division['name'] }}</span>
                                @elseif ($s->user != null)
                                <span class="badge badge-info">{{ $s->user['name'] }}</span>
                                @elseif ($s->user == 0)
                                <span class="badge badge-success">Semua</span>
                                @endif
                                <br>
                            @endforeach
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <!-- {{ date('d-m-Y H:i', strtotime($r->date_start)) }} -->
                            {{ $r->date_start }}
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <!-- {{ date('d-m-Y H:i', strtotime($r->date_end)) }} -->
                            {{ $r->date_end }}
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
            {{ $helpdesks->links() }}
            </div>
        </div>
    </div>
    <!-- END Hover Table -->
</div>
<!-- END Page Content -->
@stop

@section('script')
    <script>
        // $(document).ready(function () {$('#date_search').datetimepicker({useCurrent: false});});
    </script>
@stop
