    /* search via ajax method  */
    $(document).ready(function() {
        /* global variables */
        let msg = '';
        let food_id = 0;
        let menu_id = $('#menu_id').val();
        let component_id = 0;
        let patient_id = $("#patient_id").val();
        let url = $("#list_menu").val();
        let food_data = $("#list_food").val();
        console.log('url: ', url);
        console.log('data: ', food_data);
        //let url_menu_table_data = $("#kind_of_menu").val() == 0 ? url : $("#edit_saved_menu").val();
        let food_name_validation = 0;
        let food_amount = 0;
        let food_time_id = 0;
        let menu_name_validation = 0;
        let menu_description_validation = 0;
        console.log('menu_id: ' + menu_id);
        /* set up to initialize popover
        $('[data-toggle="popover"]').popover(); */
        /* csrf token to ajax requests */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        /* get data from server and display food list with dataTables */
        let food_table = $("#food_table").DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 75, 100],
            processing: true,
            serverSide: true,
            ajax: {
                url: food_data,
                type: 'GET',
            },
            columns: [
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

        /* show menu components in DataTables */
        let menu_table = $("#menu_table").DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 75, 100],
            processing: true,
            serverSide: true,
            ajax: {
                url: $("#list_menu").val(),
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

        new $.fn.dataTable.Buttons(menu_table, {
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });

        menu_table.buttons().container()
            .appendTo($('.col-sm-6:eq(0)', menu_table.table().container()));
        /* enable and disable buttons depending on menu_table content */
        /* if table is empty buttons are disabled, else buttons are enabled */
        /* validation to check if is possible generate results, save or delete from this menu */
        function check_menu_table_size() {
            setTimeout(function() { //calls click event after a certain time
                let size = menu_table.data().count();
                if (size == 0) {
                    $("#btn_generate_results").removeClass('enabled').addClass('disabled');
                    $("#btn_save_m").removeClass('enabled').addClass('disabled');
                    $("#btn_delete_m").removeClass('enabled').addClass('disabled');
                    console.log('menu vacio: ' + size);
                } else if (size >= 1) {
                    $("#btn_generate_results").removeClass('disabled').addClass('enabled');
                    $("#btn_save_m").removeClass('disabled').addClass('enabled');
                    $("#btn_delete_m").removeClass('disabled').addClass('enabled');
                    console.log('menu con al menos un elemento: ' + size);
                }
            }, 2000);
        }
        check_menu_table_size();
        /* method from datatables api*/
        /* getting data when row food table is clicked */
        $('#food_table tbody').on('click', 'tr', function() {
            console.log('data: ' + JSON.stringify(food_table.row(this).data()));
            let row_data = food_table.row(this).data();
            food_id = row_data.id;
            $("#food_name").val(row_data.name);
            console.log('name; ' + row_data.name);
            //$("#food_name").prop("disabled", true);
            food_name_validation = 1;
            $("#food_amount").focus();
            /* check if food amount field value is correct, then activate add food button */
            if ($("#food_amount").val() && $("#food_amount").val() > 0 && $("#food_name").val()) {
                $("#add_food").attr('disabled', false);
            } else {
                $("#add_food").attr('disabled', true);
            }
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                food_table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        /* check if food name field and food amount field is no empty and the enable add food button */
        $("#food_amount").keyup(function() {
                food_amount = $("#food_amount").val();
                if (food_name_validation == 1 && food_amount && food_amount > 0) {
                    $("#add_food").attr('disabled', false);
                } else {
                    $("#add_food").attr('disabled', true);
                }
            })
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
        /* adding food when button with id="add_food" is clicked */
        $("#add_food").click(function(e) {
            /* add food to menu */
            food_amount = $("#food_amount").val();
            console.log('food_id: ' + food_id);
            console.log('menu_id: ' + menu_id);
            food_time_id = $("#food_time :selected").val();
            console.log('food time id: ' + food_time_id);
            let data = {
                food_id: food_id,
                menu_id: menu_id,
                food_amount: food_amount,
                food_time_id: food_time_id

            };
            $.ajax({
                data: data,
                dataType: 'json',
                type: 'POST',
                //processData: false,
                url: $("#add_food_route").val(),
                success: function(data) {
                    msg = data.message;
                    console.log('mensaje: ' + msg);
                    showSuccessMessage(msg);
                    /* reset fields and disabled add_food */
                    $("#food_name").val('');
                    $("#food_amount").val('');
                    $('input[type=search]').val('').change();
                    $("#add_food").attr('disabled', true);
                    menu_table.ajax.reload();
                    check_menu_table_size();
                    console.log('valor de food_id: ' + food_id);
                },
                error: function(data) {
                    msg = data.message;
                    console.log('error: ' + msg);
                    showErrorMessage(msg);
                }
            })

        });
        /*  reset fields from trash button */
        $('#remove_data').click(function() {
            $("#food_name").val('');
            $("#add_food").prop('disabled', true);
            $("#food_amount").val('');
            food_name_validation = 0;
        });
        /* check if food_amount in edit component is no empty */
        $("#menuComponentFoodWeightEdited").keyup(function() {
            let amount = $("#menuComponentFoodWeightEdited").val();
            if (!amount || amount <= 0) {
                $("#update_component_btn").attr('disabled', true);
            } else {
                $("#update_component_btn").attr('disabled', false);
            }
        });
        /* update component */
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
        /* delete component */
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
        /* save menu, show modal and save data */
        $("#save_menu_btn").click(function() {
            /* validations */
            let name = $("#menu_name").val();
            let description = $("#menu_description").val();
            if (!name || !description) {
                console.log('algun campo vacío');
                return;
            }
            var data = {
                name: name,
                description: description,
                menu_id: menu_id,
                kind_of: 1
            };

            console.log('name: ' + name + ', desc: ' + description + ', menu_id: ' + menu_id);
            $.ajax({
                data: data,
                dataType: 'json',
                type: 'POST',
                url: $("#store_menu_route").val(),
                success: function(data) {
                    msg = data.message;
                    $("#saveMenuModal").modal('hide');
                    if (data.status == 'success') {
                        showSuccessMessage(msg);
                        window.location.replace($("#index_menu").val())
                    } else {
                        showErrorMessage(msg);
                    }
                },
                error: function(data) {
                    msg = data.message;
                    $("#saveMenuModal").modal('hide');
                    showErrorMessage(msg);
                }

            });

        });
        /* delete components added to the actual menu */
        $("#delete_menu_btn").click(function() {
            console.log('menu_id: ' + menu_id);
            $.ajax({
                data: { menu_id },
                dataType: 'json',
                type: 'POST',
                url: $("#empty_menu_route").val(),
                success: function(data) {
                    msg = data.message;
                    $("#deleteMenuModal").modal('hide');
                    if (data.status == 'success') {
                        showSuccessMessage(msg);
                        check_menu_table_size();
                    } else {
                        showErrorMessage(msg);
                    }
                    menu_table.ajax.reload();
                },
                error: function(data) {
                    msg = data.message;
                    $("#deleteMenuModal").modal('hide');
                    showErrorMessage(msg);
                }
            })
        });
    });