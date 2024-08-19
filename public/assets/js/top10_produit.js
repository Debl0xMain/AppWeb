
$('#select_type_top').on('change',function(e){
    e.preventDefault();
    var i = $('#select_type_top').val()
    // CA
    if(i == "1"){
        $('#switch_quantity').hide()
        $('#switch_price').show()
    }
    // Quantite
    if(i == "2"){
        $('#switch_price').hide()
        $('#switch_quantity').show()
    }
    if (i == 0) {
        $('#switch_price').hide()
        $('#switch_quantity').hide()
    }
})
$('#switch_price').hide()
$('#switch_quantity').hide()

$("#select_year_top_produit").on('change',function(e){
    e.preventDefault();
    var select_year_top_produit = $("#select_year_top_produit").val();

    $.ajax({
        url: "/ajax_year_top_produit",
        type: "POST",
        data: {select_year_top_produit: select_year_top_produit},
        success: function(data) {
            top_product_ajax_reponse = JSON.parse(data);
            //tableau top10
            top10_price_ajax = top_product_ajax_reponse.top10_price
            top10_quantity_ajax = top_product_ajax_reponse.top10_quantity

                //show or hide
                var i = $('#select_type_top').val()
                // CA
                if(i == "1"){
                    $('#switch_quantity').hide()
                    $('#switch_price').show()
                }
                // Quantite
                if(i == "2"){
                    $('#switch_price').hide()
                    $('#switch_quantity').show()
                }
                if (i == 0) {
                    $('#switch_price').hide()
                    $('#switch_quantity').hide()
                }
            // check table
                let for_quantity = top10_quantity_ajax.length - 1
                let for_price = top10_price_ajax.length - 1
           // Show result in twig
                $('#top10_quantity').html(' ');
                $('#top10_price').html(' ');
                for(let x = 0;x<=for_quantity;x++){
                    $('#top10_quantity').append(`<p class='border case_height'>${top10_quantity_ajax[x]["proName"]}</p>`)
                };
                for(let x = 0;x<=for_price;x++){
                    $('#top10_price').append(`<p class='border case_height'>${top10_price_ajax[x]["proName"]}</p>`)
                };

        },
        error: function(xhr, status, error) {
            console.log('Refresh Page | Ajax Erreur')
        }
    });
})