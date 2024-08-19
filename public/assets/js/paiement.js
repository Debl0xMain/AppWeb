const hide_all = () => {
    $('#card_section').hide();
    $('#paypal_section').hide();
    $('#bitcoin_section').hide();
    $('#gift_section').hide();
}
hide_all();

$('.btn_press').on('click', function(e) {
    e.preventDefault();
    var select_pay = $(this).attr('id');
    var select_pay_moyen = select_pay.replace(/_/, '_section');
    $('#card_section').hide();
    $('#paypal_section').hide();
    $('#bitcoin_section').hide();
    $('#gift_section').hide();

    $(`#${select_pay_moyen}`).show();
});

$('#send_data_paiement').on('click', function(e) {
    if($('#flexCheckChecked').is(':checked')){
        paiement = true
    }
    else {
        paiement = false
    }
    $.ajax({
        url: "/sys_paie",
        type: "POST",
        data: {paiement: paiement},
        success: function(data) {
            if (data == 'true') {
                localStorage.setItem('dataToSend', JSON.stringify({ key: 'true' }));
            } else {
                localStorage.setItem('dataToSend', JSON.stringify({ key: 'false' }));
            }
        },
        error: function(xhr, status, error) {
            alert('réessaye')
        }
    });
    function maFonction() {
        window.close()
    }


    setTimeout(maFonction, 5000);
});