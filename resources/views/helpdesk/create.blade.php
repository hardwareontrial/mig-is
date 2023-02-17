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
                    <div class="form-inline">
                        <div class="col-md-1">
                            <button onclick="window.history.back();" class="btn btn-outline-danger"><i class="fa fa-arrow-left"></i> Back</button>
                        </div>
                        <div class="col-md-9">
                            <h5 align="center">Form Request Helpdesk </h5>
                        </div>                        
                    </div>                    
                </div>
                <div class="card-body">
                    <form action="{{ route('helpdesk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">
                                Title <br>
                                <span><i style="color:red;">*</i>&nbsp;<small><i>Max 50 Character</i>    </small></span>
                            </label>
                            <div class="col-lg-6">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-thumb-tack" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="example-input1-group1"
                                        name="title" placeholder="Input helpdesk title" autocomplete="off" 
                                        maxlength='50' required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-lg-3">Request Description</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <textarea name="description" id="text-description" class="form-control"
                                    placeholder="Describe your helpdesk request"></textarea>                    
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
                                            <i class="fa fa-calendar" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date_start" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_start" value="{{ date('m/d/Y') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input id="timepicker_start" name="time_start" type="text" autocomplete="off" 
                                        class="form-control" required>
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
                                            <i class="fa fa-calendar" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="date_end" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" id="datepicker_end" value="{{ date('m/d/Y') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input id="timepicker_end" name="time_end" type="text" autocomplete="off" 
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="example-hf-email">
                                Privilege
                            </label>
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-eye" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control select2" name="privilege" data-placeholder=""
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
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-suitcase" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control select2" name="type" data-placeholder=""
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
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-users" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control select2 " name="assign_to[]" multiple="multiple" autocomplete="off" data-placeholder="Assign to User"
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
                            <div class="col-lg-4">
                                <div class="custom-file">
                                    <input type="file" name="attachment" class="filestyle" data-btnClass="btn-light">
                                </div>
                            </div>
                        </div>
                        @if($status!=0)
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
                        @endif                                                                    
                        <div class="form-group row">
                            <div class="col-lg-9 ml-auto">                                
                                <input type="text" style="display:none;" name="create_status" value="{{$status}}">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>                                   
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
</div>
@stop
