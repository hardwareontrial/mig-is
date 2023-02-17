@extends('layouts.topbar.app')

@section('title','Create Helpdesk')

@section('brand','Helpdesk')

@section('color','bg-cyan-600')

@section('script')
<script src="{{ asset('js/helpdesk.js') }}"></script>
<script>

    if($("#elm1").length > 0){
        tinymce.init({
            selector: "textarea#elm1",
            theme: "modern",
            height:300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
        });
    }

</script>
@stop



@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create New Helpdesk</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    Form
                </div>
                <div class="card-body">
                        <form action="{{ route('helpdesk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">
                                    Title
                                </label>
                                <div class="col-lg-7">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file-o"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="example-input1-group1"
                                            name="title" value="" placeholder="Input helpdesk title" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">
                                    Date Time (Start)
                                </label>
                                <div class="col-lg-3">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date_start" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_start" value="{{ date('m/d/Y') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <input id="timepicker_start" name="time_start" type="text" autocomplete="off" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    Date Time (End)
                                </label>
                                <div class="col-lg-3">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date_end" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_end" value="{{ date('m/d/Y') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <input id="timepicker_end" name="time_end" type="text" autocomplete="off" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    Privilege
                                </label>
                                <div class="col-lg-4">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o"></i>
                                            </span>
                                        </div>
                                        <select class="form-control select2" style="width: 40%;" name="privilege" data-placeholder=""
                                            required>
                                            <option value="Public">Public</option>
                                            <option value="Private">Private</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    Condition Type
                                </label>
                                <div class="col-lg-4">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-suitcase"></i>
                                            </span>
                                        </div>
                                        <select class="form-control select2" style="width: 40%;" name="type" data-placeholder=""
                                            required>
                                            <option value="Normal">Normal</option>
                                            <option value="Urgent">Urgent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    Assign To
                                </label>
                                <div class="col-lg-9">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-users"></i>
                                            </span>
                                        </div>
                                        <select class="select2 form-control" name="assign_to[]" style="width: 90%;" multiple="multiple" multiple autocomplete="off" data-placeholder="Select user"
                                        required>
                                            <option></option>
                                            <option value="0">Semua</option>
                                            <optgroup label="Berdasarkan Departement">
                                            @foreach ($divisions as $r)
                                            <option value="d-{{ $r->id }}">{{ $r->name }}</option>
                                            @endforeach
                                            <optgroup label="Berdasarkan Nama">
                                            @foreach ($users as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    File Attachment
                                </label>
                                <div class="col-lg-9">
                                    <div class="custom-file">
                                        <input type="file" name="attachment" class="filestyle" data-btnClass="btn-light">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="example-hf-email">
                                    Comment
                                </label>
                                <div class="col-lg-9">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <textarea id="elm1" name="comment"></textarea>
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
    </div>

    <div class="row">
        <div class="col-12">
            <br>
        </div>
    </div>
                <!-- end row -->
</div>
@stop
