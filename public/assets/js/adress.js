var setform = $("#adress_input_select").val();

$("#adress_input_select").on('change',function(e){
    e.preventDefault();
    var setform = $("#adress_input_select").val();
        if (setform == 0) {
            var valeur = ['adrNumber','adrZipCode','adrCity','adrAddInfo','adrStreet','id']
            var stopfor = valeur.length;
            for(let i = 0; i < stopfor;i++){
            $(`#adress_form_${[valeur[i]]}`).val(``)
            $('#adress_form_save').html("Enregistrer");
            }
        }
        else if (setform != 0) {
            $.ajax({
                url: "/profil",
                type: "POST",
                data: {setform: setform},
                success: function(data) {
                    var valeur = ['adrNumber','adrZipCode','adrCity','adrAddInfo','adrStreet','id']
                    var stopfor = valeur.length;
                    for(let i = 0; i < stopfor;i++){
                    $(`#adress_form_${[valeur[i]]}`).val(`${data[0][valeur[i]]}`)
                    }
                    $('#adress_form_save').html("Modification");
                },
                error: function(xhr, status, error) {
                    console.log('erreur')
                }
            });
    }
})

