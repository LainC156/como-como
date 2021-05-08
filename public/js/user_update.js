jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    /* global variables */
    let automatic_radio_btn = $("#automatic_calculation").is(":checked")
    let name = ''
    let last_name = ''
    let email = ''
    let password
    let password_confirmation
    let identificator = ''
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
    let patient_id = $("#patient_id").val()
    console.log('patient_id: ', patient_id)

    /* add attribute disable to weigh, height, birthdate, genre, psychical activity fields */
    // $("#input_height").attr('disabled', true)
    // $("#input_weight").attr('disabled', true)
    // $("#input_birthdate").attr('disabled', true)
    // $("#select_genre").attr('disabled', true)
    // $("#select_psychical_activity").attr('disabled', true)

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

    /* function to update required fields */
    let updateRequiredFields = (required) => {
        if (required) {
            if (height <= 0) {
                $("#input_height").removeClass('is-valid').addClass('is-invalid')
            }
            //$("#input_height").attr('disabled', false).val('')
            if (weight <= 0) {
                $("#input_weight").removeClass('is-valid').addClass('is-invalid')
            }
            //$("#input_weight").attr('disabled', false).val('')
            if (!birthdate) {
                $("#input_birthdate").removeClass('is-valid').addClass('is-invalid')
            }
            //$("#input_birthdate").attr('disabled', false)
            //console.log('valor de select: ', $("#select_genre").val())
            if (!genre) {
                $("#select_genre").removeClass('is-valid').addClass('is-invalid')
            }
            //$("#select_genre").attr('disabled', false)
            if (!psychical_activity) {
                $("#select_psychical_activity").removeClass('is-valid').addClass('is-invalid')
            }
            if(waist_size && waist_size <= 0) {
                console.log('invalid waist_size required')
                $("#input_waist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_waist_size").trigger('focus')
                return
            }
            if(legs_size && legs_size <= 0) {
                console.log('invalid legs_size required')
                $("#input_legs_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_legs_size").trigger('focus')
                return
            }
            if(wrist_size && wrist_size <= 0) {
                console.log('invalid wrist_size required')
                $("#input_wrist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_wrist_size").trigger('focus')
                return
            }
            //$("#select_psychical_activity").attr('disabled', false)

            //$("#input_caloric_requirement").val('').attr('disabled', true)
            // $("#caloric_requirement_required").hide()

            // $("#caloric_requirement_required").hide()
            // //$("#caloric_requirement_check").hide()
            // $("#caloric_requirement_error").hide()
            /* valid or invalid caloric requirement input */
            if (!$("#input_caloric_requirement").val()) {
                $("#input_caloric_requirement").removeClass('is-valid').removeClass('is-invalid')
            }
            console.log('campos requeridos: ', caloric_requirement)
        } else {
            //$("#height_required").hide()
            $("#input_height").removeClass('is-valid').removeClass('is-invalid')

            //$("#weight_required").hide()
            $("#input_weight").removeClass('is-valid').removeClass('is-invalid')

            //$("#birthdate_required").hide()
            $("#input_birthdate").removeClass('is-valid').removeClass('is-invalid')

            //$("#genre_required").hide()
            if (genre == -1) {
                $("#select_genre").removeClass('is-valid').addClass('is-invalid')
            }

            //$("#psychical_activity_required").hide()
            $("#select_psychical_activity").removeClass('is-valid').removeClass('is-invalid')

            if(waist_size && waist_size <= 0) {
                console.log('invalid waist_size')
                $("#input_waist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_waist_size").trigger('focus')
                return
            }
            if(legs_size && legs_size <= 0) {
                console.log('invalid legs_size')
                $("#input_legs_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_legs_size").trigger('focus')
                return
            }
            if(wrist_size && wrist_size <= 0) {
                console.log('invalid wrist_size')
                $("#input_wrist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_wrist_size").trigger('focus')
                return
            }
            //$("#input_caloric_requirement").val('').attr('disabled', false)
            //$("#caloric_requirement_required").show()
            //$("#caloric_requirement_check").hide()
            //$("#caloric_requirement_error").hide()
            if (!$("#input_caloric_requirement").val()) {
                $("#input_caloric_requirement").removeClass('is-valid').addClass('is-invalid')
            }
            console.log('campos no requeridos')
        }
    }
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
        console.log('change:', name)
        if (name) {
            console.log('campo con al menos un caracter: ', name)
            // $("#name_required").hide()
            // $("#name_check").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else {
            console.log('campo sin un caracter: ', name)
            // $("#name_required").show()
            // $("#name_check").hide()
            $(this).removeClass('is-valid').addClass('is-invalid')
        }
    })
    /* verify if last_name field is no empty */
    $("#input_last_name").on('input', function () {
        last_name = this.value
        //console.log('change:', name_val)
        if (last_name) {
            //console.log('campo con al menos un caracter: ', name_val)
            // $("#last_name_required").hide()
            // $("#last_name_check").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else {
            //console.log('campo sin un caracter: ', name_val)
            // $("#last_name_required").show()
            // $("#last_name_check").hide()
            $(this).removeClass('is-valid').addClass('is-invalid')

        }
    })
    /* verify if email field is no empty */
    $("#input_email").on('input', function () {
        email = this.value
        if (email) {
            if (validateEmail(email)) {
                console.log('email valido')
                // $("#email_required").hide()
                // $("#email_check").show()
                // $("#email_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                console.log('email no valido')
                // $("#email_required").hide()
                // $("#email_error").show()
                // $("#email_check").hide()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            console.log('este campo es necesario')
            // $("#email_required").show()
            // $("#email_error").hide()
            // $("#password_success").hide()
            $(this).removeClass('is-valid').addClass('is-invalid')
        }
    })
    /* verify if password field is no empty and has at least 8 characters */
    $("#input_password").on('input', function () {
        password = this.value
        if (password) {
            if (password.length > 7) {
                // $("#password_check").show()
                // //$("#password_required").hide()
                // $("#password_error").hide()
                console.log('password con mas de 7 caracteres')
                $(this).removeClass('is-invalid').addClass('is-valid')
                correct_password = 1
            } else if (password.length <= 7) {
                // $("#password_error").show()
                // $("#password_check").hide()
                //$("#password_required").hide()
                correct_password = 0
                console.log('password con 7 caracteres o menos')
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            //$("#password_required").show()
            // $("#password_error").hide()
            // $("#password_check").hide()
            correct_password = 0
            console.log('campo password vacio')
            $(this).removeClass('is-valid').removeClass('is-invalid')
        }
        /* check if password and password_confirmation fields are equals */
        if (correct_password == 1 && correct_password_confirmation == 1 && password_confirmation === password) {
            console.log('contraseñas iguales')
            $("#password_alert").hide()
            $("#password_success").show()
            $("#password_mismatch").hide()
        } else {
            console.log('contrasñas no coinciden')
            $("#password_alert").hide()
            $("#password_success").hide()
            $("#password_mismatch").show()
            if (!password && !password_confirmation) {
                $("#password_alert").show()
                $("#password_success").hide()
                $("#password_mismatch").hide()
            }
        }
    })
    /* verify if password_confirmation field is no empty and has at least 8 characters */
    $("#input_password_confirmation").on('input', function () {
        password_confirmation = this.value
        if (password_confirmation) {
            if (password_confirmation.length > 7) {
                // $("#password_confirmation_check").show()
                // //$("#password_confirmation_required").hide()
                // $("#password_confirmation_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
                correct_password_confirmation = 1
                console.log('password con mas de 7 caracteres')
            } else if (password_confirmation.length <= 7) {
                // $("#password_confirmation_error").show()
                // $("#password_confirmation_check").hide()
                //$("#password_confirmation_required").hide()
                $(this).removeClass('is-valid').addClass('is-invalid')
                correct_password_confirmation = 0
                console.log('password con 7 caracteres o menos')
            }
        } else {
            //$("#password_confirmation_required").show()
            // $("#password_confirmation_error").hide()
            // $("#password_confirmation_check").hide()
            $(this).removeClass('is-valid').removeClass('is-invalid')
            correct_password_confirmation = 0
            console.log('campo password vacio')
        }
        /* check if password and password_confirmation fields are equals */
        if (correct_password == 1 && correct_password_confirmation == 1 && password_confirmation === password) {
            console.log('contraseñas iguales')
            $("#password_alert").hide()
            $("#password_success").show()
            $("#password_mismatch").hide()
        } else {
            console.log('contrasñas no coinciden')
            $("#password_alert").hide()
            $("#password_mismatch").show()
            $("#password_success").hide()
            if (!password && !password_confirmation) {
                $("#password_alert").show()
                $("#password_success").hide()
                $("#password_mismatch").hide()
            }
        }
    })
    /*  CURP/ID validation */
    $("#input_identificator").on('input', function () {
        identificator = this.value
        if (identificator) {
            if (validateIdentificator(identificator)) {
                console.log('curp valido')
                // $("#identificator_check").show()
                // $("#identificator_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                console.log('curp no valido')
                // $("#identificator_check").hide()
                // $("#identificator_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            console.log('campo vacio')
            // $("#identificator_check").hide()
            // $("#identificator_error").hide()
            $(this).removeClass('is-valid').removeClass('is-invalid')
        }
    })
    /* weight field validation */
    $("#input_weight").on('input', function () {
        weight = this.value
        console.log('peso: ', weight)
        if (weight) {
            if (weight > 0) {
                // $("#weight_required").hide()
                // $("#weight_check").show()
                // $("#weight_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#weight_required").hide()
                // $("#weight_check").hide()
                // $("#weight_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            if (automatic_radio_btn) {
                // $("#weight_required").show()
                // $("#weight_check").hide()
                // $("#weight_error").hide()
                $(this).removeClass('is-valid').addClass('is-invalid')
            } else {
                // $("#weight_required").hide()
                // $("#weight_check").hide()
                // $("#weight_error").hide()
                $(this).removeClass('is-invalid').removeClass('is-valid')
            }
        }

    })
    /* height field validation */
    $("#input_height").on('input', function () {
        height = this.value
        if (height) {
            if (height > 0) {
                // $("#height_required").hide()
                // $("#height_check").show()
                // $("#height_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#weight_required").hide()
                // $("#weight_check").hide()
                // $("#weight_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            if (automatic_radio_btn) {
                // $("#height_required").show()
                // $("#height_check").hide()
                // $("#height_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#height_required").hide()
                // $("#height_check").hide()
                // $("#height_error").hide()
                $(this).removeClass('is-valid').removeClass('is-invalid')
            }
        }
    })
    /* birthdate field validation */
    $("#input_birthdate").on('input', function () {
        birthdate = this.value
        if (birthdate) {
            console.log('birthdate: ', birthdate)
            // $("#birthdate_check").show()
            // $("#birthdate_error").hide()
            // $("#birthdate_required").hide()
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else {
            console.log('birthdate error: ', birthdate)
            if (automatic_radio_btn) {
                // $("#birthdate_check").hide()
                // $("#birthdate_error").hide()
                // $("#birthdate_required").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            } else {
                // $("#birthdate_check").hide()
                // $("#birthdate_error").show()
                // $("#birthdate_required").hide()
                $(this).removeClass('is-valid').removeClass('is-invalid')
            }
        }
    })
    $("#input_birthdate").blur(function () {
        birthdate = this.value
        if (automatic_radio_btn && !birthdate) {
            console.log('automatic && birthdate error')
            // $("#birthdate_check").hide()
            // $("#birthdate_error").hide()
            // $("#birthdate_required").show()
        }
        if (!automatic_radio_btn && !birthdate) {
            console.log('custom && birthdate error: ', birthdate.length)
            // $("#birthdate_check").hide()
            // $("#birthdate_error").show()
            // $("#birthdate_required").hide()
        }
    })
    /* genre select validation */
    $("#select_genre").on('input', function () {
        genre = this.value
        console.log('valor de genre: ', genre)
        if (genre != -1) {
            // $("#genre_required").hide()
            // $("#genre_check").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
        }
    })
    /* psychical activity validation */
    $("#select_psychical_activity").change(function () {
        psychical_activity = this.value
        console.log('p a: ', psychical_activity)
        if (psychical_activity != -1) {
            // $("#psychical_activity_required").hide()
            // $("#psychical_activity_check").show()
            $(this).removeClass('is-invalid').addClass('is-valid')
        }
    })
    /* check changes of radio buttons for caloric requirement */
    $("#automatic_calculation").on('change', function () {
        //console.log('automatic calculation changed')
        automatic_radio_btn = $("#automatic_calculation").is(":checked")
        custom_radio_btn = $("#custom_calculation").is(":checked")
        // console.log('custom radio button: ', custom_radio_btn)
        // console.log('automatic radio button: ', automatic_radio_btn)
        updateRequiredFields(true)
    })
    $("#custom_calculation").on('change', function () {
        console.log('custom calculation changed')
        automatic_radio_btn = $("#automatic_calculation").is(":checked")
        custom_radio_btn = $("#custom_calculation").is(":checked")
        // console.log('custom radio button: ', custom_radio_btn)
        // console.log('automatic radio button: ', automatic_radio_btn)
        updateRequiredFields(false)
    })
    /* check if caloric requiremnt is checked as custom or automatic */
    
    
    console.log('custom radio button: ', custom_radio_btn)
    console.log('automatic radio button: ', automatic_radio_btn)

    /* check for changes in caloric_requirement input field */
    if (custom_radio_btn) {
        $("#input_caloric_requirement").on('input', function () {
            let caloric_requirement_val = this.value
            if (caloric_requirement_val && caloric_requirement_val > 0) {
                // $("#caloric_requirement_required").hide()
                // $("#caloric_requirement_check").show()
                // $("#caloric_requirement_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else if (caloric_requirement_val && caloric_requirement_val <= 0) {
                // $("#caloric_requirement_required").hide()
                // $("#caloric_requirement_check").hide()
                // $("#caloric_requirement_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            } else {
                // $("#caloric_requirement_required").show()
                // $("#caloric_requirement_check").hide()
                // $("#caloric_requirement_error").hide()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        })
    }
    /* input waist size validation */
    $("#input_waist_size").on('input', function () {
        waist_size = this.value
        if (waist_size) {
            if (waist_size > 0) {
                // $("#waist_size_check").show()
                // $("#waist_size_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#waist_size_check").hide()
                // $("#waist_size_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            // $("#waist_size_check").hide()
            // $("#waist_size_error").hide()
            $(this).removeClass('is-valid').removeClass('is-invalid')
        }
    })
    /* input_legs_size validation */
    $("#input_legs_size").on('input', function () {
        legs_size = this.value
        if (legs_size) {
            if (legs_size > 0) {
                // $("#waist_size_check").show()
                // $("#waist_size_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#waist_size_check").hide()
                // $("#waist_size_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            // $("#waist_size_check").hide()
            // $("#waist_size_error").hide()
            $(this).removeClass('is-valid').removeClass('is-invalid')
        }
    })
    /* input wrist size validation */
    $("#input_wrist_size").on('input', function () {
        wrist_size = this.value
        if (wrist_size) {
            if (wrist_size > 0) {
                // $("#waist_size_check").show()
                // $("#waist_size_error").hide()
                $(this).removeClass('is-invalid').addClass('is-valid')
            } else {
                // $("#waist_size_check").hide()
                // $("#waist_size_error").show()
                $(this).removeClass('is-valid').addClass('is-invalid')
            }
        } else {
            // $("#waist_size_check").hide()
            // $("#waist_size_error").hide()
            $(this).removeClass('is-valid').removeClass('is-invalid')
        }
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
        //caloric_requirement = $("#input_caloric_requirement").val()
        waist_size = $("#input_waist_size").val()
        legs_size = $("#input_legs_size").val()
        wrist_size = $("#input_wrist_size").val()
        /* avatar image */
        // console.log('data: ', data)
        // return
        if (!name || !last_name || !email || !validateEmail(email)) {
            console.log('falta algún campo')
            return
        }
        if(identificator && !validateIdentificator(identificator)) {
            $("#input_identificator").removeClass('is-valid').addClass('is-invalid')
            $("#input_identificator").trigger('focus')
            return
        }

        if (automatic_radio_btn) {

            if (!weight || weight <= 0 || !height || height <= 0 || !birthdate || genre == -1 || psychical_activity == -1) {
                console.log('calculo automatico: falta algún campo')
                return
            }
            if(waist_size && waist_size <= 0) {
                console.log('invalid waist_size')
                $("#input_waist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_waist_size").trigger('focus')
                return
            }
            if(legs_size && legs_size <= 0) {
                console.log('invalid legs_size')
                $("#input_legs_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_legs_size").trigger('focus')
                return
            }
            if(wrist_size && wrist_size <= 0) {
                console.log('invalid wrist_size')
                $("#input_wrist_size").removeClass('is-valid').addClass('is-invalid')
                $("#input_wrist_size").trigger('focus')
                return
            }
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
                automatic_calculation: 1,
            }
        } else {
            let caloric_requirement = $("#input_caloric_requirement").val()
            if (!caloric_requirement || caloric_requirement <= 0) {
                console.log('calculo personalizado: falta requerimiento calórico')
                $("#input_caloric_requirement").trigger('focus')
                return
            }
            if(waist_size && waist_size <= 0) {
                console.log('invalid waist_size')
                $("#input_waist_size").trigger('focus')
                return
            }
            if(legs_size && legs_size <= 0) {
                console.log('invalid legs_size')
                $("#input_legs_size").trigger('focus')
                return
            }
            if(wrist_size && wrist_size <= 0) {
                console.log('invalid wrist_size')
                $("#input_wrist_size").trigger('focus')
                return
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
                automatic_calculation: 0,
            }

        }
        console.log('data: ', data)
        let user_update_route = $("#user_update_route").val()
        let home_route = $("#home_route").val()
        /* disable button until ajax response */
        $("#create_user_btn").attr('disabled', true)
        $.ajax({
            type: 'POST',
            url: user_update_route,
            data: data,
            success: function (data) {
                console.log('success: ', data)
                if (data.status == 'error') {
                    showErrorMessage(data.message)
                    console.log('exception: ', JSON.stringify(data.exception))
                } else if (data.status == 'success') {
                    /* disable create_user_btn */
                    $("#update_user_btn").attr('disabled', true)
                    $("#create_user_btn").attr('disabled', true)
                    showSuccessMessage(data.message)
                    /* reload page */
                    setTimeout(() => {
                        location.reload()
                    }, 5000)
                }
            },
            error: function (data) {
                console.log('error: ', data)
                showErrorMessage(data.message)
            }
        })

    })

})