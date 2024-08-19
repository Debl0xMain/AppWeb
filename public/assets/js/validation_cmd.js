var load_check = 0
var sec_send = 0
// Add new adress | open modal
$("#adress_cmd_valid_livraison").on('change',function(e){
    e.preventDefault();
    var select = $('#adress_cmd_valid_livraison').val();

    if(select == 'new'){
        $('#add_adress_cmd_modal').modal('show')
    }
})
$("#adress_cmd_valid_facturation").on('change',function(e){
    e.preventDefault();
    var select = $('#adress_cmd_valid_facturation').val();

    if(select == 'new'){
        $('#add_adress_cmd_modal').modal('show')
    }
})
$("#adress_cmd_close_modal").on('click',function(e){
        $('#add_adress_cmd_modal').modal('hide')
})

$("#paiement_btn_close_modal").on('click',function(e){
    $('#paiement_modal').modal('hide')
})
// set adress fact yes or not
$('#disabled_facturation').on('click',function(e){
    // actif
    if($('#disabled_facturation').is(':checked')) {
        $('#adress_cmd_valid_facturation').removeAttr('disabled');
    }
    // Inactif
    if(!$('#disabled_facturation').is(':checked')) {
        $('#adress_cmd_valid_facturation').attr('disabled', 'disabled');
    }
})
$('.livraison_plusieurs').on('click',function(e){
    var id_livraison = $(this).val();
    // actif
    if($(this).is(':checked')) {
        $(`#div_selection_date_qte_${id_livraison}`).removeAttr('hidden');
    }
    // Inactif
    if(!$(this).is(':checked')) {
        $(`#div_selection_date_qte_${id_livraison}`).attr('hidden', 'hidden');
    }
})
var quantity_table = {}
const create_new_setlivraison = (quantity_receive_f,id_panier_receive_f) =>{

        // recup info dom
        var quantity_receive = quantity_receive_f;
        var id_panier_receive = id_panier_receive_f;
        // recup id panier and number input
        var sup_start_receive = id_panier_receive.replace(/qte_for_livraison_/, '');
        var id_panier = sup_start_receive.replace(/_\d/, '');
        var number_js = sup_start_receive.replace(/\d_/, '');
        var quantite_max_receive_0 = $(`.quantity_${id_panier}`).attr('id');
        var max_quantity = quantite_max_receive_0.replace(/quantity_\d_/, '');

        // create table
        if (quantity_table[id_panier] == undefined) {
            quantity_table[id_panier] = []
        }
        //add Quantity
        quantity_table[id_panier].push(parseInt(quantity_receive))

        // check eleement exist in dom
        var new_js_number = parseInt(number_js) + 1;
        var check_dom = document.getElementById('qte_for_livraison_'+id_panier+"_"+new_js_number);
        if (check_dom != null){
            for(var x = 1;x <= max_quantity;x++){
                $('.col_'+ id_panier+'_'+x).remove()
            }}
    
        var new_valeur = quantity_table[id_panier].reduce((accumulator, currentValue) => {
            return accumulator + currentValue
          },0);
    
        var new_quantity = parseInt(max_quantity) - parseInt(new_valeur);
        if (new_quantity === 0 || quantity_receive === max_quantity || quantity_receive == 0){
            quantity_table[id_panier] = [];
            return
        }
    
        function generateArticle(id_panier, new_js_number) {
            var article = $('<article>').addClass('col').addClass('col_' + id_panier + '_' + new_js_number);
            var quantityParagraph = $('<p>').text('Quantité');
            var quantitySelect = $('<select onChange="js_select(this.value,this.id);">').addClass('qte_date_receive_info').attr({
                'name': 'qte_for_livraison_' + id_panier + '_' + new_js_number,
                'id': 'qte_for_livraison_' + id_panier + '_' + new_js_number
            });
            var deliveryDateDiv = $('<div>').attr('id', 'date_livrasion_program_' + id_panier + '_' + new_js_number);
            var deliveryDateParagraph = $('<p>').text('Date de livraison programmée : ');
            var deliveryDateInput = $('<input>').attr({
                'type': 'date',
                'name': 'date_for_livraison_' + id_panier + '_' + new_js_number,
                'id': 'date_for_livraison_' + id_panier + '_' + new_js_number
            });
            for(var i = 0;i <= new_quantity;i++){
                var selectOption = $('<option/>').val(i)
                selectOption.text(i)
                quantitySelect.append(selectOption)
            }
    
            deliveryDateDiv.append(deliveryDateParagraph, deliveryDateInput);
            article.append(quantityParagraph, quantitySelect, deliveryDateDiv);

            return article;
        }
        var generatedArticle = generateArticle(id_panier, new_js_number);
        $(`#div_selection_date_qte_${id_panier}`).append(generatedArticle);
}

