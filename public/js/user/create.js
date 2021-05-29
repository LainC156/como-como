jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* global variables */
    let automatic_radio_btn = false
    let name = ''
    let last_name = ''
    let email = ''
    let password
    let password_confirmation
    let identificator = ''
    let weight = 0
    let height = 0
    let birthdate = ''
    let genre = -1
    let psychical_activity = -1
    let caloric_requirement = 0
    let waist_size = 0
    let legs_size = 0
    let wrist_size = 0
    let custom_radio_btn = true
    let correct_password = false
    let correct_password_confirmation = false
    let data = {}

    /* check if email field has a correct format */
    let validateEmail = (email) => {
        let re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        return re.test(email)
    }
    /* check if CURP/ID field has a correct format */
    let validateIdentificator = (identificator) => {
        let re = /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i;
        return re.test(identificator)
    }
    /* function to update required fields */
    const updateRequiredFields = required => {
        required
            ? $("#height_required, #weight_required, #birthdate_required, #genre_required, #psychical_activity_required").show()
            : $("#height_required, #weight_required, #birthdate_required, #genre_required, #psychical_activity_required").hide()
    }
    /* verify if name field is no empty */
    $("#input_name").on('input', function () {
        name = this.value
        name ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* verify if last_name field is no empty */
    $("#input_last_name").on('input', function () {
        last_name = this.value
        last_name ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* verify if email field is no empty */
    $("#input_email").on('input', function () {
        email = this.value
        email ? (validateEmail(email) ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid'))
            : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* verify if password field is no empty and has at least 8 characters */
    $("#input_password").on('input', function () {
        password = this.value
        password && password.length > 7 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
        password && password.length > 7 ? correct_password = true : correct_password = false
        /* check if password and password_confirmation fields are equals */
        if (correct_password && correct_password_confirmation && password == $("#input_password_confirmation").val()) {
            $("#password_alert, #password_mismatch").hide()
            $("#password_success").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
            $("#input_password_confirmation").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("#password_alert, #password_success").hide()
            $("#password_mismatch").show()
            $(this).removeClass('is-valid').addClass('is-invalid')
            $("#input_password_confirmation").removeClass('is-valid').addClass('is-invalid')
        }
        /* show default alert */
        if (!$(this).val() && !$("#input_password").val()) {
            $("#password_alert").show();
            $("#password_success, #password_mismatch").hide();
        }
    })
    /* verify if password_confirmation field is no empty and has at least 8 characters */
    $("#input_password_confirmation").on('input', function () {
        password_confirmation = this.value
        password_confirmation && password_confirmation.length > 7 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
        password_confirmation && password_confirmation.length > 7 ? correct_password_confirmation = true : correct_password_confirmation = false
        !$(this).val() && !$("#input_password_confirmation").val()
        /* check if password and password_confirmation fields are equals */
        if (correct_password && correct_password_confirmation && $(this).val() == $("#input_password").val()) {
            $("#password_alert, #password_mismatch").hide()
            $("#password_success").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
            $("#input_password").removeClass('is-invalid').addClass('is-valid')
        } else {
            $("#password_alert, #password_success").hide()
            $("#password_mismatch").show()
            $(this).removeClass('is-valid').addClass('is-invalid')
            $("#input_password").removeClass('is-valid').addClass('is-invalid')
        }
        /* show default alert */
        if (!$(this).val() && !$("#input_password_confirmation").val()) {
            $("#password_alert").show()
            $("#password_success, #password_mismatch").hide()
        }
    })
    /*  CURP/ID validation */
    $("#input_identificator").on('input', function () {
        identificator = this.value
        identificator
            ? (validateIdentificator(identificator) ? $(this).removeClass('is-invalid').addClass('is-valid')
                : $(this).removeClass('is-valid').addClass('is-invalid'))
            : $(this).removeClass('is-valid').removeClass('is-invalid')
    })
    /* weight field validation */
    $("#input_weight").on('input', function () {
        weight = this.value
        weight && weight > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* height field validation */
    $("#input_height").on('input', function () {
        height = this.value
        height && height > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* birthdate field validation */
    $("#input_birthdate").on('input', function () {
        birthdate = this.value
        birthdate ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* genre select validation */
    $("#select_genre").on('input', function () {
        genre = this.value
        genre !== -1 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* psychical activity validation */
    $("#select_psychical_activity").on('input', function () {
        psychical_activity = this.value
        psychical_activity !== -1 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
    })
    /* check changes of radio buttons for caloric requirement */
    $("#automatic_calculation").on('input', function () {
        automatic_radio_btn = $(this).is(":checked")
        automatic_radio_btn ? updateRequiredFields(true) : updateRequiredFields(false)
        automatic_radio_btn ? $("#caloric_requirement_required").attr('hidden', false) : ''
        $("#input_caloric_requirement").removeClass('is-invalid').removeClass('is-valid')
    })
    $("#custom_calculation").on('input', function () {
        custom_radio_btn = $(this).is(":checked")
        custom_radio_btn ? updateRequiredFields(false) : updateRequiredFields(true)
        custom_radio_btn ? $("#caloric_requirement_required").attr('hidden', true) : ''
    })
    /* check for changes in caloric_requirement input field */
    $("#input_caloric_requirement").on('input', function () {
        caloric_requirement = this.value
        custom_radio_btn && caloric_requirement > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
        automatic_radio_btn ? $(this).removeClass('is-valid').removeClass('is-invalid') : ''
    })
    /* input waist size validation */
    $("#input_waist_size").on('input', function () {
        waist_size = this.value
        waist_size && waist_size > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid')
        waist_size && waist_size < 1 ? $(this).removeClass('is-valid').addClass('is-invalid') : $(this).removeClass('is-invalid')
    })
    /* input_legs_size validation */
    $("#input_legs_size").on('input', function () {
        legs_size = this.value
        legs_size && legs_size > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid')
        legs_size && legs_size < 1 ? $(this).removeClass('is-valid').addClass('is-invalid') : $(this).removeClass('is-invalid')
    })
    /* input wrist size validation */
    $("#input_wrist_size").on('input', function () {
        wrist_size = this.value
        wrist_size && wrist_size > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid')
        wrist_size && wrist_size < 1 ? $(this).removeClass('is-valid').addClass('is-invalid') : $(this).removeClass('is-invalid')
    })
    /* ajax request to create a new patient  */
    $("#create_user_btn").on('click', function () {
        /* get input values */
        name = $("#input_name").val()
        last_name = $("#input_last_name").val()
        email = $("#input_email").val()
        password = $("#input_password").val()
        password_confirmation = $("#input_password_confirmation").val()
        identificator = $("#input_identificator").val()
        weight = $("#input_weight").val()
        height = $("#input_height").val()
        birthdate = $("#input_birthdate").val()
        genre = $("#select_genre").val()
        psychical_activity = $("#select_psychical_activity").val()
        waist_size = $("#input_waist_size").val()
        legs_size = $("#input_legs_size").val()
        wrist_size = $("#input_wrist_size").val()

        if (!name) { $("#input_name").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!last_name) { $("#input_last_name").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!email || !validateEmail(email)) { $("#input_email").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!password || password.lenght < 8) { $("#input_password").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!password_confirmation || password_confirmation.lenght < 8) { $("#input_password_confirmation").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (identificator && !validateIdentificator(identificator)) { $("#input_identificator").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (waist_size && waist_size < 1) { $("#input_waist_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (legs_size && legs_size < 1) { $("#input_legs_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (wrist_size && wrist_size < 1) { $("#input_wrist_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }

        if (automatic_radio_btn) {
            if (!weight || weight <= 0) { $("#input_weight").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
            if (!height || height <= 0) { $("#input_height").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
            if (!birthdate) { $("#input_birthdate").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
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
                automatic_calculation: automatic_radio_btn
            }
        } else {
            let caloric_requirement = $("#input_caloric_requirement").val()
            if (!caloric_requirement || caloric_requirement <= 0) {
                $("#input_caloric_requirement").trigger('focus').removeClass('is-valid').addClass('is-invalid')
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
                automatic_calculation: automatic_radio_btn
            }
        }
        const user_store_route = $("#user_store_route").val()
        const home_route = $("#home_route").val()
        /* disable button until ajax response */
        $("#create_user_btn").hide()
        $("#loader").attr('hidden', false)
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: user_store_route,
            data: data,
            success: function (data) {
                if (data.status == 'error') {
                    $("#loader").attr('hidden', true)
                    showErrorMessage(data.message);
                } else if (data.status == 'success') {
                    /* disable create_user_btn */
                    $("#loader").attr('hidden', true)
                    showSuccessMessage(data.message);
                    /* redirect to home */
                    setTimeout(() => {
                        $(location).attr('href', home_route);
                    }, 10000);
                }
            },
            error: function (data) {
                $("#loader").attr('hidden', true)
                showErrorMessage(data.responseJSON.message);
            }
        })
    })
})
