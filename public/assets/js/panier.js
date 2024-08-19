// Gestion Quantity/Delete
$('.quantity_add').click(function(){
    value = $(this).attr("value");
    var quantity = "+";
    modif_quantity(quantity,value);
  });
$('.quantity_sup').click(function(){
    value = $(this).attr("value");
    var quantity = '-';
    modif_quantity(quantity,value);
});
$('.ligne_del').click(function(){
    value = $(this).attr("value");
    var quantity = 'del';
    modif_quantity(quantity,value);
  });

// Ajax Request modif quantity
function modif_quantity(quantity, value) {
    $.ajax({
        url: "/panier_quantity",
        type: "POST",
        data: {quantity: quantity,value : value},
        success: function(data) {
            var new_quantity = data['quantity'];
            var recive_data_price = data['price_user'];
            var calcul_new_price = recive_data_price * new_quantity;
            var new_price = calcul_new_price.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €';
            
            //html change
            $(`#quantity_${value}`).html(new_quantity)
            $(`#quanity_price_${value}`).html(new_price)

            var cmd_price = parseFloat($('#input_total_price').val(),2)

            if(quantity == 'del' || new_quantity == 0){
                $(`.ligne_panier_${data['id_del']}`).children().remove();
            }
            
            var prix_total = data['prix_total']
            var prix_tva = parseFloat(prix_total )* 1.20
            var tva =  parseFloat(prix_total) * 1.20 -  parseFloat(prix_total)

            $('#input_tva_view_client').html('')
            var write_html_tva = tva.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €';
            $('#input_tva_view_client').html('Tva : ' + write_html_tva)

            $('#input_ttc_view_client').html('')
            var write_html_ttc =  prix_tva.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €';
            $('#input_ttc_view_client').html('Prix Panier TTC : ' +write_html_ttc)

            var write_html = data['prix_total'].toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + ' €';
            $('#input_total_price_view_client').html(' ');
            $('#input_total_price_view_client').html('Prix Panier Ht : ' + write_html);

        },
        error: function(xhr, status, error) {
            console.log(xhr, status, error)
        }
    });
}



// Ajout Panier
/*
<article class="row text-center ligne_panier_{{ panier.id }}">
                  {% for product in product %}
                  {% if product == panier.Products %}
                  <div class="col">
                      <img src={{ asset('assets/product/' ~ product.proPictureName ) }} alt={{ product.proName }} style="height:50px; width:50px;">
                  </div>
                  <p class="col">{{ product.proName }}</p>
                  {% endif %}
                  {% endfor %}
                  <p class="col">{{ panier.PriceUser|number_format(2, ',', ' ' ) }} €</p>
                  <div class='col row text-center'>
                      <p class="row" id='quantity_{{ panier.id }}'>{{ panier.QuantityProduit }}</p>
                      <div class="row">
                          <button class="col-sm btn btn-outline-secondary sup_quantity quantity_sup" value={{panier.id}}>-</button>
                          <button class="col-sm btn btn-outline-primary add_quantity quantity_add" value={{panier.id}}>+</button>
                      </div>
                  </div>
                  {% set price_ligne = panier.PriceUser * panier.QuantityProduit %}
                  <p class="col" id='quanity_price_{{ panier.id }}'>{{ price_ligne|number_format(2, ',', ' ' )}} €</p>
                  <div class="col">
                      <button class="col-sm btn btn-outline-danger ligne_del" value={{panier.id}}>
                          <i class="fa-solid fa-trash"></i>
                      </button>
                  </div>
                <hr class="my-2">
            </article>
*/