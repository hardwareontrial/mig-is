@extends('layouts.topbar.app')

@section('title','SAP Helpdesk')

@section('brand','SAP Auth Helpdesk')

@section('color','bg-cyan-600')

@section('script')
<script src="{{ asset('js/helpdesk.js') }}"></script>

<script>

    var auth_count = {{ $sap_auth->count() }};
    var array_auth = [{{ $sap_auth_key }}];

    function setArrayAuth(count) {
        array_auth.push(count);
    }

    $("#btn_add_auth").on('click', function(e) {
        e.preventDefault();
        auth_count++;
        $("#table_tcode > tbody:last-child").append("<tr>"+
                                            "<td><input type='text' name='auth_tcode_"+ auth_count +"' class='form-control' autocomplete='off' required></td>"+
                                            "<td><input type='text' name='auth_desc_"+ auth_count +"'  class='form-control' autocomplete='off' required></td>"+
                                            "<td class='text-center'><button type='button' data-count='"+ auth_count +"' class='btn btn-danger' id='btn_delete_auth'>"+
                                            "<i class='fa fa-trash'></i></button></td>"+
                                            "</tr>");
        array_auth.push(auth_count);
        $("#auth_count").val(array_auth);
    });

    $(document).on('click','#btn_delete_auth',function(e){
        e.preventDefault();
        var count = $(this).data("count");
        array_auth = jQuery.grep(array_auth, function(value) {
                return value != count;
            });

        $("#auth_count").val(array_auth);
        $(this).parent().parent('tr').remove();
    });

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

@php

