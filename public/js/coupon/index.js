jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    /* url of display coupons */
    const coupons_data = $("#url_coupons").val()
    /* selecte coupon data */
    let coupon = {}
    /* selected users to apply some coupon */
    let users = []
    /* datatables to display coupons */
    const coupons_table = $("#coupons_table").DataTable({
        "pageLength": 25,
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        "order": [[1, "desc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: coupons_data,
            type: 'GET',
        },
        columns: [
            { data: 'identificator', name: 'identificator' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'code', name: 'code' },
            {
                data: 'used',
                name: 'used',
                render: function (data, type, full, action) {
                    switch (full.used) {
                        case false:
                            return $("#false").val();
                        case true:
                            return $("#true").val();
                        case '0':
                            return $("#false").val();
                        case '1':
                            return $("#true").val();
                    }
                },
                searchable: true,
                orderable: true,
            },
            { data: 'days', name: 'days' },
            { data: 'user_id', name: 'user_id' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
        ]
    })
    /* function to clean all inputs of create cupons modal */
    const clearModalInputs = (success, message) => {
        success ? showSuccessMessage(message) : showErrorMessage(message)
        $("#createCouponModal").modal('hide')
        $("#coupon_name, #coupon_description, #coupon_days, #coupon_amount").val('')
        $("#create_coupon_btn").attr('disabled', false)
        location.reload()
    }
    /* request to create new coupon(s) */
    $("#create_coupon_btn").on('click', function () {
        /* validate fiels */
        const name = $("#coupon_name").val()
        const description = $("#coupon_description").val()
        const amount = $("#coupon_amount").val()
        const days = $("#coupon_days").val()
        if (!name || !description || !amount || !days) {
            console.log('todos los campos son requeridos')
            return
        }
        const data = {
            name,
            description,
            amount,
            days
        }
        $(this).attr('disabled', true)
        /* make request to create new coupons */
        $.ajax({
            data: data,
            dataType: 'json',
            type: 'POST',
            url: $("#store_coupons").val(),
            success: function (data) {
                console.log('data success: ', data)
                data.status === 'success' ? clearModalInputs(true, data.message) : clearModalInputs(false, data.message)
            },
            error: function (data) {
                console.log('data error: ', data)
                clearModalInputs(false, data.responseJSON.message)
            }
        })
    })
    /* coupons table events 
    $('#coupons_table tbody').on('click', 'tr', 'a', function () {
        let row_data = coupons_table.row(this).data()
        console.log('data: ', row_data)
    }) */
    /* action on select_coupon_next_btn click */
    $("#select_coupon_next_btn").on('click', function () {
        console.log('saludos')
        $("#progress_span_text").text('33%')
        $("#progress_span_percent").width('33%')
        $("#select_coupon_row").attr('hidden', true)
        $("#select_users_row").attr('hidden', false)
        $("#back_user_btn").attr('hidden', false)
        $("#next_user_btn").attr('hidden', false)
    })
    /* click on back_user_btn */
    $("#back_user_btn").on('click', function () {
        $("#select_coupon_row").attr('hidden', false)
        $("#excesiveUsers").attr('hidden', true)
        $('input:checkbox').attr('checked', false)
        $("#select_users_row").attr('hidden', true)
        $("#back_user_btn").attr('hidden', true)
        $("#next_user_btn").attr('hidden', true)
        $("#progress_span_text").text('0%')
        $("#progress_span_percent").width('0%')
    })
    $(".coupon").on('input', function () {
        console.log('algun radio button')
        if ($(this).is(':checked')) {
            coupon.id = $(this).data('id')
            coupon.name = $(this).data('name')
            coupon.description = $(this).data('description')
            coupon.total = $(this).data('total')
            console.log('algun cupón seleccionado: ', coupon)
            $("#select_coupon_next_btn").attr('disabled', false)
        }
    })
    $(".user").on('input', function () {
        if ($(this).is(':checked')) {
            $("#next_user_btn").attr('disabled', false)
            users.push({
                id: $(this).data('id'), name: $(this).data('name'), last_name: $(this).data('last_name'),
                email: $(this).data('email')
            })
            console.log('hay mas de un usuario: ', users)
            $("#excesiveUsers").attr('hidden', users.length > coupon.total ? false : true)
            $("#next_user_btn").attr('disabled', users.length > coupon.total ? true : false)
        } else {
            if (users.length === 0) {
                $("#next_user_btn").attr('disabled', true)
            }
            users = users.filter(user => user.id !== $(this).data('id'))
            $("#excesiveUsers").attr('hidden', users.length > coupon.total ? false : true)
            $("#next_user_btn").attr('disabled', users.length > coupon.total ? true : false)
            console.log('deseleccionado: ', users)
        }
    })
    $("#next_user_btn").on('click', function () {
        $("#select_users_row").attr('hidden', true)
        $("#confirmation_row").attr('hidden', false)
        $("#progress_span_text").text('66%')
        $("#progress_span_percent").width('66%')
        $(this).attr('hidden', true)
        $("#back_user_btn").attr('hidden', true)
        $("#back_confirmation_btn").attr('hidden', false)
        /* insert coupon and users data in row */
        $("#confirmation_col").append(
            '<strong class="text-info">' + "(" + coupon.total + ")" + " " + coupon.id + " / " + coupon.name + " (" + coupon.description + ")" + '</strong>'
        )
        for (i = 0; i < users.length; i++) {
            console.log('user en i: ', users[i])
            $("#confirmation_col")
                .append('<p class="text-primary">' + users[i].name + " " + users[i].last_name + " (" + users[i].email + ")" + '</p>')
        }
        $("#send_coupons_btn").attr('disabled', users.length > coupon.total ? true : false)
    })
    $("#back_confirmation_btn").on('click', function () {
        $("#confirmation_row").attr('hidden', true)
        $("#select_users_row").attr('hidden', false)
        $("#back_user_btn").attr('hidden', false)
        $("#next_user_btn").attr('hidden', false)
        $("#back_confirmation_btn").attr('hidden', true)
        $("#confirmation_col").empty()
        $("#send_coupons_btn").attr('disabled', true)
    })
    /* make request to send coupon to users via email */
    $("#send_coupons_btn").on('click', function () {
        console.log('here we go again')
        const data = {
            coupon,
            users
        }
        // console.log('data: ', data)
        // return
        $.ajax({
            data: data,
            dataType: 'json',
            type: 'POST',
            url: $("#send_coupon_url").val(),
            beforeSend: function () {
                $("#loader").attr('hidden', false)
                $("#send_coupons_btn").attr('hidden', true)
            },
            complete: function () {
                $("#loader").attr('hidden', true)
            },
            success: function (data) {
                if (data.status === 'success') {
                    console.log('success fn')
                    $("#progress_span_text").text('100%')
                    $("#progress_span_percent").width('100%')
                    $("#assignCouponModal").modal('hide')
                    showSuccessMessage(data.message)
                    setTimeout(() => {
                        location.reload();
                    }, 5000);
                } else {
                    console.log('error in success fn')
                    $("#assignCouponModal").modal('hide')
                    showErrorMessage(data.message)
                    setTimeout(() => {
                        location.reload();
                    }, 5000);
                }
            },
            error: function (data) {
                console.log('error fn')
                $("#assignCouponModal").modal('hide')
                showErrorMessage(data.responseJSON.message)
                setTimeout(() => {
                    location.reload();
                }, 5000);
            }
        })
    })

    /* activate coupon when patient or nutritionist is logged */
    $("#verify_coupon_btn").on('click', function () {
        /* validate if input field is not empty */
        let code = $("#promotional_code").val()
        if (!code) {
            $("#promotional_code").addClass('is-invalid')
            return
        }
        $(this).attr('hidden', true)
        $("#activate_coupon_btn").attr('href', "/activatecoupon/" + code.replace(/\s+/g, ''))
        $("#activate_coupon_btn").attr('hidden', false)
        // console.log('sin espacios: ', code.replace(/\s+/g, ''))
        // return
        /* make request to activate coupon */
        // $.ajax({
        //     dataType: 'json',
        //     type: 'GET',
        //     url: "/activatecoupon/" + code.replace(/\s+/g, ''),
        //     beforeSend: function () {
        //         $("#loader").attr('hidden', false)
        //         $("#activate_coupon_btn").attr('hidden', true)
        //     },
        //     complete: function () {
        //         $("#loader").attr('hidden', true)
        //     },
        //     success: function (data) {
        //         console.log('fn success')
        //     },
        //     error: function (data) {
        //         console.log('fn error: ', data)
        //     }
        // })
    })
})