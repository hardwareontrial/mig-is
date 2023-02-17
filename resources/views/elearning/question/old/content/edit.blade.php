@extends('layouts.sidebar.elearning.app')

@section('title','Ubah Pertanyaan')

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
            <h4 class="page-title">Ubah Pertanyaan </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard_okm.index') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('question.index') }}">Master Soal</a></li>
                <li class="breadcrumb-item"><a href="{{ route('question.show',$question->id) }}">{{ $question->title }}</a></li>
                <li class="breadcrumb-item active">Ubah Pertanyaan</li>
            </ol>
        </div>
    </li>

</ul>

@stop

@section('content')
<div class="container-fluid">

<div class="card">
    <div class="card-header">
        Form Pertanyaan
    </div>
        <div class="card-body">
            <form action="{{ route('question.update_content',$questionc->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Pertanyaan
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-file-o"></i>
                                </span>
                            </div>
                            <input type="hidden" class="form-control" id="example-input1-group1"
                                name="collection_id" value="{{ $questionc->collection_id }}" required>
                            <input type="text" class="form-control" id="question_edit"
                                name="question" value="{{ $questionc->question }}" placeholder="Masukkan pertanyaan" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 1
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>1</b></small>
                                </span>
                            </div>
                            <input type="hidden" class="form-control"
                                name="id_1" value="@if (!empty($answers[0])){{ $answers[0]->id }}@endif"  readonly required>
                            <input type="text" class="form-control" 
                                name="opt_1" value="@if (!empty($answers[0])){{ $answers[0]->answer }}@endif" placeholder="Masukkan Pilihan Jawaban 1" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 2
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>2</b></small>
                                </span>
                            </div>
                            <input type="hidden" class="form-control"
                                name="id_2" value="@if (!empty($answers[1])){{ $answers[1]->id }}@endif"  readonly required>
                            <input type="text"  class="form-control"
                                name="opt_2" value="@if (!empty($answers[1])){{ $answers[1]->answer }}@endif" placeholder="Masukkan Pilihan Jawaban 2" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 3
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>3</b></small>
                                </span>
                            </div>
                            <input type="hidden" class="form-control"
                                name="id_3" value="@if (!empty($answers[2])){{ $answers[2]->id }}@endif"  readonly required>
                            <input type="text" class="form-control" 
                                name="opt_3" value="@if (!empty($answers[2])){{ $answers[2]->answer }}@endif" placeholder="Masukkan Pilihan Jawaban 3" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban 4
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>4</b></small>
                                </span>
                            </div>
                            <input type="hidden" class="form-control"
                                name="id_4" value="@if (!empty($answers[3])){{ $answers[3]->id }}@endif" readonly required>
                            <input type="text" class="form-control"
                                name="opt_4" value="@if (!empty($answers[3])){{ $answers[3]->answer }}@endif" placeholder="Masukkan Pilihan Jawaban 4" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Kunci Jawaban
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-key"></i>
                                </span>
                            </div>
                            <select class="select2 form-control" name="answer_key" style="width: 60%;" id="answer_key" data-placeholder="Pilih kunci jawaban"
                                required>
                                <option></option>
                                <?php $no = 1; ?>
                                @foreach ($answers as $r)
                                <option value="{{ $r->id }}" @if ($answer_key->id == $r->id) selected @endif>Jawaban {{ $no }}</option>
                                <?php $no++; ?>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->

@stop

@section('script')
<script>
</script>
@stop