const js_select = (value,id) => {
    var quantity_receive = value;
    var id_panier_receive = id;
    if(value == 0){
        var col_delete = id_panier_receive.replace(/qte_for_livraison_/, '');
        $(`.col_${col_delete}`).remove();
        var id_select = col_delete.replace(/_\d/, '');
        var input_max = $(`#qte_produit_max_cmd_${id_select}`).text()

        //sup element append this element
        var set_y = col_delete.replace(/\d_/, '');
        for(y = set_y;y <= parseInt(input_max);y++ ){
            var stop = document.getElementsByClassName(`.col_${id_select}_${y}`)
            if(stop.length === 0){
                $(`.col_${id_select}_${y}`).remove()
            }
        }
    }
     create_new_setlivraison(quantity_receive,id_panier_receive)
}

$(".qte_date_receive_info").on('change',function(e){
    var quantity_receive = $(this).val();
    var id_panier_receive = $(this).attr('id');
    var sup_start_receive = id_panier_receive.replace(/qte_for_livraison_/, '');
    var id_panier = sup_start_receive.replace(/_\d/, '');
    var quantite_max_receive_0 = $(`.quantity_${id_panier}`).attr('id');
    
    for(y = 0;y <= parseInt(quantite_max_receive_0);y++ ){
            $(`.col_${id_select}_${y}`).remove()
    }
    quantity_table[id_panier] = []
    create_new_setlivraison(quantity_receive,id_panier_receive)
});

// Paiement // 

const openWindow = () => {

    myWindow = window.open("/paiement", "_blank", "width=900,height=900");
    setInterval(checkWindow, 5000);
  }
const redirect_home = () => {

    document.location.href="/";
  }

$("#request_valid_paiement").on('click',function(e){

    $('#paiement_set_info').hide();
    $('#attente_receive_data').removeAttr('hidden')
    openWindow()
    
});


const send_data_vld_cmd = () => {
    // adress selectionne
    var livraison_ok = 0;
    var id_adresse_livraison = $('#adress_cmd_valid_livraison').val()
    var id_adress_facturation = null
    if($('#disabled_facturation').is(':checked')){
        id_adress_facturation = $("#adress_cmd_valid_facturation").val()
    }

    // Nombre d'article differant dans le panier
    var nbr_ligne_panier = $('#nbr_ligne_for_info').val()

    info_livraison = [];
    // Id panier si livraison plusieur fois
    for(let y = 0;y <= nbr_ligne_panier;y++){
        if($(`#livraison_plusieurs_${y}`).is(':checked')){
            // id de la ligne qui commande en plusieur fois
            var id_panier = $(`#livraison_plusieurs_${y}`).val()
                // recuperation de la quantite max : 
                var qte_max = $(`#qte_produit_max_cmd_${id_panier}`).val();
                // recuperation valeur
                for(let x = 0;x < qte_max;x++){
                    // verif exist : 
                    if($(`.col_${id_panier}_${x}`).length == 1){
                        // Quantite
                        var qte_livraison = parseInt($(`#qte_for_livraison_${id_panier}_${x}`).val());
                        if (isNaN(qte_livraison)){
                            qte_livraison = 0
                        }
                        // a cette date
                        var date_livraison = $(`#date_for_livraison_${id_panier}_${x}`).val();
                        //id du produit
                        var id_produit = $(`#id_produit_for_table_${id_panier}`).val()
                        // id panier
                        var id_panier_cmd = $(`#livraison_plusieurs_${y}`).val()
                        var inset_tableau = {
                            qte: qte_livraison,
                            date: date_livraison,
                            id_panier:id_panier_cmd,
                            id_produit:id_produit
                        }
                        $(`.date_invalid_${id_panier}_${x}`).text(' ')

                        //Verif date
                        if (typeof inset_tableau.date === 'undefined' || inset_tableau.date == "") {
                            if($(`#date_livrasion_program_${id_panier}_${x}`).length == 1 ){ 
                                var erreur_date = $('<p>').text('Selectionne une date valide')
                                erreur_date.addClass(`date_invalid_${id_panier}_${x}`)
                                erreur_date.css('color','red')
                                $(`#date_livrasion_program_${id_panier}_${x}`).append(erreur_date)
                                livraison_ok++;
                            }
                        }
                        //Calcul QteMax Atteinte
                        var total_qte_id_panier = 0;
                        for (var i = 0; i < info_livraison.length; i++) {

                            if (info_livraison[i].id_panier === id_panier && typeof info_livraison[i].qte !== "undefined" && typeof info_livraison[i].qte !== NaN) {
                                total_qte_id_panier += info_livraison[i].qte;
                            }
                        }
                        // Verif
                        // Verif qte bien distibué
                        if(total_qte_id_panier != qte_max && i == qte_max){
                            var test_qte = $('<p>').text('Il reste des produits non inclus dans une livraison')
                            test_qte.addClass(`date_invalid_${id_panier}_${x}`)
                            test_qte.css('color','red')
                            $(`.col_${id_panier}_0`).prepend(test_qte)
                            livraison_ok++;

                        }
                        if(livraison_ok === 0){
                            info_livraison.push(inset_tableau)
                        }
                    }
                }
        }
    }
    $('#erreur_msg').remove()
    $('#erreur_adress').remove()

    if($('#adress_cmd_valid_livraison').val() == 0 || $('#adress_cmd_valid_livraison').val() == null || $('#adress_cmd_valid_livraison').val() == 'new'){
        var erreur_adress_id = $('<p>').text('Selectionne une adresse')
        erreur_adress_id.css('color','red')
        erreur_adress_id.attr('id','erreur_adress')
        $('#erreur_adress_id').append(erreur_adress_id)
        livraison_ok++;
    }
    if(livraison_ok != 0 ){
        var text_erreur_liv = $('<p>').text('Veuillez remplir les champs !')
        text_erreur_liv.addClass('erreur_msg text-center')
        text_erreur_liv.attr('id','erreur_msg')
        text_erreur_liv.css('color','red')
        $('#select_command_liv').prepend(text_erreur_liv)
        info_livraison = []
        info_livraison.push(false)
        return info_livraison;
    }
    if(livraison_ok === 0){
        info_livraison.push(true)
        return info_livraison;
    }

}

