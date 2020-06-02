$(document).ready(function() {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* global variables */
    let msg = '';
    let lang = $('html').attr('lang');
    /* translations */


    /* on change of select account type */
    $("#account_type").on('change', function() {
        account_type = this.value;
    });



    /* validations */
    let validateEmail = (email) => {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
    
    $("#register_btn").click(function() {
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
        // console.log('account_type: ', account_type);
        // console.log('error email validation: ', validateEmail(email));
        if (!name || !last_name || !email || !password || !password_confirmation || !validateEmail(email)) {
            console.log('error in validation');
            console.log(`name: ${name}, last_name ${last_name}, id: ${id}, email: ${email}, password: ${password}, password_confirmation: ${password_confirmation}, account_type: ${account_type}`);
            return;
        }
        /* ajax request to create account */
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "/register",
            data: data,
            success: function(data) {
                if (data.status == 'error') {
                    showErrorMessage(data.message);
                }
                if (data.status == 'success') {
                    showSuccessMessage(data.message);
                }
            },
            error: function(data) {
                console.log('error: ', data.message);
                showErrorMessage('error ', data.exception);
            }
        });
    });








});
