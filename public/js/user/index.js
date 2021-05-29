$(document).ready(function() {
    /* csrf token to ajax requests configuration */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* hide alerts of deleted user */
    if ($("#session_error_alert").is(':visible')) {
        setTimeout(() => {
            $("#session_error_alert").hide();
        }, 7000);
    }
    if ($("#session_success_alert").is(':visible')) {
        setTimeout(() => {
            $("#session_success_alert").hide();
        }, 7000);
    }
});