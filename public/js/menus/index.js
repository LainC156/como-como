jQuery(function () {
    //let patient_id = {{ $patient->id }};
    let msg = '';
    let menu_id = '';
    let name
    let description
    const list_user_menus_route = $("#list_user_menus_route").val();
    /* set up to initialize popover */
    $('[data-toggle="popover"]').popover();
    /* csrf token to ajax requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /* menus from user */
    const menus_table = $("#menus_table").DataTable({
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
        { data: 'name', name: 'name' },
        { data: 'description', name: 'description' },
        {
            data: 'kind_of_menu',
            name: 'kind_of_menu',
            'searchable': true,
            'orderable': true,
            render: function (data, type, full, meta) {
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
    $("#menus_table tbody").on("click", "tr", function () {
        console.log('modal abierto');
        let row_data = menus_table.row(this).data();
        console.log('row_data: ', row_data);
        menu_id = row_data.id;
        console.log('menu_id: ', menu_id);
        $("#menu_name").val(row_data.name);
        $("#menu_name_del").text(row_data.name);
        $("#menu_name_show").text(row_data.name);
        $("#menu_description").val(row_data.description);
        $("#menu_description_del").text(row_data.description);
        $("#menu_description_show").text(row_data.description);
        /* selected class */
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            menus_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    /* validations to save menu */
    $("#menu_name").on('input', function () {
        name = this.value
        name ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    });
    $("#menu_description").on('input', function () {
        description = this.value
        description ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    });
    /* updating name and description from menu */
    $("#save_menu_btn").on('click', function () {
        name = $("#menu_name").val()
        description = $("#menu_description").val()
        if (!name) {
            $("#menu_name").trigger('focus').removeClass('is-valid').addClass('is-invalid')
            return;
        }
        if (!description) {
            $("#menu_description").trigger('focus').removeClass('is-valid').addClass('is-invalid')
            return;
        }
        let data = {
            menu_id: menu_id,
            menu_name: name,
            menu_description: description
        };
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: $("#update_menu_route").val(),
            success: function (data) {
                data.status === 'success' ? showSuccessMessage(data.message) : showErrorMessage(data.message)
                $("#saveMenuModal").modal('hide');
                menus_table.ajax.reload();
            },
            error: function (data) {
                msg = data.message;
                console.log('mensaje: ' + msg);
                $("#saveMenuModal").modal('hide');
                showErrorMessage(data.responseJSON.message);
                menus_table.ajax.reload()
            }
        })
    });
    /* delete menu */
    $("#delete_menu").on('click', function () {
        console.log('delete menu: ' + menu_id);
        data = { menu_id: menu_id };
        $.ajax({
            data: data,
            dataType: 'json',
            type: 'POST',
            url: "{{ route('menu.delete') }}",
            success: function (data) {
                if (data.status === 'success') {
                    $("#alert_success").empty();
                    $('#alert_success').append("<strong>{{ __('Listo') }}: </strong>" + data.message);
                    $("#alert_success").show();
                    setTimeout(function () {
                        $("#alert_success").hide()
                    }, 10000)
                } else {
                    $("#alert_error").empty();
                    $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + data.message);
                    $("#alert_error").show();
                    setTimeout(function () {
                        $("#alert_error").hide();
                    }, 10000);
                }
                $("#editMenuModal").modal('hide');
                menus_table.ajax.reload();
            },
            error: function (data) {
                $("#alert_error").empty();
                $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + data.responseJSON.message);
                $("#alert_error").show();
                setTimeout(function () {
                    $("#alert_error").hide();
                }, 10000);
                menus_table.ajax.reload();
            }
        })
    });
    /* display menu content in new tab */
    $("#show_menu_btn").on('click', function () {
        const url = "/menu/" + menu_id + "/show";
        console.log('url: ' + url);
        window.open(url, '_blank');
    });
    /* delete menu */
    $("#delete_menu_btn").on('click', function () {
        $.ajax({
            data: { menu_id },
            dataType: 'json',
            type: 'POST',
            url: $("#delete_menu_route").val(),
            success: function (data) {
                $("#deleteMenuModal").modal('hide');
                data.status === 'success' ? showSuccessMessage(data.message) : showErrorMessage(data.message)
                menus_table.ajax.reload();
            },
            error: function (data) {
                $("#deleteMenuModal").modal('hide');
                showErrorMessage(data.responseJSON.message);
            }
        });
    });
});