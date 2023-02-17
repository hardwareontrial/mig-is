$(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    toastr.options.positionClass = 'toast-bottom-full-width';

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $("#test").on('click', function(e){
        alert("aaaa");
    });

    $('#editRoles').on('show.bs.modal', function (e) {
        //e.preventDefault();
        var id = $(e.relatedTarget).data('id');
        var name = $(e.relatedTarget).data('name');
        var tmpPermissions = $(e.relatedTarget).data('permissions');
        alert(id);
        if (($.trim(tmpPermissions).indexOf(",") !== -1)) {
            permissions = tmpPermissions.split(",");
        } else {
            permissions = tmpPermissions;
        }

        $("#idRoles").val(id);
        $("#name").val(name);
        $("#permissions").val(permissions).trigger("change");
    });

    $('#btnEditRolesSave').on('click', function () {
        var l = Ladda.create(this);
        l.start();
        $.ajax({
            type: "PUT",
            url: "roles/" + $("#idRoles").val(),
            datatype: 'JSON',
            data: {
                _token: CSRF_TOKEN,
                name: $("#name").val(),
                permissions: $("#permissions").val(),
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.msg);
                    l.stop();
                } else {
                    toastr.error(response.msg);
                    l.stop();
                }
            },
            /*error: function (XMLHttpRequest) {
                toastr.error('Something Went Wrong !');
            }*/
        });


    });
})