@endphp

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
                <h4 class="page-title">{{$helpdesk->title }}</h4>
                By. {{ $creator->name }}
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
                            <button class="btn btn-outline-danger btnback"
                                onClick="window.location.href({{route('authorization.index')}});">
                                <i class="fa fa-arrow-left"></i> Back
                            </button>                        
                        </div>
                        <div class="col-md-9">
                            <h5 align="center">Show Request Authorization</h5>
                        </div>                            
                    </div>                                                        
                </div>
                <div class="card-body">
                        <form action="{{ route('authorization.update', $helpdesk->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
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
                                        <input type="text" class="form-control" autocomplete="off" value="{{ $sap_user->username }}" required readonly>
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
                                        <a href="{{ route('authorization.bpo',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success"><i class="fa fa-check"></i></a>
                                        <a href="{{ route('authorization.bpo',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger"><i class="fa fa-ban"></i></a>
                                    @elseif($approval['bpo_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'BPO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                    @elseif($approval['bpo_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['bpo_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'BPO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
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
                                            <button type="button" class="btn btn-warning" disabled>
                                                <i class="fa fa-gears"></i>
                                                Waiting for BPO approval 
                                            </button>
                                        @else
                                            <a href="{{ route('authorization.fico',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a href="{{ route('authorization.fico',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endif
                                    @elseif($approval['fico_head_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'FICO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                    @elseif($approval['fico_head_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'FICO', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                    @endif
                                @else
                                    @if($approval['fico_head_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}</button>
                                    @elseif($approval['fico_head_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled>
                                            <i class="fa fa-check"></i> 
                                            Approved at {{ date('d-M-Y H:i:s',strtotime($approval['fico_head_act_at'])) }}
                                        </button>
                                    @elseif($approval['fico_head_approve'] == null)
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
                                            <a href="{{ route('authorization.proman',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" 
                                                class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a href="{{ route('authorization.proman',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" 
                                                class="btn btn-danger">
                                                <i class="fa fa-ban"></i>
                                            </a>                                        
                                        @endif
                                    @elseif($approval['proman_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled>
                                            <i class="fa fa-ban"></i> 
                                            Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                        </button>
                                        <a href="{{ route('authorization.cancel',['type' => 'IT', 'approval_id' => $approval->id,
                                            'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    @elseif($approval['proman_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled>
                                            <i class="fa fa-check"></i> 
                                            Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                        </button>
                                        <a href="{{ route('authorization.cancel',['type' => 'proman', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" 
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
                                        @if (
                                            $approval['bpo_approve'] == null && 
                                            $approval['fico_head_approve'] == null &&
                                            $approval['proman_approve'] == null
                                        )
                                            <button type="button" class="btn btn-warning" disabled>
                                                <i class="fa fa-gears"></i> 
                                                Waiting for BPO, FICO Head & Project Manager approval 
                                            </button>
                                        @elseif (
                                            $approval['bpo_approve'] != null && 
                                            $approval['fico_head_approve'] != null &&
                                            $approval['proman_approve'] == null 
                                        )
                                            <button type="button" class="btn btn-warning" disabled>
                                                <i class="fa fa-gears"></i> 
                                                Waiting for Project Manager approval 
                                            </button>
                                        @else 
                                            <a href="{{ route('authorization.it',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 1]) }}" class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a href="{{ route('authorization.it',['approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id, 'status' => 0]) }}" class="btn btn-danger">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @endif
                                    @elseif($approval['it_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled><i class="fa fa-ban"></i> Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'IT', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                    @elseif($approval['it_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}</button>
                                        <a href="{{ route('authorization.cancel',['type' => 'IT', 'approval_id' => $approval->id,'helpdesk_id' => $helpdesk->id]) }}" class="btn btn-light"><i class="fa fa-close"></i></a>
                                    @endif
                                @else
                                    @if($approval['it_approve'] == '0')
                                        <button type="button" class="btn btn-danger" disabled>
                                            <i class="fa fa-ban"></i> 
                                            Declined at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                        </button>
                                    @elseif($approval['it_approve'] == '1')
                                        <button type="button" class="btn btn-success" disabled>
                                            <i class="fa fa-check"></i> 
                                            Approved at {{ date('d-M-Y H:i:s',strtotime($approval['it_act_at'])) }}
                                        </button>
                                    @elseif($approval['it_approve'] == null)
                                        <button type="button" class="btn btn-warning" disabled>
                                            <i class="fa fa-gears"></i> Waiting for approval 
                                        </button>
                                    @endif
                                @endif
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
                                                <td hidden>
                                                    <input type="text" name="auth_count" value="{!! $sap_auth_key !!}" id="auth_count"  class="form-control" autocomplete="off" >
                                                </td>
                                            </tr>
                                            <?php $count = 1; ?>

                                            @foreach($sap_auth as $r)
                                                @if ($count == 1)
                                                <tr>
                                                    <td hidden>
                                                        <input type="text" name="auth_id_{{ $count }}" value="{{ $r->id }}" class="form-control" autocomplete="off" required>
                                                    </td>       
                                                    <td>
                                                        <input type="text" name="auth_tcode_{{ $count }}" value="{{ $r->tcode }}" 
                                                            class="form-control" autocomplete="off" 
                                                            @if ($approval['fico_head_approve'] != null || $approval['bpo_approve'] != null) 
                                                                readonly 
                                                            @endif>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="auth_desc_{{ $count }}" value="{{ $r->description }}"  
                                                            class="form-control" autocomplete="off" 
                                                            @if ($approval['fico_head_approve'] != null || $approval['bpo_approve'] != null) 
                                                                readonly 
                                                            @endif>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" id="btn_delete_auth"  class="btn btn-danger" hidden><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td hidden><input type="hidden" name="auth_id_{{ $count }}" value="{{ $r->id }}" class="form-control" autocomplete="off" required></td>
                                                    <td><input type="text" name="auth_tcode_{{ $count }}" value="{{ $r->tcode }}" class="form-control" autocomplete="off" required @if ($approval['fico_head_approve'] != null || $approval['bpo_approve'] != null) readonly @endif></td>
                                                    <td><input type="text" name="auth_desc_{{ $count }}" value="{{ $r->description }}"  class="form-control" autocomplete="off" required @if ($approval['fico_head_approve'] != null || $approval['bpo_approve'] != null) readonly @endif></td>
                                                    @if ($approval['fico_head_approve'] == null && $approval['bpo_approve'] == null)
                                                    <td class="text-center">
                                                        <button type="button" id="btn_delete_auth" data-count="{{ $count }}"  class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endif
                                            <?php $count++; ?>
                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if ($approval['fico_head_approve'] == null && $approval['bpo_approve'] == null)
                                <div class="col-lg-1">
                                    <td class="text-center"><button type="button" class="btn btn-primary" id="btn_add_auth"><i class="fa fa-plus"></i></button></td>
                                </div>
                                @endif
                            </div>
                            @if ($assign_all == 1 || (!empty($assign_users) && in_array(Auth::user()->id,$assign_users)) 
                                                || Auth::user()->id == $helpdesk->creator_id || 
                                                (!empty($assign_divisions_2) && in_array(Auth::user()->division_id,$assign_divisions_2)))
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i>&nbsp;
                                        <span>Save</span>
                                    </button>
                                </div>
                            </div>
                            @endif
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
