jQuery(function () {
    const menu_id = $("#menu_id").val();
    console.log('menu_id: ' + menu_id);
    /* csrf token to ajax requests */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let msg = '';
    /* click on copy to clipboard */
    $("#copy_to_clipboard").on('click', function () {
        const ct = document.getElementById("modal_text_area");
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
    $('#recomendationsModal').on('hide.bs.modal', function (e) {
        console.log('modal cerrado');
        $("#modal_text_area").val('');
    });
    /* query to know foods with more nutrients depending on id */
    const topFoods = (id, menu_id) => {
        const url = "/foodswithmorenutrients/" + id + "/" + menu_id;
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                insertData(data[0], data[1]);
            },
            error: function (data) {
                console.log('error: ' + JSON.stringify(data));
            }
        })
    }
    /* insert data in modal and then display it */
    const insertData = (title, data) => {
        $("#modal_title").text(title);
        //$("#modal_text_area").empty();
        for (let i = 0; i < data.length; i++) {
            let obj = data[i];
            /* check how to manage properties: */
            msg += (i + 1) + '. ' + obj.name + ': ' + obj.amount + ', \n';
        }
        $("#modal_text_area").val(msg);
        msg = '';
        $("#recomendationsModal").modal('show');
    }
    /* action on clicked row table */
    $("table tr").on('click', function () {
        console.log('clic en table');
        let id = $(this).attr('id');
        topFoods(id, menu_id);
    })
});