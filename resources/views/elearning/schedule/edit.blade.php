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
            <h4 class="page-title">Edit Jadwal Ujian </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{route('schedule.index')}}">Jadwal Ujian</a></li>
                <li class="breadcrumb-item active">Edit Jadwal Ujian</li>
            </ol>
        </div>
    </li>
</ul>

@stop

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            
        </div>
        <div class="card-body">
        <form action="{{ route('schedule.update', $schedule->id) }}" method="POST">
                @method('PUT')
                @csrf            
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Soal
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-book" style="width:20px;"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="collection_id" style="width: 90%;" autocomplete="off" data-placeholder="Pilih soal ujian"
                                required>
                                <option></option>
                                @foreach ($collections as $r)
                                <option value="{{ $r->id }}" {{($r->id == $schedule->collection_id)? "selected":""}}>
                                    {{ $r->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="form-label col-lg-3">Program</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-caret-square-o-down" style="width:20px;"></i>
                                </span>
                            </div>
                            <select name="program" class="form-control select2"
                                data-placeholder="Pilih Jadwal Program"
                                style="width:90%;">
                                <option></option>
                                <option value="1" {{(!empty($schedule->program) && $schedule->program == '1')?'selected':'' }}>
                                    Ujian
                                </option>
                                <option value="2" {{(!empty($schedule->program) && $schedule->program == '2')?'selected':'' }}>Remidial</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Keterangan
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-o" style="width:20px;"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="description" value="{{$schedule->description}}" placeholder="Keterangan tambahan" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Tanggal
                    </label>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" style="width:20px;"></i>
                                </span>
                            </div>
                            <input type="text" name="date_start" class="form-control" autocomplete="off" 
                                placeholder="mm/dd/yyyy" id="datepicker_start" value="{{Date('m/d/yy',strtotime($schedule->date_start))}}" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span><small>Start</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar" style="width:20px"></i>
                                </span>
                            </div>                            
                            <input id="datepicker_end" name="date_end" type="text" autocomplete="off" 
                                class="form-control" placeholder="mm/dd/yyyy" 
                                value={{Date('m/d/yy', strtotime($schedule->date_end))}} required >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span><small>End</small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                        Waktu
                    </label>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o" style="width:20px;"></i>
                                </span>
                            </div>
                            <input type="text" name="time_start" class="form-control" 
                                autocomplete="off" id="timepicker_start" 
                                value="{{date('H:i', strtotime($schedule->date_start))}}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <small>Start</small>
                                </span>
                            </div>    
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-clock-o" style="width:20px;"></i>
                                </span>
                            </div>
                            <input id="timepicker_end" name="time_end" type="text" 
                                autocomplete="off" class="form-control" 
                                value="{{date('H:i', strtotime($schedule->date_end))}}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <small>End</small>
                                </span>
                            </div> 
                        </div>
                    </div>
                </div>                
                <!-- <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Peserta
                    </label>
                    <div class="col-lg-6">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-users" style="width:20px;"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="exam_participants[]" 
                                style="width: 90%;" multiple="multiple" multiple autocomplete="off" 
                                data-placeholder="Pilih peserta ujian" required>
                                <option></option>
                                <option value="all" >Semua</option>
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
                </div> -->
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop