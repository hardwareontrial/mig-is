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
                    Form
                </div>
                <div class="card-body">
                        <form action="{{ route('helpdesk.update', $helpdesk->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
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
                                            name="title" value="{{ $helpdesk->title }}" placeholder="Masukkan judul topik" autocomplete="off" required readonly>
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
                                        <input type="text" name="date_end" class="form-control" autocomplete="off" placeholder="mm/dd/yyyy" value="{{ date('m/d/Y',strtotime($helpdesk->date_end)) }}"  required>
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
                                            <option value="Public" @if ($helpdesk->privilege == "Public") selected
                                                @endif>Public</option>
                                            <option value="Private" @if ($helpdesk->privilege == "Private") selected
                                                @endif>Private</option>
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
                                            <option value="Normal" @if ($helpdesk->type == "Normal") selected @endif>Normal</option>
                                            <option value="Urgent" @if ($helpdesk->type == "Urgent") selected @endif>Urgent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">
                                    Status
                                </label>
                                <div class="col-lg-4">
                                    <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-gear"></i>
                                            </span>
                                        </div>
                                        <select class="form-control select2" style="width: 40%;" name="status" data-placeholder=""
                                            required>
                                            <option value="In Process" @if ($helpdesk->status == "In Process") selected @endif>In Process</option>
                                            <option value="Pending" @if ($helpdesk->status == "Pending") selected @endif>Pending</option>
                                            <option value="Complete" @if ($helpdesk->status == 'Complete') selected @endif>Complete</option>
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
                                        <select class="select2 form-control" name="assign_to[]" style="width: 90%;" multiple="multiple" multiple autocomplete="off" data-placeholder="Pilih peserta ujian"
                                        required @if ($assign_all == 1 || (!empty($assign_users) && in_array(Auth::user()->id,$assign_users)) || Auth::user()->id == $helpdesk->creator_id || (!empty($assign_divisions_2) && in_array(Auth::user()->division_id,$assign_divisions_2))) {{ '' }} @else {{'readonly'}} @endif>
                                            <option value="0" @if ($assign_all == '1') selected @endif>Semua</option>
                                            <optgroup label="Berdasarkan Departemen">
                                                @foreach ($divisions as $r)
                                                <option value="d-{{ $r->id }}" @if (isset($assign_divisions) &&
                                                    in_array('d-'.$r->id,
                                                    $assign_divisions)) selected @endif >{{ $r->name }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Berdasarkan Nama">
                                                @foreach ($users as $r)
                                                <option value="{{ $r->id }}" @if (isset($assign_users) &&
                                                    in_array($r->id, $assign_users))
                                                    selected @endif >{{ $r->name }}</option>
                                                @endforeach
                                            </optgroup>
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
                            
                            <div class="form-group row">
                                <div class="col-lg-9 ml-auto">
                                    <button type="submit" class="btn btn-alt-primary">Simpan</button>
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
