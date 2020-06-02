$(document).ready(function() {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* global variables */
    let automatic_radio_btn = false;
    let name = '';
    let last_name = '';
    let email = '';
    let password;
    let password_confirmation;
    let identificator = '';
    let weight = 0;
    let height = 0;
    let birthdate = '';
    let genre = -1;
    let psychical_activity = -1;
    let caloric_requirement = 0;
    let waist_size = 0;
    let legs_size = 0;
    let wrist_size = 0;
    let custom_radio_btn = true;
    let correct_password = 0;
    let correct_password_confirmation = 0;
    let data = {};

    /* add attribute disable to weigh, height, birthdate, genre, psychical activity fields */
    // $("#input_height").attr('disabled', true);
    // $("#input_weight").attr('disabled', true);
    // $("#input_birthdate").attr('disabled', true);
    // $("#select_genre").attr('disabled', true);
    // $("#select_psychical_activity").attr('disabled', true);

    /* check if email field has a correct format */
    let validateEmail = (email) => {
        let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        return re.test(email);
    }

    /* check if CURP/ID field has a correct format */
    let validateIdentificator = (identificator) => {
        let re = /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i;
        return re.test(identificator);
    }

    /* function to update required fields */
    let updateRequiredFields = (required) => {
            if (required) {
                if (!$("#input_height").val()) {
                    $("#height_required").show();
                }
                //$("#input_height").attr('disabled', false).val('');
                if (!$("#input_weight").val()) {
                    $("#weight_required").show();
                }
                //$("#input_weight").attr('disabled', false).val('');
                if (!$("#input_birthdate").val()) {
                    $("#birthdate_required").show();
                }
                //$("#input_birthdate").attr('disabled', false);
                //console.log('valor de select: ', $("#select_genre").val())
                if ($("#select_genre").val() == null) {
                    $("#genre_required").show();
                }
                //$("#select_genre").attr('disabled', false);
                if ($("#select_psychical_activity").val() == null) {
                    $("#psychical_activity_required").show();
                }
                //$("#select_psychical_activity").attr('disabled', false);

                //$("#input_caloric_requirement").val('').attr('disabled', true);
                $("#caloric_requirement_required").hide();

                $("#caloric_requirement_required").hide();
                //$("#caloric_requirement_check").hide();
                $("#caloric_requirement_error").hide();
                console.log('campos requeridos');
            } else {
                $("#height_required").hide();
                //$("#input_height").val('').attr('disabled', true);

                $("#weight_required").hide();
                //$("#input_weight").val('').attr('disabled', true);

                $("#birthdate_required").hide();
                //$("#input_birthdate").val('').attr('disabled', true);

                $("#genre_required").hide();
                //$("#select_genre").val(-1).attr('disabled', true);

                $("#psychical_activity_required").hide();
                //$("#select_psychical_activity").val(-1).attr('disabled', true);

                //$("#input_caloric_requirement").val('').attr('disabled', false);
                //$("#caloric_requirement_required").show();
                //$("#caloric_requirement_check").hide();
                //$("#caloric_requirement_error").hide();
                console.log('campos no requeridos');
            }
        }
        /* verify if name field is no empty */
    $("#input_name").keyup(function() {
        name = $("#input_name").val();
        console.log('change:', name);
        if (name) {
            console.log('campo con al menos un caracter: ', name);
            $("#name_required").hide();
            $("#name_check").show();
        } else {
            console.log('campo sin un caracter: ', name);
            $("#name_required").show();
            $("#name_check").hide();
        }
    });
    /* verify if last_name field is no empty */
    $("#input_last_name").keyup(function() {
        last_name = $("#input_last_name").val();
        //console.log('change:', name_val);
        if (last_name) {
            //console.log('campo con al menos un caracter: ', name_val);
            $("#last_name_required").hide();
            $("#last_name_check").show();
        } else {
            //console.log('campo sin un caracter: ', name_val);
            $("#last_name_required").show();
            $("#last_name_check").hide();
        }
    });
    /* verify if email field is no empty */
    $("#input_email").keyup(function() {
        email = $("#input_email").val();
        if (email) {
            if (validateEmail(email)) {
                console.log('email valido');
                $("#email_required").hide();
                $("#email_check").show();
                $("#email_error").hide();
            } else {
                console.log('email no valido');
                $("#email_required").hide();
                $("#email_error").show();
                $("#email_check").hide();
            }
        } else {
            console.log('este campo es necesario');
            $("#email_required").show();
            $("#email_error").hide();
            $("#password_success").hide();
        }
    });
    /* verify if password field is no empty and has at least 8 characters */
    $("#input_password").keyup(function() {
        password = $("#input_password").val();
        if (password) {
            if (password.length > 7) {
                $("#password_check").show();
                $("#password_required").hide();
                $("#password_error").hide();
                console.log('password con mas de 7 caracteres');
                correct_password = 1;
            } else if (password.length <= 7) {
                $("#password_error").show();
                $("#password_check").hide();
                $("#password_required").hide();
                correct_password = 0;
                console.log('password con 7 caracteres o menos');
            }
        } else {
            $("#password_required").show();
            $("#password_error").hide();
            $("#password_check").hide();
            correct_password = 0;
            console.log('campo password vacio');
        }
        /* check if password and password_confirmation fields are equals */
        if (correct_password == 1 && correct_password_confirmation == 1 && $("#input_password_confirmation").val() == $("#input_password").val()) {
            console.log('contraseñas iguales');
            $("#password_alert").hide();
            $("#password_success").show();
            $("#password_mismatch").hide();
        } else {
            console.log('contrasñas no coinciden');
            $("#password_alert").hide();
            $("#password_success").hide();
            $("#password_mismatch").show();
        }
    });
    /* verify if password_confirmation field is no empty and has at least 8 characters */
    $("#input_password_confirmation").keyup(function() {
        password_confirmation = $("#input_password_confirmation").val();
        if (password_confirmation) {
            if (password_confirmation.length > 7) {
                $("#password_confirmation_check").show();
                $("#password_confirmation_required").hide();
                $("#password_confirmation_error").hide();
                correct_password_confirmation = 1;
                console.log('password con mas de 7 caracteres');
            } else if (password_confirmation.length <= 7) {
                $("#password_confirmation_error").show();
                $("#password_confirmation_check").hide();
                $("#password_confirmation_required").hide();
                correct_password_confirmation = 0;
                console.log('password con 7 caracteres o menos');
            }
        } else {
            $("#password_confirmation_required").show();
            $("#password_confirmation_error").hide();
            $("#password_confirmation_check").hide();
            correct_password_confirmation = 0;
            console.log('campo password vacio');
        }
        /* check if password and password_confirmation fields are equals */
        if (correct_password == 1 && correct_password_confirmation == 1 && $("#input_password_confirmation").val() == $("#input_password").val()) {
            console.log('contraseñas iguales');
            $("#password_alert").hide();
            $("#password_success").show();
            $("#password_mismatch").hide();
        } else {
            console.log('contrasñas no coinciden');
            $("#password_alert").hide();
            $("#password_mismatch").show();
            $("#password_success").hide();
        }
    });
    /*  CURP/ID validation */
    $("#input_identificator").keyup(function() {
        identificator = $("#input_identificator").val();
        if (identificator) {
            if (validateIdentificator(identificator)) {
                console.log('curp valido');
                $("#identificator_check").show();
                $("#identificator_error").hide();
            } else {
                console.log('curp no valido');
                $("#identificator_check").hide();
                $("#identificator_error").show();
            }
        } else {
            console.log('campo vacio');
            $("#identificator_check").hide();
            $("#identificator_error").hide();
        }
    });
    /* weight field validation */
    $("#input_weight").keyup(function() {
        weight = $("#input_weight").val();
        console.log('peso: ', weight);
        if (weight) {
            if (weight > 0) {
                $("#weight_required").hide();
                $("#weight_check").show();
                $("#weight_error").hide();
            } else {
                $("#weight_required").hide();
                $("#weight_check").hide();
                $("#weight_error").show();
            }
        } else {
            if (automatic_radio_btn) {
                $("#weight_required").show();
                $("#weight_check").hide();
                $("#weight_error").hide();
            } else {
                $("#weight_required").hide();
                $("#weight_check").hide();
                $("#weight_error").hide();
            }
        }

    });
    /* height field validation */
    $("#input_height").keyup(function() {
        height = $("#input_height").val();
        if (height) {
            if (height > 0) {
                $("#height_required").hide();
                $("#height_check").show();
                $("#height_error").hide();
            } else {
                $("#weight_required").hide();
                $("#weight_check").hide();
                $("#weight_error").show();
            }
        } else {
            if (automatic_radio_btn) {
                $("#height_required").show();
                $("#height_check").hide();
                $("#height_error").hide();
            } else {
                $("#height_required").hide();
                $("#height_check").hide();
                $("#height_error").hide();
            }
        }
    });
    /* birthdate field validation */
    $("#input_birthdate").change(function() {
        birthdate = $("#input_birthdate").val();
        if (birthdate) {
            console.log('birthdate: ', birthdate);
            $("#birthdate_check").show();
            $("#birthdate_error").hide();
            $("#birthdate_required").hide();
        } else {
            console.log('error: ', birthdate);
            if (automatic_radio_btn) {
                $("#birthdate_check").hide();
                $("#birthdate_error").hide();
                $("#birthdate_required").show();
            } else {
                $("#birthdate_check").hide();
                $("#birthdate_error").show();
                $("#birthdate_required").hide();
            }
        }
    })
    $("#input_birthdate").blur(function() {
            birthdate = $("#input_birthdate").val();
            if (automatic_radio_btn && !birthdate) {
                console.log('automatic && birthdate error');
                $("#birthdate_check").hide();
                $("#birthdate_error").hide();
                $("#birthdate_required").show();
            }
            if (!automatic_radio_btn && !birthdate) {
                console.log('custom && birthdate error: ', birthdate.length);
                $("#birthdate_check").hide();
                $("#birthdate_error").show();
                $("#birthdate_required").hide();
            }
        })
        /* genre select validation */
    $("#select_genre").change(function() {
        genre = $("#select_genre").val();
        if (genre != -1) {
            $("#genre_required").hide();
            $("#genre_check").show();
        }
    });
    /* psychical activity validation */
    $("#select_psychical_activity").change(function() {
        psychical_activity = $("#select_psychical_activity").val();
        console.log('p a: ', psychical_activity);
        if (psychical_activity != -1) {
            $("#psychical_activity_required").hide();
            $("#psychical_activity_check").show();
        }
    });
    /* check changes of radio buttons for caloric requirement */
    $("#automatic_calculation").change(function() {
        //console.log('automatic calculation changed');
        automatic_radio_btn = $("#automatic_calculation").is(":checked");
        custom_radio_btn = $("#custom_calculation").is(":checked");
        // console.log('custom radio button: ', custom_radio_btn);
        // console.log('automatic radio button: ', automatic_radio_btn);
        updateRequiredFields(true);
    });
    $("#custom_calculation").change(function() {
        console.log('custom calculation changed');
        automatic_radio_btn = $("#automatic_calculation").is(":checked");
        custom_radio_btn = $("#custom_calculation").is(":checked");
        // console.log('custom radio button: ', custom_radio_btn);
        // console.log('automatic radio button: ', automatic_radio_btn);
        updateRequiredFields(false);
    });
    /* check if caloric requiremnt is checked as custom or automatic */
    automatic_radio_btn = $("#automatic_calculation").is(":checked");
    custom_radio_btn = $("#custom_calculation").is(":checked");
    console.log('custom radio button: ', custom_radio_btn);
    console.log('automatic radio button: ', automatic_radio_btn);

    /* check for changes in caloric_requirement input field */
    if (custom_radio_btn) {
        $("#input_caloric_requirement").keyup(function() {
            let caloric_requirement_val = $("#input_caloric_requirement").val();
            if (caloric_requirement_val && caloric_requirement_val > 0) {
                $("#caloric_requirement_required").hide();
                $("#caloric_requirement_check").show();
                $("#caloric_requirement_error").hide();
            } else if (caloric_requirement_val && caloric_requirement_val <= 0) {
                $("#caloric_requirement_required").hide();
                $("#caloric_requirement_check").hide();
                $("#caloric_requirement_error").show();
            } else {
                $("#caloric_requirement_required").show();
                $("#caloric_requirement_check").hide();
                $("#caloric_requirement_error").hide();
            }
        });
    }
    /* input waist size validation */
    $("#input_waist_size").keyup(function() {
        waist_size = $("#input_waist_size").val();
        if (waist_size) {
            if (waist_size > 0) {
                $("#waist_size_check").show();
                $("#waist_size_error").hide();
            } else {
                $("#waist_size_check").hide();
                $("#waist_size_error").show();
            }
        } else {
            $("#waist_size_check").hide();
            $("#waist_size_error").hide();
        }
    });
    /* input_legs_size validation */
    $("#input_legs_size").keyup(function() {
        legs_size = $("#input_legs_size").val();
        if (legs_size) {
            if (legs_size > 0) {
                $("#legs_size_check").show();
                $("#legs_size_error").hide();
            } else {
                $("#legs_size_check").hide();
                $("#legs_size_error").show();
            }
        } else {
            $("#legs_size_check").hide();
            $("#legs_size_error").hide();
        }
    });
    /* input wrist size validation */
    $("#input_wrist_size").keyup(function() {
        wrist_size = $("#input_wrist_size").val();
        if (wrist_size) {
            if (wrist_size > 0) {
                $("#wrist_size_check").show();
                $("#wrist_size_error").hide();
            } else {
                $("#wrist_size_check").hide();
                $("#wrist_size_error").show();
            }
        } else {
            $("#wrist_size_check").hide();
            $("#wrist_size_error").hide();
        }
    });

    /* ajax request to create a new patient  */
    $("#create_user_btn").click(function() {
        /* get input values */
        name = $("#input_name").val();
        last_name = $("#input_last_name").val();
        email = $("#input_email").val();
        password = $("#input_password").val();
        password_confirmation = $("#input_password_confirmation").val();
        identificator = $("#input_identificator").val();
        weight = $("#input_weight").val();
        height = $("#input_height").val();
        birthdate = $("#input_birthdate").val();
        genre = $("#select_genre").val();
        psychical_activity = $("#select_psychical_activity").val();
        //caloric_requirement = $("#input_caloric_requirement").val();
        waist_size = $("#input_waist_size").val();
        legs_size = $("#input_legs_size").val();
        wrist_size = $("#input_wrist_size").val();
        // console.log('data: ', data);
        // return;
        if (!name || !last_name || !email || !validateEmail(email) || !password || password.lenght < 8 || !password_confirmation || password_confirmation.lenght < 8) {
            console.log('falta algún campo');
            return;
        }

        if (automatic_radio_btn) {

            if (!weight || weight <= 0 || !height || height <= 0 || !birthdate || genre == -1 || psychical_activity == -1) {
                console.log('calculo automatico: falta algún campo');
                return;
            }
            data = {
                name,
                last_name,
                email,
                password,
                password_confirmation,
                identificator,
                weight,
                height,
                birthdate,
                genre,
                psychical_activity,
                waist_size,
                legs_size,
                wrist_size,
                automatic_calculation: 1
            };
        } else {
            let caloric_requirement = $("#input_caloric_requirement").val();
            if (!caloric_requirement || caloric_requirement <= 0) {
                console.log('calculo personalizado: falta requerimiento calórico');
                return;
            }
            data = {
                name,
                last_name,
                identificator,
                email,
                password,
                password_confirmation,
                weight,
                height,
                birthdate,
                genre,
                psychical_activity,
                waist_size,
                legs_size,
                wrist_size,
                caloric_requirement,
                automatic_calculation: 0
            };

        }
        console.log('data: ', data);
        let user_store_route = $("#user_store_route").val();
        let home_route = $("#home_route").val();
        /* disable button until ajax response */
        $("#create_user_btn").attr('disabled', true);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: user_store_route,
            data: data,
            success: function(data) {
                console.log('success: ', data);
                if (data.status == 'error') {
                    showErrorMessage(data.message);
                } else if (data.status == 'success') {
                    /* disable create_user_btn */
                    $("#create_user_btn").attr('disabled', true);
                    showSuccessMessage(data.message);
                    /* redirect to home */
                    setTimeout(() => {
                        $(location).attr('href', home_route);
                    }, 5000);

                }
            },
            error: function(data) {
                console.log('error: ', data);
                showErrorMessage(data.message);
            }
        });

    });

});
