jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* on change of select account type */
    $("#account_type").on('change', function () {
        account_type = this.value
    });

    /* check if email has a correct format */
    let validateEmail = (email) => {
        var re = /\S+@\S+\.\S+/
        return re.test(email)
    }
    /* check if CURP/ID field has a correct format */
    let validateIdentificator = (identificator) => {
        let re = /^([A-Z]{4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}[0-9A-Z]\d)$/i
        return re.test(identificator)
    }

    /* check if inputs are correct */
    function addRemoveClass(that) {
        if (!that.value) {
            $(that).addClass('is-invalid').removeClass('is-valid')
        } else {
            $(that).removeClass('is-invalid').addClass('is-valid')
        }
    }
    /* validate name and lastname */
    $("#registration_name, #registration_last_name").on('input', function () {
        addRemoveClass(this)
    })

    /* validate CURP */
    $("#registration_id").on('input', function () {
        if (this && validateIdentificator(this.value)) {
            $(this).removeClass('is-invalid').addClass('is-valid')
            $("#register_btn").removeClass('disabled').addClass('enabled')
        } else if (this && !validateIdentificator(this.value)) {
            $(this).addClass('is-invalid').removeClass('is-valid')
            $("#register_btn").removeClass('enabled').addClass('disabled')
        }
        if (this.value === '') {
            $(this).removeClass('is-invalid').removeClass('is-valid')
            $("#register_btn").removeClass('disabled').addClass('enabled')
        }
    })
    /* validate email */
    $("#registration_email").on('input', function () {
        if (this && validateEmail(this.value)) {
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else if (this && !validateEmail(this.value)) {
            console.log('curp no válida: ')
            $(this).addClass('is-invalid').removeClass('is-valid')
        }
    })

    /* validate password and password confirmation */
    $("#registration_password").on('input', function () {
        if (this.value.length >= 8) {
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid')
        }
    })
    $("#registration_password_confirmation").on('input', function () {
        if (this.value.length >= 8) {
            $(this).removeClass('is-invalid').addClass('is-valid')
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid')
        }
    })

    /* click on register button */
    $("#register_btn").on('click', function () {
        /* values from imputs */
        let name = $("#registration_name").val();
        let last_name = $("#registration_last_name").val();
        let id = $("#registration_id").val();
        let email = $("#registration_email").val();
        let password = $("#registration_password").val();
        let password_confirmation = $("#registration_password_confirmation").val();
        let account_type = $("#account_type").val();
        let data = {
            name,
            last_name,
            id,
            email,
            password,
            password_confirmation,
            account_type
        };
        /* action when any field(except curp or id is empty) */
        if (!name || !last_name || !email || !password || !password_confirmation || !validateEmail(email)) {
            $("#empty_inputs_alert").addClass("alert alert-warning")
            return;
        }
        /* ajax request to create account */
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "/register",
            data: data,
            beforeSend: function () {
                $("#register_btn").addClass('disabled')
            },
            success: function (data) {
                if (data.status == 'error') {
                    showErrorMessage(data.message);
                    $("#register_btn").hide()
                    $("#reolad_page_btn").show()
                }
                if (data.status == 'success') {
                    showSuccessMessage(data.message);
                    setTimeout(() => {
                        window.location.replace("/login")
                    }, 10000);
                }
            },
            error: function (data) {
                showErrorMessage('error ', data.exception);
            }
        });
    });
});
