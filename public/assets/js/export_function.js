
function chargerPanier() {
    $.ajax({
        url: "/actu/panier",
        type: 'GET',
        success: function(response) {
            $('#panier-container').html('');
            $('#panier-container').html(response);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}
chargerPanier();
