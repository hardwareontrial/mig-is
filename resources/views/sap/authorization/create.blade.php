@extends('layouts.topbar.app')

@section('title','Create Request Auth')

@section('brand','Helpdesk')

@section('color','bg-cyan-600')

@section('script')
<script src="{{ asset('js/helpdesk.js') }}"></script>
<script>
    $("#btn_add_auth").on('click', function(e) {
        e.preventDefault();
        
        var xhtml ="";
        xhtml += "<tr>";
        xhtml += "<td><input name='auth_tcode[]' class='form-control' placeholder='Transcation Code SAP'></td>";
        xhtml += "<td><input name='auth_desc[]' class='form-control' placeholder='Description'></td>";
        xhtml += "<td><button type='button' class='btn btn-danger' id='btn_delete_auth'>"+
                 "<i class='fa fa-trash'></i></button></td>";
        xhtml += "</tr>";

        $("#table_tcode > tbody:last-child").append(xhtml);
        
    });

    $(document).on('click','#btn_delete_auth',function(e){
        e.preventDefault();
        $(this).parent().parent('tr').remove();
    });

    if ($("#elm1").length > 0) {
        tinymce.init({
            selector: "textarea#elm1",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [{
                    title: 'Bold text',
                    inline: 'b'
                },
                {
                    title: 'Red text',
                    inline: 'span',
                    styles: {
                        color: '#ff0000'
                    }
                },
                {
                    title: 'Red header',
                    block: 'h1',
                    styles: {
                        color: '#ff0000'
                    }
                },
                {
                    title: 'Example 1',
                    inline: 'span',
                    classes: 'example1'
                },
                {
                    title: 'Example 2',
                    inline: 'span',
                    classes: 'example2'
                },
                {
                    title: 'Table styles'
                },
                {
                    title: 'Table row 1',
                    selector: 'tr',
                    classes: 'tablerow1'
                }
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
                        <li class="breadcrumb-item"><a href="{{ route('helpdesk.index') }}">Helpdesk</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Create New Authorization</h4>
            </div>
        </div>
    </div>    

    <div class="row">
        <div class="col-sm-12">
            <div class="card">                
                <div class="card-header">
                    <div class="form-inline">
                        <div class="col-md-1">
                            <button class="btn btn-outline-danger btnback"
                                onClick="window.history.back();">
                                <i class="fa fa-arrow-left"></i> Back
                            </button>                        
                        </div>
                        <div class="col-md-9">
                            <h5 align="center">Form Request Authorization</h5>
                        </div>                            
                    </div>                                                        
                </div>                
                <div class="card-body">
                    <form action="{{ route('authorization.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @php 
                            $date_now = Date('m/d/Y');                                                        
                            $date_end =date('m/d/Y',strtotime($date_now."+1 days"))
                        @endphp

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
                                    <input type="text" name="date_start" class="form-control" placeholder="mm/dd/yyyy" 
                                        id="datepicker_start" value="{{ $date_now }}" requeired>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input id="timepicker_start" name="time_start" type="text" class="form-control" 
                                        value="{{ date('H:i') }}" required>
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
                                    
                                    <input name="date_end" class="form-control"  placeholder="dd/mm/yyyy" id="datepicker_end" 
                                    value="{{$date_end}}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <input id="timepicker_end" name="time_end" class="form-control" placeholder="HH:MM" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="example-hf-email">
                                SAP Username
                            </label>
                            <div class="col-lg-4">
                                <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control select2" style="width: 70%;" name="sap_user" data-placeholder="" required>
                                        @foreach($sap_users as $r)
                                            <option value="{{ $r->id }}">{{ $r->username }} - {{ $r->type }}</option>
                                        @endforeach
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
                                            <i class="fa fa-suitcase" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select class="form-control select2" style="width: 40%;" name="type" data-placeholder="" required>
                                        <option value="Normal">Normal</option>
                                        <option value="Urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-3"> Assign to BPO</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-user" style="width:20px;"></i>
                                        </span>
                                    </div>
                                    <select name="assign_bpo" id="" class="form-control select2">
                                        @foreach($sap_assign_bpo as $bpo)
                                            <option value="{{$bpo->id}}">{{$bpo->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>        
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="example-hf-email">
                                Authorization
                            </label>
                            <div class="col-lg-8">
                                <table class="table mb-0" id="table_tcode">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Transaction Code</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!-- <td hidden><input type="text" name="auth_count" value="1" id="auth_count"  class="form-control" autocomplete="off" ></td> -->
                                            <td>
                                                <!-- <input type="text" name="auth_tcode_1"  class="form-control" placeholder="Transaction Code SAP" required> -->
                                                <input type="text" name="auth_tcode[]"  class="form-control" placeholder="Transaction Code SAP" required>
                                            </td>
                                            <td><input type="text" name="auth_desc[]"  class="form-control" placeholder="Description"></td>                                            
                                            <td class="text-center" hidden>
                                                <button type="button" id="btn_delete_auth" class="btn btn-danger">
                                                <i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-1">
                                <td class="text-center"><button type="button" class="btn btn-primary" id="btn_add_auth"><i class="fa fa-plus"></i></button></td>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-9 ml-auto">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-save">&nbsp;Save</span>
                                </button>
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