$('#paiement_btn').on('click',function(e){

    if(send_data_vld_cmd().includes(true)){
        $('#paiement_modal').modal('show')
    }
    if(send_data_vld_cmd().includes(false)){
        return
    }
})

const checkWindow = () => {
    if (myWindow && !myWindow.closed) {
      
    } 
    else {
        var storedData = localStorage.getItem('dataToSend');
        if (storedData) {
            var receivedData = JSON.parse(storedData);
            $('#paiement_set_info').show();
            $('#attente_receive_data').hide();
            if(receivedData.key == 'true'){
              //
              if(sec_send == 0){
                  sec_send++;
                  if(send_data_vld_cmd().includes(true)){
                    //Recup Adress
                    var adress_livraison = $('#adress_cmd_valid_livraison').val();
                    var adress_facturation = $('#adress_cmd_valid_livraison').val()
                    if($('#disabled_facturation').is(':checked')){
                        var adress_facturation = $('#adress_cmd_valid_facturation').val()
                    }

                    var info_livraison = send_data_vld_cmd();
                    info_livraison.pop();
                      $.ajax({
                      url: "/aff_tab",
                      type: "POST",
                      data: {info_livraison:info_livraison,adress_livraison:adress_livraison,adress_facturation:adress_facturation},
                      success: function(data) {
                              $('#paiement_set_info').html(' ')
                              var text = $('<p>').text('Paiement Validé.');
                              text.css('color','green')
                              $('#paiement_set_info').append(text)
                              var redirect = $('<p>').text('Redirection en cours');
                              $('#paiement_set_info').append(redirect)
                          var spinner = $('<div>', {
                              'class': 'spinner-border',
                              'role': 'status'
                          });
                          var span = $('<span>', {
                              'class': 'visually-hidden',
                              text: 'Redirection en cours'
                          });
                          spinner.append(span);
                          $('#paiement_set_info').append(spinner);
                              setTimeout('redirect_home()', 10000)
                          },
                          error: function(xhr, status, error) {
                              alert('Problème lié a la commande Merci de contacte notre sav | Code AJ001')
                          }
                      });
                  }
                  if(send_data_vld_cmd().includes(false)){
                    alert('Problème lié a la commande Merci de contacte notre sav | Code TB001')
                  }
              }            
            }
            else{
                $('#paiement_set_info').html(' ')
                var text = $('<p>').text('Un problème de paiement a été détecté.');
                text.css('color','red')
                $('#paiement_set_info').append(text)
            }
        } 
        else {
            $('#paiement_set_info').html(' ')
            var text = $('<p>').text('Un problème de paiement a été détecté.');
            text.css('color','red')
            $('#paiement_set_info').append(text)
        }
    }
  }