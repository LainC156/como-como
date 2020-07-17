$(document).ready(function() {
    console.log('document ready');
    let menu_id = $("#menu_id").val();
    console.log('menu_id: ' + menu_id);
    /* csrf token to ajax requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let msg = '';
    /* click on copy to clipboard */
    $("#copy_to_clipboard").click(function() {
        //$("#modal_body").text();
        var ct = document.getElementById("modal_text_area");
        ct.select();
        ct.setSelectionRange(0, 99999); /* for mobile devices */
        document.execCommand("copy");
        console.log('texto copiado: ' + ct.value);
        $("#text_copied_alert").show();
        setTimeout(() => {
            $("#text_copied_alert").hide();
        }, 5000);
    });
    /* actions on closed modal */
    $('#recomendationsModal').on('hide.bs.modal', function(e) {
        console.log('modal cerrado');
        $("#modal_text_area").val('');
    });
    /* query to know foods with more nutrients depending on id */
    function topFoods(id, menu_id) {
        let url = "/foodswithmorenutrients/" + id + "/" + menu_id;
        console.log('url: ' + url);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {
                console.log('data topFoods: ' + JSON.stringify(data));
                insertData(data[0], data[1]);
                //$("#recomendationsModal").modal('show');

            },
            error: function(data) {
                console.log('error: ' + JSON.stringify(data));
            }
        })
    }
    /* insert data in modal and then display it */
    function insertData(title, data) {
        $("#modal_title").text(title);
        //$("#modal_text_area").empty();
        for (var i = 0; i < data.length; i++) {
            var obj = data[i];
            //msg += '<h5>{{ __('Nombre') }}: <span class="text-primary">'+ obj.name + '</span>, {{ __('Carbohidratos') }}: <span class="text-primary">'+ obj.carbohydrates +'</span></h5>';
            /* check how to manage properties: */
            msg += (i + 1) + '. ' + obj.name + ': ' + obj.amount + ', \n';
        }
        $("#modal_text_area").val(msg);
        msg = '';
        //$("#modal_text_area").attr('disabled', true);
        $("#recomendationsModal").modal('show');
    }
    /* action on clicked row table */
    $("table tr").click(function() {
        console.log('clic en table');
        let id = $(this).attr('id');
        topFoods(id, menu_id);
    })
});