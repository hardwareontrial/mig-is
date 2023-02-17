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
                    <a href="{{ route('roles.index') }}" class="btn btn-primary waves-light waves-effect">Role</a>
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-primary waves-light waves-effect">Permission</a>
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
                        <a href="{{ route('roles.index') }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </form>
                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-icon waves-effect waves-light btn-primary float-right" data-toggle="modal" data-target="#md_new_role"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" >Role Name</th>
                        <th class="text-center" style="width: 40%;">Permission</th>
                        <th class="text-center" style="width: 15;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @forelse ($roles as $r)
                    <tr>
                        <td id="name_td{{ $no }}" align="center">{{ $r->name }}</td>
                        <td id="prm_td{{ $no }}" align="center">{{ $r->permissions()->pluck('name')->implode(' | ') }}</td>
                        <td align="center" style="vertical-align: middle;">
                            <button type="button" id="btn_edit{{ $r->id }}" class="btn btn-icon btn-warning btn-circle edit-role"
                            data-target="#md_edit_role"
                            data-toggle="modal"
                            data-id="{{ $r->id }}"
                            data-name-td="name_td{{ $no }}"
                            data-prm-td="prm_td{{ $no }}"
                            data-name="{{ $r->name }}"
                            data-permissions="{{ $r->permissions()->pluck('id')->implode(',') }}" >
                            <i class="fa fa-edit" aria-hidden="true"></i></button>
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
            {{ $roles->links() }}
        </div>
    </div>

</div>
<!-- END Page Content -->
@stop

@section('modal')
<div class="modal fade" id="md_new_role" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title">New Roles</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="roles_name" name="roles_name" placeholder="Role Name"
                                    autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-chain"></i>
                                        </span>
                                    </div>
                                    <select class="select2 form-control" multiple="multiple"  name="permissions[]" style="width: 90%;"
                                        multiple required>
                                        @foreach ($permissions as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_edit_roles_saves" class="btn btn-alt-success">
                    <i class="fa fa-check"></i> Save
                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_edit_role" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="modal-header bg-primary">
                    <h3 class="modal-title text-white">Edit Roles</h3>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="roles-edit-form">
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
                                    <input type="hidden" class="form-control" id="roles_id" name="roles_id"
                                    autocomplete="off" required readonly>
                                    <input type="text" class="form-control" id="roles_name_edit" name="roles_name" placeholder="Role Name"
                                    autocomplete="off" required>
                                    <input type="hidden" class="form-control" id="name_td" name="name_td" autocomplete="off" required>
                                    <input type="hidden" class="form-control" id="prm_td" name="prm_td" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-chain"></i>
                                        </span>
                                    </div>
                                    <select class="select2 form-control" id="permissions" multiple="multiple"  name="permissions[]" style="width: 90%;"
                                        multiple required>
                                        @foreach ($permissions as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
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
        $('#md_edit_role').on('show.bs.modal', function (e) {
            var permissions = "";
            var id = $(e.relatedTarget).data('id');
            var name = $(e.relatedTarget).data('name');
            var tmpPermissions = $(e.relatedTarget).data('permissions');
            var nameTd = $(e.relatedTarget).data('name-td');
            var prmTd = $(e.relatedTarget).data('prm-td');

            if ($.trim(tmpPermissions).indexOf(",") !== -1) {
                permissions = tmpPermissions.split(",");
            } else {
                permissions = tmpPermissions;
            }

            $("#roles_id").val(id);
            $("#roles_name_edit").val(name);
            $("#permissions").val(permissions).trigger("change");
            $("#name_td").val(nameTd);
            $("#prm_td").val(prmTd);
            $('#roles-edit-form').attr('action', "{{ url('/') }}/uac/roles/"+id);
        });

        $('#btn_edit_roles_save').on('click', function (e) {
            e.preventDefault();
            var id = $("#roles_id").val();
            var rolesName = $("#roles_name").val();
            var prmId = $("#permissions").val();
            $.ajax({
                type: "PUT",
                url: "roles/" + id,
                datatype: 'JSON',
                data: {
                    _token: CSRF_TOKEN,
                    roles_name: rolesName,
                    permissions: prmId,
                },
                success: function (response) {
                    if (response.success) {
                        $("#md_edit_role").modal('toggle');
                        location.reload();
                    } else {
                        showNotify('danger',response.msg);
                    }
                },
                /*error: function (XMLHttpRequest) {
                    toastr.error('Something Went Wrong !');
                }*/
            });


        });
    </script>
@stop
