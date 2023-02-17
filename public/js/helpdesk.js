$(function () {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var MASTER_DATA_NUMBER = 1;

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });

    $('#editRoles').on('show.bs.modal', function (e) {
        //e.preventDefault();
        var id = $(e.relatedTarget).data('id');
        var name = $(e.relatedTarget).data('name');
        var tmpPermissions = $(e.relatedTarget).data('permissions');

        if (($.trim(tmpPermissions).indexOf(",") !== -1)) {
            permissions = tmpPermissions.split(",");
        } else {
            permissions = tmpPermissions;
        }

        $("#idRoles").val(id);
        $("#name").val(name);
        $("#permissions").val(permissions).trigger("change");
    });

    $('#addMasterData').on('click', function (e) {
        e.preventDefault();
        /*var string = "{{ asset('backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.js') }}";
        alert(string);*/
        MASTER_DATA_NUMBER++;
        $(".master-data").append("<div class='form-group row master-data-row'><label class='col-md-3 col-form-label'></label>" +
            "<div class='col-md-2'>" +
            "<select class='show-tick' data-plugin='selectpicker' id='md_type_" + MASTER_DATA_NUMBER + "'>" +
            "<option value='BP Customer' class='show-tick'>BP Customer</option>" +
            "<option value='BP Vendor'>BP Vendor</option>" +
            "<option value='MM Material'>MM Material</option>" +
            "</select>" +
            "</div>" +
            "<div class='col-md-2'><input type='text' class='form-control Value' id='md_code_" + MASTER_DATA_NUMBER + "' placeholder='Code'" +
            "autocomplete='off' /></div><div class='col-md-4'><input type='text' class='form-control' id='md_description_" +
            MASTER_DATA_NUMBER + "' placeholder='Description' autocomplete='off' /></div><div class='col-md-1'><button type='button'" +
            "id='btnDeleteMasterData' class='btn btn-danger'><i class='icon wb-trash' aria-hidden='true'></i></button></div></div>");
        //$.getScript("/backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.js", function(result) {
        //    $("#md_type_" + MASTER_DATA_NUMBER).selectpicker('refresh')
        //});
        //$.getScript("/backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.css", function(result) {
        //$("#md_type_" + MASTER_DATA_NUMBER).addClass('show-tick');
        //$("#md_type_" + MASTER_DATA_NUMBER).attr('data-plugin','selectpicker');
        //$("#md_type_" + MASTER_DATA_NUMBER).data('plugin','selectpicker');
        //$("#md_type_" + MASTER_DATA_NUMBER).Selectpicker('getDefault');
        //$("#md_type_" + MASTER_DATA_NUMBER).selectpicker('render');
         
        $.getScript("/backend/topbar/assets/js/Plugin/bootstrap-select.js");
        $("#md_type_" + MASTER_DATA_NUMBER).selectpicker('render');
        //$.getScript("/backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.js");
        //$.getScript("/backend/topbar/assets/vendor/bootstrap-select/bootstrap-select.css");
        //});
        //$("#md_type_" + MASTER_DATA_NUMBER).selectpicker('refresh').addClass('show-tick');
        //$("#md_type_" + MASTER_DATA_NUMBER).addClass('show-tick').data('plugin','selectpicker');
        $("#md_total").val(MASTER_DATA_NUMBER);
    });

    $("#btnComment").on('click', function () {
        $('a[href="#tabActivity"]').tab('show');
    });

    $(document).on('click', '#btnDeleteMasterData', function (e) {
        e.preventDefault();
        $(this).closest('div.master-data-row').remove();
    });

    $("#helpdesk-submit").on('click', function (e) {
        /*$(".Value").off();
        $(".Value").blur(function (e) {*/
        e.preventDefault();
        var formData = new FormData($("#helpdesk-form")[0]);
        if (MASTER_DATA_NUMBER > 1) {
            for (var i = 2; i <= MASTER_DATA_NUMBER; i++) {
                formData.append('md_code_' + i, $("#md_code_" + i).val());
                formData.append('md_description_' + i, $("#md_description_" + i).val());
            }
        }
        formData.append('md_type', $("#md_type").val());
        formData.append('md_request_type', $("#md_request_type").val());

        $.ajax({
            type: "POST",
            url: "/helpdesk",
            datatype: 'JSON',
            processData: false,
            contentType: false,
            data: formData,
            /*{
                _token: CSRF_TOKEN,
                title: $("#title").val(),
                date_start: $("#date_start").val(),
                time_start: $("#time_start").val(),
                date_end: $("#date_end").val(),
                time_end: $("#time_end").val(),
                privilege: $("#privilege").val(),
                type: $("#type").val(),
                assign_to: $("#assign_to").val(),
                //attachment: new FormData($("#helpdesk-form")[0]),
                comment: $("#comment").val(),
                md_request_type: $("#md_request_type").val(),
            }, */
            success: function (response) {
                alert(response.data);
            }
        });
        //});
    });
})
