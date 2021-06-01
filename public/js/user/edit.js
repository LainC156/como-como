jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    /* global variables */
    let automatic_radio_btn = $("#automatic_calculation").is(":checked")
    let name = $("#input_name").val()
    let last_name = $("#input_last_name").val()
    let email = $("#input_email").val()
    let password = $("#input_password").val()
    let password_confirmation = $("#input_password_confirmation").val()
    let identificator = $("#input_identificator").val()
    let weight = $("#input_weight").val()
    let height = $("#input_height").val()
    let birthdate = $("#input_birthdate").val()
    let genre = $("#select_genre").val()
    let psychical_activity = $("#select_psychical_activity").val()
    let caloric_requirement = $("#input_caloric_requirement").val()
    let waist_size = $("#input_waist_size")
    let legs_size = $("#input_legs_size")
    let wrist_size = $("#input_wrist_size")
    let custom_radio_btn = $("#custom_calculation").is(":checked")
    let correct_password = 0
    let correct_password_confirmation = 0
    let avatar = ''
    let data = {}
    const patient_id = $("#patient_id").val()

    /* check if email field has a correct format */
    let validateEmail = (email) => {
        let re = /^(([^<>()\[\]\.,:\s@\"]+(\.[^<>()\[\]\.,:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,:\s@\"]+\.)+[^<>()[\]\.,:\s@\"]{2,})$/i
        return re.test(email)
    }
    /* check if CURP/ID field has a correct format */
    let validateIdentificator = (identificator) => {
        let re = /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i
        return re.test(identificator)
    }
    /* function to show or hide inputs required */
    const showOrHideRequiredFields = (required) => {
        console.log('required: ', required)
        required
            ? $("#height_required, #weight_required, #birthdate_required, #genre_required, #psychical_activity_required").show()
            : $("#height_required, #weight_required, #birthdate_required, #genre_required, #psychical_activity_required").hide()
    }
    automatic_radio_btn ? showOrHideRequiredFields(true) : showOrHideRequiredFields(false)
    automatic_radio_btn ? $("#caloric_requirement_required").hide() : $("#caloric_requirement_required").show()
    /* set atrribute to update avatar button */
    $("#update_avatar_btn").attr('disabled', true)
    /* update update avatar button if file is selected */
    $("#img_avatar").on('input', function () {
        console.log('input type file')
        if ($("#img_avatar").get(0).files.length !== 0) {
            $("#update_avatar_btn").attr('disabled', false)
        } else {
            $("#update_avatar_btn").attr('disabled', true)
        }
    })
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
        //automatic_radio_btn ? updateRequiredFields(true) : updateRequiredFields(false)
        automatic_radio_btn ? $("#caloric_requirement_required").hide() : ''
        showOrHideRequiredFields(true)
    })
    $("#custom_calculation").on('input', function () {
        custom_radio_btn = $(this).is(":checked")
        //custom_radio_btn ? $(this).remove : updateRequiredFields(true)
        custom_radio_btn ? $("#caloric_requirement_required").show() : ''
        showOrHideRequiredFields(false)
    })
    /* check input_caloric_requirement */
    $("#input_caloric_requirement").on('input', function () {
        console.log('valor de cr: ', $(this).val())
        console.log('valor de crb', custom_radio_btn)
        custom_radio_btn === true && $(this).val() > 0 ? $(this).removeClass('is-invalid').addClass('is-valid') : $(this).removeClass('is-valid').addClass('is-invalid')
        //if(automatic_radio_btn) $(this).removeClass('is-valid').removeClass('is-invalid')
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

    /* ajax request to update avatar profile */
    $("#upload_avatar").on('submit', function (e) {
        e.preventDefault()

        let formData = new FormData(this)
        let avatar_update_route = $("#update_avatar_route").val()
        // console.log('update route: ', avatar_update_route)
        // return
        $.ajax({
            type: 'POST',
            url: avatar_update_route,
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            success: function (data) {
                if (data.status == 'error') {
                    console.log('error en success: ', data.message)
                    showErrorMessage(data.message)
                }
                if (data.status == 'success') {
                    console.log('success: ', data.message)
                    showSuccessMessage(data.message)
                    setTimeout(() => {
                        location.reload()

                    }, 5000)
                }
            },
            error: function (data) {
                console.log('error: ', data.message)
                showErrorMessage(data.message)
            }
        })
    })
    /* ajax request to create a new patient  */
    $("#update_user_btn").on('click', function () {
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
        caloric_requirement = $("#input_caloric_requirement").val()
        waist_size = $("#input_waist_size").val()
        legs_size = $("#input_legs_size").val()
        wrist_size = $("#input_wrist_size").val()
        automatic_radio_btn = $("#automatic_calculation").is(':checked')
        custom_radio_btn = $("#custom_calculation").is(':checked')

        if (!name) { $("#input_name").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!last_name) { $("#input_last_name").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (!email || !validateEmail(email)) { $("#input_email").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (password && password.length < 8) { $("#input_password").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (password_confirmation && password_confirmation.length < 8) { $("#input_password_confirmation").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (identificator && !validateIdentificator(identificator)) { $("#input_identificator").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (custom_radio_btn && caloric_requirement < 1) { $("#input_caloric_requirement").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (waist_size && waist_size < 1) { $("#input_waist_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (legs_size && legs_size < 1) { $("#input_legs_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
        if (wrist_size && wrist_size < 1) { $("#input_wrist_size").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }


        if (automatic_radio_btn) {
            if (!weight || weight <= 0) { $("#input_weight").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
            if (!height || height <= 0) { $("#input_height").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }
            if (!birthdate) { $("#input_birthdate").trigger('focus').removeClass('is-valid').addClass('is-invalid'); return }

            data = {
                patient_id,
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
                automatic_calculation: true,
            }
        } else {
            if (!caloric_requirement || caloric_requirement <= 0) {
                $("#input_caloric_requirement").trigger('focus').removeClass('is-valid').addClass('is-invalid')
                return;
            }
            data = {
                patient_id,
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
                automatic_calculation: false,
            }

        }
        const user_update_route = $("#user_update_route").val()
        //let home_route = $("#home_route").val()
        /* disable button until ajax response */
        $("#update_user_btn").hide()
        $("#loader").attr('hidden', false)
        $.ajax({
            type: 'POST',
            url: user_update_route,
            data: data,
            success: function (data) {
                console.log('success: ', data)
                if (data.status == 'error') {
                    showErrorMessage(data.message)
                    $("#loader").attr('hidden', true)
                    console.log('exception: ', JSON.stringify(data.exception))
                } else if (data.status == 'success') {
                    $("#loader").attr('hidden', true)
                    showSuccessMessage(data.message)
                    /* reload page */
                    setTimeout(() => {
                        location.reload()
                    }, 5000)
                }
            },
            error: function (data) {
                console.log('error: ', data)
                $("#loader").attr('hidden', true)
                showErrorMessage(data.responseJSON.message)
            }
        })

    })

})