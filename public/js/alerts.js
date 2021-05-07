function showSuccessMessage(msg) {
    $("#success_alert").empty();
    $("#success_alert").append('<span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span><strong>¡' + msg + '! </strong>');
    $("#success_alert").show();
    setTimeout(function () {
        $("#success_alert").hide();
    }, 10000);
    console.log('function success');
}

function showErrorMessage(msg) {
    $("#error_alert").empty();
    $("#error_alert").append('<span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span><strong>¡' + msg + '! </strong>');
    $("#error_alert").show();
    setTimeout(function () {
        $("#error_alert").hide();
    }, 10000);
    console.log('function error');
}