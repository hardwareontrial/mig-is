@extends('layouts.sidebar.elearning.app')

@section('title','Buat Pertanyaan')

@section('brand','OKM')

@section('content')
<div class="content">
    <nav class="breadcrumb push">
        <a class="breadcrumb-item" href="{{ route('dashboard.index') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('question.index') }}">Master Soal</a>
        <a class="breadcrumb-item" href="{{ route('question.show', $question->id) }}">{{ $question->title }}</a>
        <span class="breadcrumb-item active">Buat Pertanyaan Baru</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Buat Pertanyaan Baru</h3>
            <div class="block-options">
            </div>
        </div>
        <div class="block-content">
            <form action="{{ route('question.store_content') }}" method="POST">
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
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="answer" value="" placeholder="Masukkan pertanyaan" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban A
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>A</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="a" value="" placeholder="Masukkan Pilihan Jawaban A" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban B
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>B</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="b" value="" placeholder="Masukkan Pilihan Jawaban B" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban C
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>C</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="c" value="" placeholder="Masukkan Pilihan Jawaban C" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label">
                        Jawaban D
                    </label>
                    <div class="col-lg-7">
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <small><b>D</b></small>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="example-input1-group1"
                                name="d" value="" placeholder="Masukkan Pilihan Jawaban D" required>
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
                            <select class="js-select2 form-control" name="key" style="width: 60%;" data-placeholder="Pilih materi"
                                required>
                                <option></option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-9 ml-auto">
                        <button type="submit" class="btn btn-alt-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Page Content -->

@stop
