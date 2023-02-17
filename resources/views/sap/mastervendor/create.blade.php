@extends('layouts.topbar.app')

@section('title','Create Helpdesk')

@section('brand','Helpdesk')

@section('color','bg-cyan-600')

@section('script')
<script src="{{ asset('js/helpdesk.js') }}"></script>
<script>
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

    $('.next').click(function () {
        $('.nav-tabs > .nav-item > .active').parent().next('li').find('a').trigger('click');
    });
    $('.previous').click(function () {
        $('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
    });
    
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
                <h4 class="page-title">Create New Master Vendor</h4>
            </div>
        </div>
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs tabs-bordered nav-justified">
                                <li class="nav-item">
                                    <a href="#form-1" data-toggle="tab" aria-expanded="true" 
                                        class="nav-link active">
                                        <i class="fa fa-file mr-2"></i> 1. Helpdesk Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#form-2" data-toggle="tab" aria-expanded="true" 
                                        class="nav-link">
                                        <i class="fa fa-file mr-2"></i> 2. General Information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#form-3" data-toggle="tab" aria-expanded="true" 
                                        class="nav-link">
                                        <i class="fa fa-file mr-2"></i> 3. Tax & Payment
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#form-4" data-toggle="tab" aria-expanded="true" 
                                        class="nav-link">
                                        <i class="fa fa-file mr-2"></i> 4. Vendor
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#form-5" data-toggle="tab" aria-expanded="true" 
                                        class="nav-link">
                                        <i class="fa fa-file mr-2"></i> 5. FI Vendor
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>                    
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf                                                          
                        <div class="tab-content">
                            <div class="tab-pane active" id="form-1">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                                        SAP Username
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select class="form-control select2" style="width: 70%;" 
                                                name="sap_user" data-placeholder="" required>
                                                @foreach($sap_users as $r)
                                                    <option value="{{ $r->id }}">{{ $r->username }} - {{ $r->type }}</option>
                                                @endforeach
                                            </select>
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
                                            <input type="text" name="date_start" class="form-control" autocomplete="off" 
                                                placeholder="mm/dd/yyyy" id="datepicker_start" value="{{ date('m/d/Y') }}" required>                                            
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-3">
                                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-clock-o"  style="width:20px;"></i>
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
                                                    <i class="fa fa-clock-o"  style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input id="timepicker_end" name="time_end" type="text" autocomplete="off" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                                        Condition Type
                                    </label>
                                    <div class="col-lg-1 ml-4 mb-0">
                                        <input type="radio" class="form-check-input" name="type" value="1" checked>Normal                                                                        
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="radio" class="form-check-input" name="type" value="2">Urgent
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="" class="col-lg-3">Assign to Purchasing</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-group" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select class="form-control select2" 
                                                data-placeholder="Select next level assigner" name="assign_purc">
                                                @foreach($assign_purc as $r)
                                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                            
                                </div>-->
                                <div class="form-group row">
                                    <label  class="col-lg-3">Assign to BPO</label>
                                    <div class="col-lg-6">
                                        <div class="input-group mb-2 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-group" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select name="assign_bpo" class="form-control select2" 
                                                style="width:40%; data-placeholder="select assign to">
                                                @foreach($sap_assign_bpo as $r)
                                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                            
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="example-hf-email">
                                        File Attachment
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="custom-file">
                                            <input type="file" name="attachment" class="filestyle" data-btnClass="btn-light">
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-10">
                                        <button class="btn btn-info btn-sm next float-right" target="#form-2" role="tab" 
                                            data-toggle="tab">
                                            <span class="fa fa-arrow-right"></span> Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="form-2">                            
                                <div class="form-group row" id="inp-grouping">
                                    <label for="label-grouping" class="col-md-3">
                                        Grouping Partner
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-tags" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select class="form-control select2" style="width:40%;" name="groupingBP">                                                
                                                @foreach($BpGrouping as $r)
                                                    <option value="{{$r['code']}}">{{$r['desc']}}</option>                                                
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-title">
                                    <label for="" class="col-lg-3">
                                        Title <span style="color:red;">*</span>
                                    </label>                                    
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-tag" style="width:20px;"></i>
                                                </span>        
                                            </div>
                                            <select class="form-control select2" style="width: 40%;" name="inp_title">
                                                @foreach ($sap_title as $r)
                                                    <option value="{{$r->id}}">{{ $r->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-name">
                                    <label for="" class="col-lg-3">
                                        Nama <span style="color:red;">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-university" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" placeholder="Nama Partner" 
                                                class="form-control" name="inp_VenName" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-address">
                                    <label for="" class="col-lg-3">
                                        Address
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-marker" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <textarea type="text" class="form-control" name="inp_address" 
                                                placeholder="Type your Partner Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-country">
                                    <label for="" class="col-lg-3">Country</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-globe" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_country"
                                                placeholder="Type Country of Partner">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-city">
                                    <label for="" class="col-lg-3">City / Postal Code</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-o" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_city"
                                                placeholder="Type City of Partner">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-pin" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inpt_postcode"
                                                placeholder="Type Postal Code of Partner">
                                        </div>
                                    </div>
                                </div>                               
                                <div class="form-group row" id="inp-phone">
                                    <label for="" class="col-lg-3">
                                        Telephone / Mobile
                                    </label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-phone" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="inp_phone" class="form-control"
                                                placeholder="Type No. Phone ">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-mobile-phone" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="inp_handphone" class="form-control"
                                                placeholder="Type No. Handphone ">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="inp-email">
                                    <label for="" class="col-lg-3">
                                        Email
                                    </label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="inp_email" class="form-control"
                                                placeholder="Type email of partner">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row" id="btn-nav-form-2">                                                                    
                                    <div class="col-md-10">
                                        <button class="btn btn-info btn-sm next float-right" target="#form-2" role="tab" 
                                                data-toggle="tab">
                                            <span class="fa fa-arrow-right"></span> Next
                                        </button>
                                        <button class="btn btn-outline-info btn-sm previous float-right mb-0 mr-2" target="#form-1" role="tab" 
                                                data-toggle="tab">
                                            <span class="fa fa-arrow-left"></span> Previous
                                        </button>                                                                        
                                    </div>
                                </div>                                
                            </div>
                            <div class="tab-pane" id="form-3">
                                <div class="form-group row" id="inp-bank">
                                    <label for="" class="col-lg-3">Bank</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-university" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_bank"
                                                placeholder="Type Bank of Partner">
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group row" id="inp-bank-account">
                                    <label for="" class="col-lg-3">Bank Account</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-credit-card" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="inp_rek" class="form-control"
                                                placeholder="Type Bank Account">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group row" id="ip-account-name">
                                    <label for="" class="col-lg-3">Account Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user-o" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_AccName"
                                                placeholder="Type Account Name">                                    
                                        </div>
                                    </div>                                                                    
                                </div>
                                <div class="form-group row" id="ip-tax-number">
                                    <label for="" class="col-lg-3">Tax Number</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-id-card-o" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_taxNumber"
                                                placeholder="Type Tax Number">                                    
                                        </div>
                                    </div>                                                                    
                                </div>
                                <div class="form-group row" id="ip-tax-name">
                                    <label for="" class="col-lg-3">Tax Name</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_taxName"
                                                placeholder="Type Tax Name">                                    
                                        </div>
                                    </div>                                                                    
                                </div>
                                <div class="row" id="btn-nav-form-3">                                
                                    <div class="col-md-10">
                                        <button class="btn btn-info btn-sm next float-right" target="#form-3" role="tab" 
                                                data-toggle="tab">
                                            <span class="fa fa-arrow-right"></span> Next
                                        </button>
                                        <button class="btn btn-outline-info btn-sm previous float-right mb-0 mr-2" target="#form-2" role="tab" 
                                                data-toggle="tab">
                                            <span class="fa fa-arrow-left"></span> Previous
                                        </button>                                                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="form-4">
                                <div class="form-group row" id="inp-order-currenc">
                                    <label for="" class="col-lg-3">Order Currency</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-money" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_currency"
                                                placeholder="Type Order Currency">                                    
                                        </div>
                                    </div>                                                                
                                </div>
                                <div class="form-group row" id="inp-top">
                                    <label for="" class="col-lg-3">Payment Term</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-hourglass-start" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select name="inp_top" class="form-control select2" style="width:40%;">
                                                @foreach($BpTop as $r)
                                                    <option value="{{$r['code']}}">{{$r['desc']}}</option>
                                                @endforeach
                                            </select>                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="btn-nav-form-4">                                
                                    <div class="col-md-10">
                                        <button class="btn btn-info btn-sm next float-right" target="#form-4" role="tab" 
                                                data-toggle="tab">
                                            <span class="fa fa-arrow-right"></span> Next
                                        </button>
                                        <button class="btn btn-outline-info btn-sm previous float-right mb-0 mr-2" target="#form-3" role="tab" 
                                                data-toggle="tab">
                                            <span><i class="fa fa-arrow-left"></i> Previous</span>
                                        </button>                                                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="form-5">
                                <div class="form-group row" id="inp-reconc-account">
                                    <label for="" class="col-lg-3">Reconciliation Account</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-random" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <select name="inp_reconciliation" class="form-control select2" style="width:60%">
                                                @foreach($BpReconcAcct as $r)
                                                    <option value="{{$r['GlAcc']}}">{{$r['desc']}}</option>
                                                @endforeach
                                            </select>                                  
                                        </div>
                                    </div>                                                                
                                </div>
                                <div class="form-group row" id="inp-wht">
                                    <label for="" class="col-lg-3">Witholding tax</label>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-percent" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_wht"
                                                placeholder="Type Withholding tax">                                    
                                        </div>
                                    </div>                                                                
                                </div>
                                <div class="row" id="btn-nav-form-5">                                
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-warning btn-sm float-right">                                            
                                            <span class="fa fa-save"></span> Save
                                        </button>
                                        <button class="btn btn-outline-info btn-sm previous float-right mb-0 mr-2" target="#form-4" role="tab" 
                                                data-toggle="tab">
                                            <span><i class="fa fa-arrow-left"></i> Previous</span>
                                        </button>                                                                        
                                    </div>
                                </div>
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
@section('script')
    
@endsection
@stop
