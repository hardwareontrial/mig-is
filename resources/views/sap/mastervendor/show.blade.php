@extends('layouts.topbar.app')

@section('title','Show Helpdesk')

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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('helpdesk.index') }}">Helpdesk</a></li>
                        <li class="breadcrumb-item active">{{ $helpdesk->title }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ '['.$helpdesk->id.'] '.$helpdesk->title }}</h4>
                By. {{ $creator->name }}
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
                    <form action="{{ route('vendor.update', $helpdesk->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane active" id="form-1">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">
                                        Username
                                    </label>
                                    <div class="col-lg-3">
                                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" name class="form-control" autocomplete="off" value="{{ $sap_user->username }}" required readonly>
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
                                            <input type="text" name="date_start" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" value="{{ date('m/d/Y',strtotime($helpdesk->date_start)) }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-clock-o"></i>
                                                </span>
                                            </div>
                                            <input name="time_start" type="text" autocomplete="off" value="{{ date('H:i',strtotime($helpdesk->date_start)) }}" class="form-control" required readonly>
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
                                            <input id="datepicker_end" type="text" name="date_end" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" value="{{ date('m/d/Y',strtotime($helpdesk->date_end)) }}"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-clock-o"></i>
                                                </span>
                                            </div>
                                            <input id="timepicker_end" name="time_end" type="text" autocomplete="off" class="form-control" value="{{ date('H:i',strtotime($helpdesk->date_end)) }}" required>
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
                                                <option value="Normal" @if ($helpdesk->type == "Normal") selected @endif>Normal</option>
                                                <option value="Urgent" @if ($helpdesk->type == "Urgent") selected @endif>Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        Approval BPO
                                    </label>
                                    <div class="col-lg-4">
                                        @if (Auth::user()->id == $approval['bpo_id'])
                                            @if ($approval['bpo_approve'] == null)
                                                <a href="{{ route('vendor.bpo',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a href="{{ route('vendor.bpo',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            @elseif($approval['bpo_approve'] == '0')
                                                <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                                <a href="{{ route('vendor.cancel',['type' => 'BPO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                            @elseif($approval['bpo_approve'] == '1')
                                                <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['bpo_act_at'])) }}</button>
                                                <a href="{{ route('vendor.cancel',['type' => 'BPO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                            @endif
                                        @else
                                            @if($approval['bpo_approve'] == '0')
                                                <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                            @elseif($approval['bpo_approve'] == '1')
                                                <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['bpo_act_at'])) }}</button>
                                            @elseif($approval['bpo_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for approval </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        Approval FICO 
                                    </label>
                                    <div class="col-lg-4">
                                    @if (Auth::user()->id == $approval['fico_head_id'])
                                        @if ($approval['fico_head_approve'] == null)
                                            @if ($approval['bpo_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for BPO approval </button>
                                            @else
                                                <a href="{{ route('vendor.fico',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success"><i class="fa fa-check"></i></a>
                                                <a href="{{ route('vendor.fico',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                                            @endif
                                        @elseif($approval['fico_head_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                            <a href="{{ route('vendor.cancel',['type' => 'FICO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                        @elseif($approval['fico_head_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                            <a href="{{ route('vendor.cancel',['type' => 'FICO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                        @endif
                                    @else
                                        @if($approval['fico_head_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        @elseif($approval['fico_head_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        @elseif($approval['fico_head_approve'] == null)
                                            <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for approval </button>
                                        @endif
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        Approval Project Manager 
                                    </label>
                                    <div class="col-lg-4">
                                    @if(Auth::user()->id == $approval['proman_id'])
                                        @if($approval['proman_approve'] == null) 
                                            @if($approval['bpo_approve'] == null && $approval['fico_head_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled>
                                                    <i class="fa fa-gears"></i> 
                                                    Waiting for BPO & FICO Head approval 
                                                </button>
                                            @elseif($approval['bpo_approve'] != null && $approval['fico_head_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled>
                                                    <i class="fa fa-gears"></i> Waiting for FICO Head approval 
                                                </button>
                                            @else
                                                <a href="{{ route('vendor.proman',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" 
                                                    class="btn btn-success">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a href="{{ route('vendor.proman',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" 
                                                    class="btn btn-danger">
                                                    <i class="fa fa-ban"></i>
                                                </a>                                        
                                            @endif
                                        @elseif($approval['proman_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled>
                                                <i class="fa fa-ban"></i> 
                                                Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                            </button>
                                            <a href="{{ route('vendor.cancel',['type' => 'IT', 'approval_id' => $approval->id,
                                                'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        @elseif($approval['proman_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled>
                                                <i class="fa fa-check"></i> 
                                                Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                            </button>
                                            <a href="{{ route('vendor.cancel',['type' => 'proman', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" 
                                                class="btn btn-light">
                                                <i class="fa fa-close"></i>
                                            </a>
                                        @endif
                                    @else
                                        @if($approval['proman_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled>
                                                <i class="fa fa-ban"></i> 
                                                Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}
                                            </button>
                                        @elseif($approval['proman_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        @elseif($approval['proman_approve'] == null)
                                            <button type="button" class="btn btn-warning" disabled>
                                                <i class="fa fa-gears"></i> 
                                                Waiting for approval
                                            </button>
                                        @endif
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">
                                        Approval IT 
                                    </label>
                                    <div class="col-lg-4">
                                    @if (Auth::user()->id == $approval['it_id'])
                                        @if ($approval['it_approve'] == null)
                                            @if ($approval['bpo_approve'] == null && $approval['fico_head_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for BPO & FICO Head approval </button>
                                            @elseif ($approval['bpo_approve'] != null && $approval['fico_head_approve'] == null)
                                                <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for FICO Head approval </button>
                                            @else 
                                                <a href="{{ route('vendor.it',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success"><i class="fa fa-check"></i></a>
                                                <a href="{{ route('vendor.it',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                                            @endif
                                        @elseif($approval['it_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                            <a href="{{ route('vendor.cancel',['type' => 'IT', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                        @elseif($approval['it_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                            <a href="{{ route('vendor.cancel',['type' => 'IT', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                        @endif
                                    @else
                                        @if($approval['it_approve'] == '0')
                                            <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                        @elseif($approval['it_approve'] == '1')
                                            <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                        @elseif($approval['it_approve'] == null)
                                            <button type="button" class="btn btn-warning" disabled><i class="fa fa-gears"></i> Waiting for approval </button>
                                        @endif
                                    @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <button class="btn btn-info btn-sm next float-right" target="#form-2" role="tab" 
                                            data-toggle="tab">
                                            <span class="fa fa-arrow-right"></span> Next
                                        </button>
                                    </div>
                                </div>
                                <hr>                                                                                              
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
                                            <select class="form-control select2" name="inp_grouping" style="width:40%;">                                                
                                                @foreach($BpGrouping as $r)
                                                    <option value="{{$r['code']}}"
                                                        {{ ($r['code'] == $sap_vendor->grouping_id) ? "selected" : ""}}
                                                    >{{$r['desc']}}</option>                                                
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
                                                    <option value="{{$r->id}}"
                                                    {{($r->id == $sap_vendor->title_id) ? "selected" : "" }}
                                                    >{{ $r->title }}</option>
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
                                                class="form-control" name="inp_VenName"
                                                value="{{$sap_vendor->name}}" required>
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
                                                placeholder="Type your Partner Address">{{$sap_vendor->address}}</textarea>
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
                                                placeholder="Type Country of Partner" value="{{$sap_vendor->country}}">
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
                                                placeholder="Type City of Partner" value="{{$sap_vendor->city}}">
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
                                                placeholder="Type Postal Code of Partner" 
                                                value="{{$sap_vendor->postal_code}}">
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
                                                placeholder="Type No. Phone" value="{{$sap_vendor->phone}}">
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
                                                placeholder="Type No. Handphone" value="{{$sap_vendor->mobile_phone}}">
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
                                                placeholder="Type email of partner" value="{{$sap_vendor->email}}">
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
                                <hr>                            
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
                                                placeholder="Type Bank of Partner" value="{{$sap_vendor->bank_name}}">
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
                                                placeholder="Type Bank Account" value="{{$sap_vendor->bank_rek}}">
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
                                                placeholder="Type Account Name" value="{{$sap_vendor->bank_acct_name}}">                                    
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
                                                placeholder="Type Tax Number" value="{{$sap_vendor->tax_number}}">                                    
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
                                                placeholder="Type Tax Name" value="{{$sap_vendor->tax_name}}">
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
                                <hr>
                            </div>
                            <div class="tab-pane" id="form-4">
                                <div class="form-group row" id="inp-order-currenc">
                                    <label for="" class="col-lg-3">Order Currency</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-money" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_currency"
                                                placeholder="Type Order Currency" value="{{$sap_vendor->order_currency}}">                                    
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
                                                    <option value="{{$r['code']}}"
                                                    {{($r['code'] == $sap_vendor->top) ? "selected" : ""}}>{{$r['desc']}}</option>
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
                                <hr>                                
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
                                                    <option value="{{$r['GlAcc']}}"
                                                    {{ ($r['GlAcc'] == $sap_vendor->recon_acct_id) ? "selected":""}}>{{$r['desc']}}</option>
                                                @endforeach
                                            </select>                                  
                                        </div>
                                    </div>                                                                
                                </div>
                                <div class="form-group row" id="inp-wht">
                                    <label for="" class="col-lg-3">Witholding tax</label>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fa fa-percent" style="width:20px;"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="inp_wht"
                                                placeholder="Type Withholding tax" value="{{$sap_vendor->wht_id}}">                                    
                                        </div>
                                    </div>                                                                
                                </div>
                                <div class="row" id="btn-nav-form-5">                                
                                    <div class="col-md-10">
                                        <button class="btn btn-outline-info btn-sm previous float-right mb-0 mr-2" target="#form-4" role="tab" 
                                                data-toggle="tab">
                                            <span><i class="fa fa-arrow-left"></i> Previous</span>
                                        </button>                                                                        
                                    </div>
                                </div> 
                                <hr>                               
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="example-hf-email">
                                File Attachment
                            </label>
                            <div class="col-lg-9">
                                <div class="custom-file">
                                    <input type="file" name="attachment" class="filestyle" data-btnClass="btn-light">
                                </div>
                            </div>
                        </div> -->
                        @if ($assign_all == 1 || (!empty($assign_users) && in_array(Auth::user()->id,$assign_users)) 
                            || Auth::user()->id == $helpdesk->creator_id || (!empty($assign_divisions_2) && in_array(Auth::user()->division_id,$assign_divisions_2)))
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
            <div class="">
                <div class="timeline">
                    <article class="timeline-item alt">
                        <div class="text-right">
                            <div class="time-show first">
                                <a href="#" class="btn btn-custom w-lg">Activity</a>
                            </div>
                        </div>
                    </article>
                    @foreach ($activitys as $r)
                        @if ($r->user_id == Auth::user()->id)
                            <article class="timeline-item alt">
                                <div class="timeline-desk">
                                    <div class="panel">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-custom"><i class="mdi mdi-adjust"></i></span>
                                            <div class="user-img">
                                                <img src="@if (!empty($r->user->photo)) {{ url('storage/'.$r->user->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" width="50" class="rounded-circle img-fluid" alt="">
                                                <span class="ml-1 pro-user-name text-custom"><big>Anda</big></span> -
                                                <span class="timeline-date text-muted"><span>{{ $r->created_at->diffForHumans() }}</span>
                                            </div>
                                            <hr>
                                            <small class="float-right">{!! $r->title !!}</small>
                                            <br><br>
                                            @if (!empty($r->comment))
                                            <p>{!! $r->comment->content !!} </p>
                                            @endif
                                            
                                            @if (!empty($r->attachment))
                                                @foreach ($r->attachment as $y)
                                                <span class="fa fa-paperclip">&nbsp;<a href="{{ route('helpdesk.download', $y->id) }}">{{ $y->filename }} </a></span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @else
                            <article class="timeline-item ">
                                <div class="timeline-desk">
                                    <div class="panel">
                                        <div class="timeline-box">
                                            <span class="arrow"></span>
                                            <span class="timeline-icon bg-custom"><i class="mdi mdi-adjust"></i></span>
                                            <div class="user-img">
                                                <img src="@if (!empty($r->user->photo)) {{ url('storage/'.$r->user->photo) }} @else {{ asset('backend/assets/images/users/avatar-2.jpg') }} @endif" width="50" class="rounded-circle img-fluid" alt="">
                                                <span class="ml-1 pro-user-name text-custom"><big>{{ $r->user->name }}</big></span>
                                                <span class="timeline-date text-muted"><small>{{ $r->created_at->diffForHumans() }}</small></span>
                                            </div>
                                            <hr>
                                            <small class="float-right">{!! $r->title !!}</small>
                                            <br><br>
                                            @if (!empty($r->comment))
                                            <p>{!! $r->comment->content !!} </p>
                                            @endif

                                            @if (!empty($r->attachment))
                                                @foreach ($r->attachment as $y)
                                                <span class="fa fa-paperclip">&nbsp;<a href="{{ route('helpdesk.download', $y->id) }}">{{ $y->filename }} </a></span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
                <!-- end timeline -->
            </div>
        </div>
    </div>
                <!-- end row -->
</div>
@stop
