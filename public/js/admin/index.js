jQuery(function () {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    const users_data = $("#users_list").val()
    let row_data
    console.log('saludos de admin/index: ', users_data)
    /* get data from server and display patients list with dataTables */
    const users_table = $("#users_table").DataTable({
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        "order": [[1, "desc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: users_data,
            type: 'GET',
        },
        columns: [
            // {
            //     data: 'action',
            //     name: 'action',
            //     searchable: false,
            //     orderable: false,
            // },
            { data: 'id', name: 'id' },
            { data: 'current_date', name: 'current_date' },
            { data: 'expiration_date', name: 'expiration_date' },
            { data: 'name', name: 'name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'email', name: 'email' },
            {
                data: 'subscription_status',
                name: 'subscription_status',
                render: function (data, type, full, action) {
                    console.log('stat: ', full.subscription_status)
                    switch (full.subscription_status) {
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
            {
                data: 'trial_version_status',
                name: 'trial_version_status',
                render: function (data, type, full, action) {
                    console.log('tvs: ', full.trial_version_status)
                    switch (full.trial_version_status) {
                        case '0':
                            return $("#false").val();
                        case '1':
                            return $("#true").val();
                        case false:
                            return $("#false").val();
                        case true:
                            return $("#true").val();
                    }
                },
                searchable: true,
                orderable: true,
            },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
        ]
    })
    /* getting data when row menu table is clicked */
    $('#users_table tbody').on('click', 'tr', 'a', function () {
        console.log('data: ' + JSON.stringify(users_table.row(this).data()))
        row_data = users_table.row(this).data()
        console.log('name: ' + row_data.name)
        component_id = row_data.id
        $("#username").val(row_data.name)
        $("#last_name").val(row_data.last_name)
        $("#email").val(row_data.email)
        $("#current_date").val(row_data.current_date)
        $("#expiration_date").val(row_data.expiration_date)
        row_data.subscription_status ? $("#subscription_status").attr('checked', true) : $("#subscription_status").attr('checked', false)
        row_data.subscription_status === "1" ? $("#subscription_status").attr('checked', true) : $("#subscription_status").attr('checked', false)

        row_data.trial_version_status === '1' ? $("#trial_version_status").attr('checked', true) : $("#trial_version_status").attr('checked', false)
        row_data.trial_version_status ? $("#trial_version_status").attr('checked', true) : $("#trial_version_status").attr('checked', false)
        console.log('tvs: ', row_data.trial_version_status)
        $("#editUserModal").modal('show')
    })
    /* change toggle buttons, only one must be checked */
    $("#subscription_status").on('change', function () {
        console.log('toogle ss')
        $("#trial_version_status").attr('checked', !$(this).is(':checked'))
    })
    $("#trial_version_status").on('change', function () {
        console.log('toogle tvs')
        $("#subscription_status").attr('checked', !$(this).is(':checked'))
    })
    /* update user subscription status */
    $("#update_user_btn").on('click', function () {
        let data = {}
        /* a) to update user with trial version status checked only is required user_id and update field created_at, subscription_status = 0 and trial_version_status
                and check if user has payments, then update payments.active = false
           b) to user with subscription_status checked we need current_date, expiration_date and subscription_status toggle button checked, user_id
            change user with subscription_status to trial_version_status is no possible, the best way is proccess new payment simulation(option b)
        */
        /* update to trial version status */
        if ($("#trial_version_status").is(':checked') && !$("#subscription_status").is(':checked')) {
            data = {
                trial_version_status: true,
                user_id: row_data.id,
            }
            console.log('data tvs:', data)
            /* disable update user button */
            $(this).attr('disabled', true)
            /* send request */
            $.ajax({
                data: data,
                dataType: 'json',
                type: 'POST',
                url: $("#update_user_url").val(),
                success: function (data) {
                    if (data.status === 'success') {
                        showSuccessMessage(data.message)
                        users_table.ajax.reload()
                        setTimeout(() => {
                            location.reload()
                        }, 5000)
                    } else {
                        showErrorMessage(data.message)
                        users_table.ajax.reload()
                        setTimeout(() => {
                            location.reload()
                        }, 5000)
                    }
                },
                error: function (data) {
                    showErrorMessage(data.message)
                    users_table.ajax.reload()
                    setTimeout(() => {
                        location.reload()
                    }, 5000)
                }

            })
        } else {
            /* update to subscription with payment version */
            if (!$("#current_date").val() || !$("#expiration_date").val()) {
                console.log('ambas fechas se requieren')
                return
            }
            data = {
                current_date: $("#current_date").val(),
                expiration_date: $("#expiration_date").val(),
                user_id: row_data.id
            }
            console.log('data ss:', data)
            /* disable update user button */
            $(this).attr('disabled', true)
            /* send request */
            $.ajax({
                data: data,
                dataType: 'json',
                type: 'POST',
                url: $("#update_user_url").val(),
                success: function (data) {
                    if (data.status === 'success') {
                        showSuccessMessage(data.message)
                        setTimeout(() => {
                            location.reload()
                        }, 5000)
                    } else {
                        showErrorMessage(data.message)
                        location.reload()
                    }
                },
                error: function (data) {
                    showErrorMessage(data.message)
                    setTimeout(() => {
                        location.reload()
                    }, 5000)
                }
            })
        }
    })
})