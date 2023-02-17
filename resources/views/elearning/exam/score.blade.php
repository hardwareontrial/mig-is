@extends('layouts.topbar.app')

@section('title','Nilai Ujian')

@section('brand','Liquid CO2 Manufacture')

@section('content')

<div class="container-fluid">

    <div class="card m-b-30">
        <div class="card-header">
            Pengumuman
        </div>
        <div class="card-body text-center">
            Status
			<h4 class="@if ($status_bool) text-success @else text-danger @endif">{{ $status }}</h4>
			Nilai
			<h4>{{ $exam_score }}</h4>
			Waktu Mulai
			<h4>{{ date('d F Y H:i',strtotime($raport->start_at)) }}</h4>
			Waktu Selesai
			<h4>{{ date('d F Y H:i',strtotime($raport->finish_at)) }}</h4>
        </div>
        <div class="card-footer">
            <a href="{{ route('schedule.index') }}" class="btn btn-primary"> Kembali</a>
        </div>
    </div>
    
</div>
@stop
