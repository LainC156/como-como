    /* search via ajax method  */
    $(document).ready(function() {
        /* global variables */

        let food_id = 0;
        let menu_id = $('#menu_id').val();
        let component_id = 0;
        let patient_id = $("#patient_id").val();
        let url = $("#list_menu").val();
        let url_menu_table_data = $("#kind_of_menu").val() == 0 ? url : $("#edit_saved_menu").val();
        let food_name_validation = 0;
        let food_amount = 0;
        console.log('menu_id: ' + menu_id);
        /* set up to initialize popover */
        $('[data-toggle="popover"]').popover();
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
                url: $("#list_food").val(),
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
            processing: true,
            serverSide: true,
            ajax: {
                url: url_menu_table_data,
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
                    }
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
            if ($("#food_amount").val() && $("#food_amount").val() > 0) {
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
            /* enable or disable add_food button to avoid unncesary request
            if( $("#food_name").is(':disabled') ) {
                console.log('elemento seleccionado');
                $("#add_food").prop('disabled', false);
            } else if( $("#food_name").is(':enabled') ) {
                console.log('elemento no seleccionado');
                $("#add_food").prop('disabled', true);
            } */

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

            //menu_table.row(this).edit();

        });
        /* validations to show popover */
        $("#add_food").on('show.bs.popover', function() {
            console.log('popover clic');
            //$(this).popover('show');
            setTimeout(function() {
                console.log('vamos a esconder');
                $("#add_food").popover('hide');
                $("#add_food").attr('data-content', '');
            }, 2000);
        }); //$(this).popover('show');
        /* adding food when button with id="add_food" is clicked */
        $("#add_food").click(function(e) {
            /* validations */
            let msg = '';
            console.log('mensaje al inicio: ' + msg);
            if ($("#food_name").val() == '') {
                msg = "{{ __('Es necesario seleccionar un alimento') }}" + ", ";
            }
            if ($("#food_amount").val() == '') {
                msg += "{{ __('Es necesario especificar un peso') }}" + ", ";
                $(this).focus();
                console.log('vacio');
            }
            if ($("#food_amount").val() <= 0) {
                msg += "{{ __('El peso debe ser mayor que 0') }}" + ", ";
                $(this).focus();
                console.log('<= 0' + $("#food_amount").val());
            }
            if ($("#food_time :selected").val() == -1) {
                msg += "{{ __('Es necesario seleccionar un tiempo') }}";
                console.log('default');
            }
            if (msg.length > 0) {
                console.log('mensaje desde validacion: ' + msg);
                console.log('nombre desde validacion: ' + $("#food_name").val());
                $("#add_food").attr('data-content', msg);
                $("#add_food").attr('data-color', 'danger');
                $(this).removeClass('btn-default').addClass('btn-danger');
                $(".popover-body").css("background-color", "tomato");
                $(this).popover('show');
                return;
            }
            /* add food to menu */
            let food_amount = $("#food_amount").val();
            console.log('food_id: ' + food_id);
            console.log('menu_id: ' + menu_id);
            var food_time_id = $("#food_time :selected").val();
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
                    let msg = data.message;
                    console.log('mensaje: ' + msg);
                    $("#alert_success").empty();
                    $('#alert_success').append('<span class="text-dark"><i class="ni ni-check-bold"></i></span>' + msg);

                    $("#alert_success").show();
                    setTimeout(function() {
                        $("#alert_success").hide();
                    }, 5000);
                    /* reset fields */
                    $("#food_name").val('');
                    //$("#food_name").prop('disabled', false);
                    $("#food_amount").val('');
                    $("#add_food").removeClass('btn-danger').addClass('btn-default');
                    menu_table.ajax.reload();
                    check_menu_table_size();
                    console.log('valor de food_id: ' + food_id);
                },
                error: function(data) {
                    let msg = data.message;
                    console.log('error: ' + msg);
                    $("#alert_error").empty();
                    $('#alert_error').append('<span class="text-dark"><i class="ni ni-fat-remove"></i></span>' + msg);
                    $("#alert_error").show();
                    setTimeout(function() {
                        $("#alert_error").hide();
                    }, 5000);
                }
            })

        });
        /*  reset fields from trash button */
        $('#remove_data').click(function() {
            $("#food_name").val('');
            //$("#food_name").prop('disabled', false);
            $("#food_amount").val('');
        });
        /* update component */
        $("#btn_update_component").on('click', function() {
            let msg = '';
            let id_food_time = $("#menuComponentKindOfFoodEdited :selected").val() != 'Tiempo' ? $("#menuComponentKindOfFoodEdited :selected").val() : -1;
            let food_weight = $("#menuComponentFoodWeightEdited").val();
            console.log('component_id: ' + component_id);
            /* validations */
            if (id_food_time == -1) {
                msg = "{{ __('Es necesario seleccionar un tiempo') }}" + ", ";
            }
            if (food_weight == '') {
                msg += "{{ __('Es necesario especificar un peso') }}" + ", ";
            }
            if (food_weight <= 0) {
                msg += "{{ __('El peso debe ser mayor que 0') }}";
            }
            if (msg.length > 0) {
                console.log('mensaje: ' + msg);
                $("#btn_update_component").attr('data-content', msg);
                $(this).popover('show');
                return;
            }
            $.ajax({
                    data: { component_id, id_food_time, food_weight },
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('edit.component') }}",
                    success: function(data) {
                        console.log('exito' + data.message);
                        var msg = data.message;
                        $("#editMenuComponentModal").modal('hide');
                        $("#alert_success").empty();
                        $('#alert_success').append("<strong>{{ __('Listo') }}: </strong>" + msg);
                        $("#alert_success").show();
                        setTimeout(function() {
                            $("#alert_success").hide();
                        }, 3000);
                        menu_table.ajax.reload();
                    },
                    error: function(data) {
                        let msg = data.message;
                        console.log('error: ' + msg);
                        $("#alert_error").empty();
                        $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + msg);
                        $("#alert_error").show();
                        setTimeout(function() {
                            $("#alert_error").hide();
                        }, 3000);
                    }
                })
                //e.preventDefault();

        });
        /* delete component */
        $("#btn_delete_component").on('click', function() {
            console.log('component_id: ' + component_id);
            $.ajax({
                data: { component_id },
                dataType: 'json',
                type: 'POST',
                url: "{{ route('delete.component') }}",
                success: function(data) {
                    let msg = data.message;
                    $("#editMenuComponentModal").modal('hide');
                    $("#alert_success").empty();
                    $('#alert_success').append("<strong>{{ __('Listo') }}: </strong>" + msg);
                    $("#alert_success").show();
                    setTimeout(function() {
                        $("#alert_success").hide();
                    }, 3000);
                    $("editMenuComponentModal").modal('hide');
                    menu_table.ajax.reload();
                    check_menu_table_size();
                },
                error: function(data) {
                    let msg = data.message;
                    console.log('error: ' + msg);
                    $("#alert_error").empty();
                    $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + msg);
                    $("#alert_error").show();
                    setTimeout(function() {
                        $("#alert_error").hide();
                    }, 3000);
                }
            })
        });
        /* save menu, show modal and save data */
        $("#btn_save_menu").click(function() {
            /* validations */
            let name = $("#menu_name").val();
            let description = $("#menu_description").val();
            let msg = '';
            if (name == '')
                msg = "{{ __('El campo nombre es requerido') }}" + ", ";
            if (description == '')
                msg += "{{ __('El campo descripcion es requerido') }}" + ".";
            if (msg.length > 0) {
                console.log('msg: ' + msg);
                $(this).empty();
                $(this).attr('data-content', msg);
                $(this).popover('show');
                return;
            }
            var data = {
                name: name,
                description: description,
                menu_id: menu_id,
                kind_of: 0
            };

            console.log('name: ' + name + ', desc: ' + description + ', menu_id: ' + menu_id);
            $.ajax({
                data: data,
                dataType: 'json',
                type: 'POST',
                url: "{{ route('save.menu') }}",
                success: function(data) {
                    let msg = data.message;
                    $("#alert_success").empty();
                    $('#alert_success').append("<strong>{{ __('Listo') }}: </strong>" + msg);
                    $("#alert_success").show();
                    setTimeout(function() {
                        $("#alert_success").hide();
                        window.close();
                    }, 3000);
                    //$("#menu_name").val('');
                    //$("#menu_description").val('');
                    $("#saveMenuModal").modal('hide');
                    //check_menu_table_size();

                    //menu_table.ajax.reload();
                },
                error: function(data) {
                    let msg = data.message;
                    console.log('error: ' + msg);
                    $("#alert_error").empty();
                    $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + msg);
                    $("#alert_error").show();
                    setTimeout(function() {
                        $("#alert_error").hide();
                    }, 3000);
                }

            });

        });
        /* delete components added to the actual menu */
        $("#btn_delete_menu").click(function() {
            console.log('menu_id: ' + menu_id);
            $.ajax({
                data: { menu_id },
                dataType: 'json',
                type: 'POST',
                url: "{{ route('empty.menu') }}",
                success: function(data) {
                    let msg = data.message;
                    $("#alert_success").empty();
                    $('#alert_success').append("<strong>{{ __('Listo') }} </strong>" + msg);
                    $("#alert_success").show();
                    setTimeout(function() {
                        $("#alert_success").hide();
                    }, 3000);
                    $("#deleteMenuModal").modal('hide');
                    menu_table.ajax.reload();
                },
                error: function(data) {
                    let msg = data.message;
                    console.log('error: ' + msg);
                    $("#alert_error").empty();
                    $('#alert_error').append("<strong>{{ __('Error') }}: </strong>" + msg);
                    $("#alert_error").show();
                    setTimeout(function() {
                        $("#alert_error").hide();
                    }, 3000);
                }
            })
        });
    });