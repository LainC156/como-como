$(document).ready(function() {
    //let patient_id = {{ $patient->id }};
    let msg = '';
    let menu_id = '';
    let menu_name_validation = 1;
    let menu_description_validation = 1;
    let list_user_menus_route = $("#list_user_menus_route").val();
    console.log('url: ' + list_user_menus_route);
    /* set up to initialize popover */
    $('[data-toggle="popover"]').popover();
    /* csrf token to ajax requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /* menus from user */
    let menus_table = $("#menus_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: list_user_menus_route,
            type: 'GET',
            //dataSrc: '',
        },
        columns: [{
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false,
            },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            {
                data: 'kind_of_menu',
                name: 'kind_of_menu',
                'searchable': true,
                'orderable': true,
                render: function(data, type, full, meta) {
                    switch (full.kind_of_menu) {
                        case '1':
                            return $("#menu_type_1").val();
                            break;
                        case '2':
                            return $("#menu_type_2").val();
                            break;
                        case '3':
                            return $("#menu_type_3").val();
                        default:
                            return "-";
                            break;
                    }
                }
            },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ]
    });
    /* actions on selected row */
    $('#menus_table tbody').on('click', 'tr', function() {
        console.log('data: ' + JSON.stringify(menus_table.row(this).data()));
        let row_data = menus_table.row(this).data();
        menu_id = row_data.id;
        $("#menu_name").val(row_data.name);
        $("#menu_description").val(row_data.description);
        $("#editMenuModal").modal('show');
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            menus_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    /* validations to save menu */
    $("#menu_name").keyup(function() {
        let name = $("#menu_name").val();
        if (!name) {
            $("#name_required").show();
            $("#name_check").hide();
            menu_name_validation = 0;
            $("#save_menu_btn").attr('disabled', true);
        } else {
            $("#name_required").hide();
            $("#name_check").show();
            menu_name_validation = 1;
            if (menu_description_validation == 1) {
                $("#save_menu_btn").attr('disabled', false);
            }
        }
    });
    $("#menu_description").keyup(function() {
        let description = $("#menu_description").val();
        if (!description) {
            $("#description_required").show();
            $("#description_check").hide();
            menu_description_validation = 0;
            $("#save_menu_btn").attr('disabled', true);
        } else {
            $("#description_required").hide();
            $("#description_check").show();
            menu_description_validation = 1;
            if (menu_name_validation == 1) {
                $("#save_menu_btn").attr('disabled', false);
            }
        }
    });
    /* updating name and description from menu */
    $("#save_menu_btn").click(function() {
        let data = {
            menu_id: menu_id,
            menu_name: $("#menu_name").val(),
            menu_description: $("#menu_description").val()
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: $("#update_menu_route").val(),
            success: function(data) {
                msg = data.message;
                console.log('mensaje: ' + msg);
                showSuccessMessage(msg);
                $("#editMenuModal").modal('hide');
                menus_table.ajax.reload();
            },
            error: function(data) {
                msg = data.message;
                console.log('mensaje: ' + msg);
                $("#editMenuModal").modal('hide');
                showErrorMessage(msg);
            }

        })
    });
    /* reset save menu modal values */
    $("#editMenuModal").on('hidden.bs.modal', function(e) {
        $("#name_required").show();
        $("#name_check").hide();
        $("#description_required").show();
        $("#description_check").hide();
    });
    /* delete menu */
    $("#delete_menu").click(function() {
        console.log('delete menu: ' + menu_id);
        data = { menu_id: menu_id };
        $.ajax({
            data: data,
            dataType: 'json',
            type: 'POST',
            url: "{{ route('menu.delete') }}",
            success: function(data) {
                let msg = data.message;
                $("#alert_success").empty();
                $('#alert_success').append("<strong>{{ __('Listo') }}: </strong>" + msg);
                $("#alert_success").show();
                setTimeout(function() {
                    $("#alert_success").hide();
                }, 3000);
                $("#editMenuModal").modal('hide');
                menus_table.ajax.reload();
            },
            error: function(data) {
                msg = data.message;
                console.log('mensaje: ' + msg);
                $("#alert_error").empty();
                $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + msg);
                $("#alert_error").show();
                setTimeout(function() {
                    $("#alert_error").hide();
                }, 3000);
                menus_table.ajax.reload();
            }
        })
    });
    /* display menu content in new tab */
    $("#show_menu").click(function() {
        //let url = "/user/" + {{ $patient->id }} + "/menus/" + menu_id;
        console.log('url: ' + url);
        window.open(url, '_blank');
    });

    /* save menu if this menus belongs to another patient */
    $("#btn_save_menu").click(function() {
        $("#editMenuModal").modal('hide');

    });
});
