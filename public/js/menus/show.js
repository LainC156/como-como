$(document).ready(function() {
    let menu_id = $("#menu_id").val();
    let patient_id = 0;
    let owner_id = $("#owner_id").val();
    let menu_name_validation = 0;
    let menu_description_validation = 0;
    let patient_select_validation = 0;
    let role_id = $("#role_id").val();
    console.log('role_id: ', role_id);
    console.log('ruta: ', $("#list_menu_route").val());
    /* csrf token to ajax requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* show menu components in DataTables */
    let menu_table = $("#menu_table").DataTable({
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        processing: true,
        serverSide: true,
        ajax: {
            url: $("#list_menu_route").val(),
            type: 'GET',
        },
        columns: [{
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false,
            },
            {
                data: 'kind_of_food',
                name: 'kind_of_food',
                render: function(data, type, full, action) {
                    switch (full.kind_of_food) {
                        case 0:
                            return $("#time_0").val();
                            break;
                        case '1':
                            return $("#time_1").val();
                            break;
                        case '2':
                            return $("#time_2").val();
                            break;
                        case '3':
                            return $("#time_3").val();
                            break;
                        case '4':
                            return $("#time_4").val();
                            break;
                    }
                },
                searchable: true,
                orderable: true,
            },
            { data: 'food_weight', name: 'food_weight' },
            { data: 'name', name: 'name' },
            { data: 'kcal', name: 'kcal' },
            { data: 'kj', name: 'kj' },
            { data: 'water', name: 'water' },
            { data: 'dietary_fiber', name: 'dietary_fiber' },
            { data: 'carbohydrates', name: 'carbohydrates' },
            { data: 'proteins', name: 'proteins' },
            { data: 'total_lipids', name: 'total_lipids' },
            { data: 'saturated_lipids', name: 'saturated_lipids' },
            { data: 'monosaturated_lipids', name: 'monosaturated_lipids' },
            { data: 'polysaturated_lipids', name: 'polysaturated_lipids' },
            { data: 'cholesterol', name: 'cholesterol' },
            { data: 'calcium', name: 'calcium' },
            { data: 'phosphorus', name: 'phosphorus' },
            { data: 'iron', name: 'iron' },
            { data: 'magnesium', name: 'magnesium' },
            { data: 'sodium', name: 'sodium' },
            { data: 'potassium', name: 'potassium' },
            { data: 'zinc', name: 'zinc' },
            { data: 'vitamin_a', name: 'vitamin_a' },
            { data: 'ascorbic_acid', name: 'ascorbic_acid' },
            { data: 'thiamin', name: 'thiamin' },
            { data: 'rivoflavin', name: 'rivoflavin' },
            { data: 'niacin', name: 'niacin' },
            { data: 'pyridoxine', name: 'pyridoxine' },
            { data: 'folic_acid', name: 'folic_acid' },
            { data: 'cobalamin', name: 'cobalamin' },
            { data: 'edible_percentage', name: 'edible_percentage' },
        ]
    });
    /* getting data when row menu table is clicked */
    $('#menu_table tbody').on('click', 'tr', 'a', function() {
        console.log('data: ' + JSON.stringify(menu_table.row(this).data()));
        let row_data = menu_table.row(this).data();
        console.log('name: ' + row_data.name);
        component_id = row_data.id;
        $("#menuComponentNameEdited").val(row_data.name);
        $("#menuComponentFoodWeightEdited").val(row_data.food_weight);
        $("#menuComponentKindOfFoodEdited").val(row_data.kind_of_food);
        $("#editMenuComponentModal").modal('show');
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
            if (role_id == 2) {
                if (menu_description_validation == 1 && patient_select_validation == 1) {
                    $("#save_menu_btn").attr('disabled', false);
                }
            } else if (role_id == 3) {
                if (menu_name_validation && menu_description_validation) {
                    $("#save_menu_btn").attr('disabled', false);
                }
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
            if (role_id == 2) {
                if (menu_name_validation == 1 && patient_select_validation == 1) {
                    $("#save_menu_btn").attr('disabled', false);
                }
            } else if (role_id == 3) {
                if (menu_name_validation && menu_description_validation) {
                    $("#save_menu_btn").attr('disabled', false);
                }
            }
        }
    });
    /* only for nutritionist */
    if (role_id == 2) {
        $("#patient_select").change(function() {
            console.log('id: ', $("#patient_select :selected").val());
            patient_id = $("#patient_select :selected").val();
            patient_select_validation = 1;
            $("#select_required").hide();
            $("#select_check").show();
            if (menu_name_validation == 1 && menu_description_validation == 1) {
                $("#save_menu_btn").attr('disabled', false);
            } else {
                $("#save_menu_btn").attr('disabled', true);
            }
        });
    }
    /* button to save menu in certain profile */
    $("#save_menu_btn").click(function() {
        var data = {
            menu_id: menu_id,
            name: $("#menu_name").val(),
            description: $("#menu_description").val(),
            patient_id: patient_id,
            owner_id: owner_id,
            kind_of: 2
        };

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: $("#save_menu_route").val(),
            data: data,
            success: function(data) {
                console.log('success: ' + data.message);
                $("#saveMenuModal").modal('hide');
                showSuccessMessage(data.message);
            },
            error: function(data) {
                console.log('errror: ' + data.message);
                $("#saveMenuModal").modal('hide');
                showErrorMessage(data.message);
            }
        });

    });

    /* update menu component button */
    $("#update_component_btn").on('click', function() {
        let food_amount = $("#menuComponentFoodWeightEdited").val();
        let food_time_id = $("#menuComponentKindOfFoodEdited :selected").val();
        console.log('component_id: ' + component_id);
        console.log('food_amount: ', food_amount);
        console.log('food_time_id: ', food_time_id);
        $.ajax({
            data: { component_id, food_time_id, food_amount },
            dataType: 'json',
            type: 'POST',
            url: $("#update_component_route").val(),
            success: function(data) {
                console.log('exito' + data.message);
                msg = data.message;
                $("#editMenuComponentModal").modal('hide');
                showSuccessMessage(msg);
                menu_table.ajax.reload();
            },
            error: function(data) {
                msg = data.message;
                console.log('error: ' + msg);
                showErrorMessage(msg);
            }
        })
    });
    /* delete menu component */
    $("#delete_component_btn").on('click', function() {
        console.log('component_id: ' + component_id);
        $.ajax({
            data: { component_id },
            dataType: 'json',
            type: 'POST',
            url: $("#delete_component_route").val(),
            success: function(data) {
                msg = data.message;
                $("#editMenuComponentModal").modal('hide');
                if (data.status == 'success') {
                    showSuccessMessage(msg);
                    menu_table.ajax.reload();
                    check_menu_table_size();
                } else {
                    showErrorMessage(msg);
                }
            },
            error: function(data) {
                msg = data.message;
                console.log('error: ' + msg);
                showErrorMessage(msg);
            }
        })
    });
});