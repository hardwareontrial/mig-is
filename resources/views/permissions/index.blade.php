@extends('layouts.topbar.app')

@section('title','Manage User')

@section('brand','Roles User')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <div class="row m-b-10">
                <div class="col-sm-12">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-primary waves-light waves-effect">User</a>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-primary waves-light waves-effect">Role</a>
                    <a href="{{ route('permissions.index') }}" class="btn btn-primary waves-light waves-effect">Permission</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <form class="form-inline" action="{{ url()->current() }}" >
                        <div class="input-group mb-2 mr-sm-3 mb-sm-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-wpforms"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" name="keyword" value="@if (!empty($keyword)) {{ $keyword }} @endif"
                                placeholder="Search..." autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mr-sm-2 mb-sm-0"><i class="fa fa-search"></i></button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </form>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-icon waves-effect waves-light btn-primary float-right" data-toggle="modal" data-target="#md_new_prm"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
        <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center">Permission Name</th>
                        <th class="text-center" style="width: 15;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @forelse ($permissions as $r)
                    <tr>
                        <td id="name_td{{ $no }}" align="center">{{ $r->name }}</td>
                        <td align="center" style="vertical-align: middle;">
                            <button type="button" data-id="{{ $r->id }}" data-name="{{ $r->name }}"  class="btn btn-icon btn-warning btn-circle edit-role" data-target="#md_edit_prm" data-toggle="modal"><i class="fa fa-edit" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <?php $no++; ?>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Data is empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $permissions->links() }}
        </div>
    </div>

</div>
<!-- END Page Content -->
@stop

@section('modal')

<div class="modal fade" id="md_edit_prm" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title">Edit Permission</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="prm-form">
                    @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="hidden" class="form-control" id="prm_id" name="prm_id"
                                    autocomplete="off" required readonly>
                                    <input type="text" class="form-control" id="prm_name" name="prm_name" placeholder="Permission Name"
                                    autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_new_prm" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="modal-header bg-primary text-white">
                    <h3 class="block-title">New Permission</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Permission Name"
                                    autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });

        $('#md_edit_prm').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');

            $("#prm_id").val(id);
            $("#prm_name").val(name);
            $('#prm-form').attr('action', window.location.origin+"/uac/permissions/"+id);
        });
    </script>
@stop
